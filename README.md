# IQS-Framework

IQS-Framework ialah platform pentadbiran dalaman berasaskan PHP untuk membina sistem organisasi yang memerlukan login berpusat, kawalan akses mengikut kumpulan, konfigurasi runtime, audit aktiviti, template emel, manual pengguna, dan sambungan pangkalan data yang boleh dikawal dari UI.

README ini hanya mendokumenkan ciri yang wujud dalam kod semasa projek ini.

## Version

- Current version: `1.7.6`
- Release history: [CHANGELOG.md](./CHANGELOG.md)
- Version file: [VERSION](./VERSION)
- Runtime fallback: [public/configuration/settings.php](./public/configuration/settings.php)

## Runtime Baseline

- PHP: `8.3.30`
- Docker image: `php:8.3.30-apache`
- Main database: MySQL `8.x`
- External database support: Sybase through ODBC/DBLIB, plus additional PDO connections configured from the system UI

## Actual System Features

### Authentication and Session

- Login and logout flow through `LoginController.php` and `LogoutController.php`.
- Session initialization, timeout handling, CSRF helpers, language loading, audit hooks, and runtime bootstrap through `public/includes/init.php`.
- Role switching for users with more than one available group context through `role-switch.php` and `role-switch-roles.php`.
- Profile workspace with login activity, audit history, active session visibility, and session termination support.
- Login policy configuration from System Settings, including manual login route control and SSO compatibility settings.

### Dashboard

- Main authenticated landing page at `public/pages/dashboard.php`.
- Displays user context, active role context, and dashboard data prepared by `DashboardController.php`.
- Supports system resource polling through `public/ajax/system-resources.php` where allowed.

### User Management

- User directory page at `public/pages/senarai-pengguna.php`.
- Supports staff, student, and public user management flows.
- AJAX operations exist for listing rows, adding staff users, adding student users, adding public users, editing users, deleting users, toggling status, resolving staff/student options, and managing extra roles.
- User logic is handled through `UserListController.php`, `User.php`, and related AJAX endpoints under `public/ajax/user-*.php`.

### Group, Module, Menu, and Sidebar Governance

- Group management page at `public/pages/kumpulan-pengguna.php`.
- Supports group CRUD, group styling, module access, menu access, module/menu ordering, and sidebar refresh without full page reload.
- Supports optional sidebar menu subgroups inside parent modules through `tbl_m_menu_subgroup` and `tbl_m_menu.f_subgroupID`.
- Menu subgroups can be created, edited, ordered, assigned to menus, and protected from deletion while menus are still assigned.
- Sidebar rendering remains backward-compatible: modules can still use direct menus without subgroups, while selected modules can group menus under subgroup headings.
- Sidebar fragment updates are served by `public/ajax/sidebar-fragment.php`.
- Related AJAX endpoints include `group-*`, `module-*`, `menu-*`, `menu-subgroup-*`, `menu-order-item-swap.php`, `modul-list.php`, and role-switch endpoints.
- Access governance logic is supported by `GroupController.php`, `SidebarController.php`, `Group.php`, and `Modul.php`.

### Access Matrix

- Read-only access matrix page at `public/pages/access-matrix.php`.
- Provides visibility of group, module, and menu access configuration.
- Backed by `AccessController.php`.

### Audit Center

- Audit workspace at `public/pages/audit-center.php`.
- Supports audit panels for events, requests, sessions, changes, security views, metadata, and export actions.
- AJAX endpoints include `audit-center-action.php`, `audit-center-export.php`, `audit-center-meta.php`, and `audit-center-panel.php`.
- Audit services are supported by `AuditCenterController.php`, `AuditLogger.php`, and audit helper functions.

### Notification Framework

- In-app notification list page exists at `public/pages/notifications.php`.
- Notification administration page exists at `public/pages/notification-admin.php`.
- Notification template management page exists at `public/pages/notification-templates.php`.
- Topbar notification dropdown shows unread count, recent notification preview, read actions, and View All navigation.
- Supports admin announcements, direct user notifications, role/group/audience notifications, event-based notifications, and workflow task notifications.
- Notification publishing and workflow logic is handled by `NotificationPublisher.php`, `NotificationService.php`, `NotificationWorkflowService.php`, `NotificationAudienceResolver.php`, `NotificationAdminService.php`, and `NotificationTemplateService.php`.
- AJAX endpoints include `notification-list.php`, `notification-read.php`, `notification-read-all.php`, `notification-action.php`, `notification-admin-publish.php`, and `notification-template-action.php`.
- Developer guidance is documented in `docs/notification-developer-standard-2026-05-04.md` and `docs/notification-developer-examples-2026-05-03.md`.

### Profile

- Profile page at `public/pages/profile.php`.
- Shows account profile, login activity, audit event history, audit metadata where authorized, and active session actions.
- AJAX endpoints include `profile-login-activity.php`, `profile-audit-events.php`, `profile-audit-event-meta.php`, and `profile-kill-session.php`.

### System Settings

- System settings page at `public/pages/tetapan-sistem.php`.
- Main tabs currently available:
  - General
  - Login Policy
  - Email
  - Database
  - Theme
  - Language
- Settings are handled by `TetapanSistemController.php`, `Config.php`, `SystemConfigConstants.php`, and page-specific JavaScript/CSS assets.

### Language Architecture

- Core framework translations are stored in `public/lang/core/`.
- Project-specific translations are stored in `public/lang/custom/`.
- Root language files in `public/lang/ms.php` and `public/lang/en.php` are compatibility wrappers that return merged core and custom translations.
- Project custom translations override core translations without requiring changes to existing `__()` calls.
- JavaScript translation bundles and generated page language entries use the same merged language source.
- Generated project language keys are written to `public/lang/custom/` so core language updates do not overwrite project-specific translations.

### Database Runtime Configuration

The Database tab in System Settings supports:

- Main MySQL environment selection between production and development.
- Dedicated MySQL environment variables using `DB_MYSQL_MAIN_PROD_*` and `DB_MYSQL_MAIN_DEV_*`.
- Legacy MySQL fallback variables using `DB_MYSQL_*`.
- Sybase environment selection between production and development.
- Sybase operational mode selection for staff-only or staff-and-student usage.
- Runtime summary and diagnostics that update through AJAX after saving.
- Additional database connection registry stored in `tbl_m_db_connection` and `tbl_m_db_connection_env`.
- Additional connection actions for create, update, enable/disable, test connection, inspect, schema preview, object preview, and sample code.

Programmers should consume additional database connections through:

```php
$pdo = Database::pdoAdditional('dbx_code');
```

Do not hardcode DSN, username, or password inside page/controller code.

### Email Configuration and Templates

- Email runtime settings are managed in `tetapan-sistem.php`.
- Email test delivery is handled through `public/ajax/uji-emel.php`.
- Email template management page exists at `public/pages/template-emel.php`.
- Template operations are handled by `EmailTemplateController.php`, `Mailer.php`, `EmailTemplate*.php`, and AJAX endpoints under `public/ajax/email-*` and `public/ajax/email-template-*`.
- Supported UI operations include listing, preview/testing, creating, updating, duplicating, archiving/restoring, deleting, and seeding templates where available.

### Template Generator

- Template generator page exists at `public/pages/template-generator.php`.
- Supported by `TemplateGeneratorController.php`, `SystemTemplateController.php`, and classes under `public/classes/SystemTemplate*.php`.
- Used to generate or manage system page/template scaffolding from controlled template definitions.

### Developer Guide

- Developer guide page exists at `public/pages/developer-guide.php`.
- Provides centralized, copyable sample code for core-safe module development, including page skeletons, AJAX/CSRF, database access, notifications, language keys, menu/access, audit, and email guidance.
- Intended for programmers to consume framework APIs without modifying protected core files.

### Manual Management

- Manual management page exists at `public/pages/manage-manuals.php`.
- Supports upload and management of user manuals by group.
- Related AJAX endpoints include `manual-*` and `migrate-manuals.php`.
- Supported by `ManualController.php`.

### FAQ

- FAQ page exists at `public/pages/soalan-lazim.php`.
- Provides static/help content for system users.

### Language, Theme, and UI Assets

- Language settings are handled in System Settings.
- Theme settings are handled in System Settings.
- User personal theme preference is applied before the global fallback theme where available to avoid visible theme switching during navigation.
- Sidebar branding supports the configured sidebar image under the main logo.
- Frontend assets include Bootstrap-style components, DataTables usage, SweetAlert workflows, Remix Icon icons, and page-specific JavaScript/CSS files.
- Tailwind/PostCSS tooling exists in `package.json` for frontend build support, although the main application is PHP-rendered.

## Current Page Inventory

The active page files under `public/pages` are:

- `access-matrix.php`
- `audit-center.php`
- `dashboard.php`
- `developer-guide.php`
- `kumpulan-pengguna.php`
- `manage-manuals.php`
- `notification-admin.php`
- `notification-templates.php`
- `notifications.php`
- `profile.php`
- `senarai-pengguna.php`
- `soalan-lazim.php`
- `template-emel.php`
- `template-generator.php`
- `tetapan-sistem.php`

Any module not listed above should not be treated as an active page unless it is added back into `public/pages`.

## Main Controllers

Current controller files under `public/controllers` include:

- `AccessController.php`
- `AuditCenterController.php`
- `DashboardController.php`
- `EmailTemplateController.php`
- `GroupController.php`
- `LoginController.php`
- `LogoutController.php`
- `ManualController.php`
- `ProfileController.php`
- `SidebarController.php`
- `SystemTemplateController.php`
- `TemplateGeneratorController.php`
- `TetapanSistemController.php`
- `UserListController.php`

Other controller files may exist for legacy or supporting flows, but the list above represents the active system surfaces documented in this README.

## Database Architecture

IQS-Framework uses three database access patterns:

1. Main MySQL application database

   Used for users, groups, modules, menus, system settings, email templates, audit records, manual metadata, and application runtime data.

2. Sybase domain connections

   Used for staff/student source data integration through configured production/development Sybase targets.

3. Additional database connections

   Managed from System Settings > Database > Additional Connections. These are intended for programmer use in new pages, controllers, repositories, services, AJAX endpoints, DataTables feeds, dropdown lookups, insert/update flows, and batch sync processes.

## Directory Structure

```text
iqs-framework/
|-- public/
|   |-- ajax/              # AJAX endpoints
|   |-- assets/            # CSS, JS, images, vendor assets
|   |-- classes/           # Core classes, models, services
|   |-- configuration/     # Runtime configuration files
|   |-- controllers/       # Page controllers
|   |-- includes/          # Bootstrap/init/shared includes
|   |-- pages/             # Authenticated application pages
|   |-- setting/           # Helpers, constants, language/config support
|-- docker/                # Apache, SSL, and PHP runtime config
|-- docs/                  # Project documentation assets
|-- tools/                 # CLI maintenance tools
|-- updates/               # Update/deployment support files
|-- .env.example           # Example runtime environment
|-- docker-compose.yml     # Docker runtime service
|-- Dockerfile             # PHP Apache image
|-- VERSION                # Application version
|-- CHANGELOG.md           # Release notes
|-- README.md              # This file
```

## Setup

1. Prepare environment file.

   Copy `.env.example` to `.env` and configure the MySQL and Sybase values required by your environment.

2. Start with Docker.

   ```bash
   docker compose up -d --build
   ```

3. Confirm Apache document root.

   Docker maps `./public` to `/var/www/html`, so application entry files are served from the `public` directory.

4. Confirm version visibility.

   The container mounts `./VERSION` to `/var/www/VERSION` so the runtime version label can read the same release value.

5. Confirm database setup.

   Ensure the required application tables exist before login and administration testing. For additional database connections, ensure `tbl_m_db_connection` and `tbl_m_db_connection_env` exist in every deployment environment.

## Developer Guidelines

- Use controllers for page-specific orchestration.
- Use classes/services/repositories for reusable database and business logic.
- Use AJAX endpoints for background save/list/test operations.
- Use `Database::getInstance('mysql')->getConnection()` for the main application database when following existing patterns.
- Use `Database::pdoSybaseStaff()` or `Database::pdoSybaseStudent()` for configured Sybase domains.
- Use `Database::pdoAdditional('dbx_code')` for additional database connections created from System Settings.
- Use `NotificationPublisher`, `NotificationWorkflowService`, or `NotificationTemplateService` for new notification flows instead of inserting notification rows directly from page code.
- Follow `docs/notification-developer-standard-2026-05-04.md` when adding notifications to new modules so admin, event, and workflow notifications remain consistent across projects.
- Configure sidebar modules, menus, menu access, and optional menu subgroups through `kumpulan-pengguna.php`; project programmers should not hardcode sidebar structure inside `public/includes/sidebar.php`.
- Refer to `docs/sidebar-menu-subgroup-blueprint-2026-05-06.md` before enabling subgroup schema or adding grouped sidebar menus in a project deployment.
- Do not hardcode database DSN, username, or password in pages/controllers.
- Keep access checks aligned with group, module, and menu governance.
- Record sensitive administrative changes through the audit helper/logger pattern already used in the system.
- Use `php tools/language-split-tool.php validate` after language or core sync changes to verify core/custom translation health.

## Security Notes

- Serve only the `public` directory through the web server.
- Keep `.env` outside public web access.
- Protect write actions with CSRF validation.
- Validate role/group/menu access before exposing administrative actions.
- Avoid logging secrets, passwords, DSNs with credentials, or raw sensitive payloads.
- Review audit logs after changing user, group, module, menu, database, or system configuration behavior.

## Removed or Undocumented Features

This README intentionally excludes features that are not active page/module surfaces in the current IQS-Framework codebase. In particular, removed prototype pages, old project names, and previous domain-specific modules are not documented here unless they are reintroduced into the active application structure.

## Maintainer

- Name: Ts. Norfirdaus Harun
- Email: norfirdaus@upnm.edu.my
