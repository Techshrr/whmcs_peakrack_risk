<?php
// SPDX-License-Identifier: LicenseRef-PeakRack-Proprietary

/**
 * PeakRack Risk for WHMCS
 *
 * Official repository:
 * https://github.com/Techshrr/whmcs_peakrack_risk
 *
 * Copyright (c) 2026 PeakRack. All rights reserved.
 * Unauthorized copying, modification, distribution, sublicensing, or commercial use
 * is prohibited without prior written permission.
 */

if (!defined('WHMCS')) {
    die('No direct access');
}

require_once __DIR__ . '/lib/Bootstrap.php';
require_once __DIR__ . '/lib/RiskEngine.php';
require_once __DIR__ . '/lib/Checkout.php';

add_hook('ClientAreaFooterOutput', 1, static function (array $vars): string {
    $config = peakrackRiskLoadSettings();

    if (!$config['enabled'] || !$config['checkoutEnabled'] || !peakrackCheckoutIsCheckoutPage($vars)) {
        return '';
    }

    return peakrackCheckoutScript($config, $vars);
});

add_hook('ShoppingCartValidateCheckout', 1, static function (array $vars): array {
    $config = peakrackRiskLoadSettings();

    if (!$config['enabled'] || !$config['checkoutEnabled'] || !$config['checkoutServerValidation']) {
        return [];
    }

    $checkout = $config['checkout'];
    $fieldName = (string) $checkout['fieldName'];
    $nonceFieldName = (string) $checkout['nonceFieldName'];
    $expectedValue = (string) $checkout['fieldValue'];
    $postedValue = (string) ($_POST[$fieldName] ?? ($vars[$fieldName] ?? ''));
    $postedNonce = (string) ($_POST[$nonceFieldName] ?? ($vars[$nonceFieldName] ?? ''));
    $sessionNonce = peakrackCheckoutNonce($vars);

    if (peakrackCheckoutIsSessionAcknowledged($vars)) {
        return [];
    }

    if (
        hash_equals($expectedValue, $postedValue)
        && $sessionNonce !== ''
        && hash_equals($sessionNonce, $postedNonce)
    ) {
        peakrackCheckoutMarkSessionAcknowledged($vars);
        return [];
    }

    $messages = peakrackCheckoutMessages($config, peakrackCheckoutLocale($vars));
    return [$messages['validation']];
});

add_hook('DailyCronJob', 1, static function (array $vars): void {
    $config = peakrackRiskLoadSettings();

    try {
        $summary = peakrackRiskCleanupRetention($config);
        if (array_sum($summary) > 0) {
            peakrackRiskAudit('info', 'Retention cleanup completed', $summary);
        }
    } catch (\Throwable $e) {
        peakrackRiskAudit('error', 'Retention cleanup error: ' . $e->getMessage());
    }
});

add_hook('AdminAreaFooterOutput', 1, static function (array $vars): string {
    $filename = strtolower((string) ($vars['filename'] ?? ''));
    $action = strtolower((string) ($_GET['action'] ?? ''));
    $orderId = (int) ($_GET['id'] ?? ($_GET['orderid'] ?? 0));

    if (!in_array($filename, ['orders', 'orders.php'], true) || $action !== 'view' || $orderId <= 0) {
        return '';
    }

    return peakrackRiskAdminOrderPanel($orderId, 'addonmodules.php?module=peakrack_risk');
});

add_hook('AfterFraudCheck', 1, static function (array $vars): void {
    $config = peakrackRiskLoadSettings();
    if (!$config['enabled']) {
        return;
    }

    peakrackRiskProcessOrder((int) ($vars['orderid'] ?? 0), $vars, $config, 'apply_rules');
});
