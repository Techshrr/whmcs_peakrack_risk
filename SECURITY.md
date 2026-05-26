# Security Policy

## Reporting a vulnerability

Please do not open public GitHub issues for security vulnerabilities.

Report issues involving checkout acknowledgement, risk scoring, order status changes, audit logging, or rule enforcement to:

security@peakrack.com

Please include:

- Affected addon version, WHMCS version, and PHP version
- Whether the issue affects checkout validation, post-fraud scoring, order action, admin tools, or cron cleanup
- Description of the issue and reproduction steps
- Potential impact on order review, fraud marking, or checkout enforcement
- Suggested mitigation, if available

## Supported versions

| Version | Supported |
|---|---|
| 1.x | Yes |
| < 1.0 | No |

## Sensitive data

Do not include production risk rules, thresholds, allowlists, blocklists, bypass techniques, client IP addresses, customer emails, order identifiers, WHMCS license data, admin notes, audit exports, or server logs containing customer identifiers in public reports.

## Licensing contact

Licensing, redistribution, and written-permission requests for this proprietary project should be sent to:

legal@peakrack.com

Security reports should still be sent to `security@peakrack.com`.

## Public issues

Non-sensitive documentation fixes and compatibility reports may be submitted through GitHub Issues.

Security vulnerabilities must be reported privately by email.
