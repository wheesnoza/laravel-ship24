# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

### Compatibility
- Laravel 12 compatibility verified
- PHP minimum requirement updated to 8.2
- Dependencies aligned to support Laravel 11 and 12

### Rate Limit
- Rate limit headers are captured and exposed
- Automatic backoff is applied when rate limits are hit
- Dedicated exception raised on rate limit exhaustion

### Testing
- Updated testbench to a Laravel 12 compatible version

