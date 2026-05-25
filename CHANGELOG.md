# Changelog

All notable changes to this project are documented in this file.

This project follows Semantic Versioning where practical.

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
