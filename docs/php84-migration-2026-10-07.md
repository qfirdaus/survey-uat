# Survey UAT PHP 8.4 Migration

Tarikh: 7 Oktober 2026

Sasaran: PHP 8.3.35 kepada PHP 8.4.26

## Baseline

- Commit: `6ccccc9435d84c059f5ee76eed8dc20f903d8876`
- Versi aplikasi: `1.10.0`
- HTTP baseline: 200
- Nginx baseline socket: `/run/php/php8.3-fpm.sock`
- Backup: `/var/www/_migration_backups/survey-uat-php84-20261007-222201`

## Artifak

- Pool: `docs/php84/survey-uat84.pool.conf`
- Nginx candidate: `docs/php84/survey-uat.nginx-php84.conf`
- Runtime probe: `docs/php84/runtime-version-probe.php`
- Cutover/rollback: `tools/php84-cutover-survey-uat.sh`

## Status

- Baseline dan backup: selesai
- Code/dependency audit: lulus
- Dual-runtime lint: lulus
- Pool PHP 8.4: dipasang dan aktif
- Pool template match: lulus
- Socket: `/run/php/survey-uat84.sock`, `www-data:www-data`, mode `0660`
- Pre-cutover HTTP baseline: 200
- Cutover: selesai; runtime probe mengesahkan PHP 8.4.26
- Nginx handlers: kedua-duanya menggunakan `/run/php/survey-uat84.sock`
- Post-cutover HTTP smoke: 200, halaman login lengkap
- Post-cutover Nginx error log: tiada error baharu
- Temporary runtime probe cleanup: lulus
- PHP 8.3-FPM: kekal aktif untuk rollback
- Acceptance test: lulus, disahkan oleh pentadbir selepas feature testing

## Keputusan

Migrasi Survey UAT kepada PHP 8.4.26 selesai dan diterima. PHP 8.3-FPM dikekalkan aktif sebagai rollback sepanjang tempoh pemerhatian.
