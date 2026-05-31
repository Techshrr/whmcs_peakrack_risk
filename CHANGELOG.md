# Changelog

All notable changes to this project are documented in this file.

This project follows Semantic Versioning where practical.

## [1.2.5] - 2026-06-01

### Added

- Added Hong Kong Traditional Chinese checkout notice text and fallback conversion for existing Simplified Chinese checkout copy.
- Added a WHMCS admin-area GitHub shortcut and browser-side update notice for published GitHub releases or tags.

### Fixed

- Replaced the admin GitHub shortcut icon with inline SVG so the button does not depend on WHMCS admin icon fonts.

### Changed

- Scoped checkout acknowledgement to the current browser session, client IP, and cart contents so a guest confirmation can continue through the same login-and-checkout flow without repeating the notice.
- Requires a new checkout acknowledgement when the browser, IP address, or cart flow changes.

## [1.2.4] - 2026-05-26

### Added

- Added order risk scoring after the WHMCS fraud check.
- Added configurable review and fraud thresholds, checkout acknowledgement, server-side acknowledgement validation, decision history, audit logs, rule version snapshots, admin order detail output, diagnostics, recent metrics, and JSON settings import/export.

### Changed

- Keeps audit data when the addon is deactivated.
- Skips repeated automatic order actions when the same rule version already processed the order.

### Security

- Uses nonce protection for checkout acknowledgement validation.
- Limits how much audit data is mirrored into the WHMCS Activity Log.
