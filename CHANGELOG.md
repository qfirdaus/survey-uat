# Changelog

All notable changes to this project will be documented in this file.

This changelog follows a release-style summary based on major project milestones and significant git history, using release dates without time stamps.

## [Unreleased]

## [1.8.2] - 2026-06-12

### Added
- Added role-aware AI Chatbot answer boundaries for system-focused assistance and restricted administrator workflows.
- Added safe runtime context for chatbot requests, including sanitized page path/title, app title, active group context, language, and chatbot access mode.
- Added read-only visible system context through `AiChatbotSystemContext`, capped by active group module/menu access.
- Added optional curated AI Chatbot knowledge base support through `tbl_ai_chat_knowledge` and `docs/ai-chatbot-knowledge-tables-2026-06-12.sql`.
- Added visibility-filtered knowledge retrieval through `AiChatbotKnowledgeContext`.
- Added permission-filtered retrieval policy for system-specific questions so answers must be grounded in approved context.
- Added `AiChatbotQuestionClassifier` for review-safe governance metadata across system help, navigation help, access help, troubleshooting, sensitive blocked, and unknown questions.
- Added production runbook monitoring SQL for AI Chatbot governance review loops.

### Changed
- Changed AI Chatbot prompt construction to use approved runtime, visible system, curated knowledge, retrieval policy, and classification context.
- Changed AI Chatbot usage metadata to include context source, knowledge item count, grounded-answer requirement, question category, risk, review reason, and blocked-detail flags.
- Changed AI Chatbot documentation to cover phases for role-aware answer boundaries, safe runtime context, read-only system context, curated knowledge, permission-filtered retrieval, and governance review.
- Changed project release metadata to lock the application version at `1.8.2`.

## [1.8.1] - 2026-06-11

### Added
- Added the core AI Chatbot module with a floating widget, dedicated page, AJAX message endpoint, provider registry, and provider service layer.
- Added AI Chatbot provider support for local/free-first testing through Ollama and compatible provider abstractions for future hosted APIs.
- Added AI Chatbot runtime configuration under System Settings > AI Chatbot, stored in `tbl_m_config` using the `ai_chatbot` group.
- Added AI Chatbot database script documentation for chat sessions, messages, and usage tracking tables.
- Added AI Chatbot implementation blueprint and production runbook documentation.

### Changed
- Changed AI Chatbot runtime settings to use `tbl_m_config` only, removing AI Chatbot setting fallback from `.env`.
- Changed System Settings to include an AI Chatbot tab after Language with subtabs for Overview, Provider, Limits, Character, and Storage.
- Changed AI Chatbot widget positioning and panel presentation to avoid footer overlap and improve visual separation.
- Changed project release metadata to lock the application version at `1.8.1`.

### Fixed
- Fixed missing AI Chatbot tab icon by switching to a Remix Icon class available in the project asset set.

## [1.8.0] - 2026-06-06

### Added
- Added audit trail coverage for core mutation flows including form save, module creation, notification template actions, student sync, manual management, and system template generation.
- Added field-level audit change-set logging for supported create, update, sync, upload, duplicate, archive, restore, and delete flows.
- Added topbar notification language keys and core fallback translations identified during the public-page language audit.
- Added dedicated global loader translation keys for loading, saving, submitting, navigation, and logout states.
- Added a governance checklist to the system template generator for language keys, audit hooks, and access control.

### Changed
- Changed framework translation updates to use `public/lang/core/*.php` for core project keys.
- Changed application modal markup so dialogs are top-aligned consistently across audited public pages.
- Changed module creation in `kumpulan-pengguna.php` so the legacy inline POST write path no longer bypasses the audited AJAX endpoint.
- Changed additional database sample-code blocks so SQL write examples are explicitly marked as sample-only for audit scanning.
- Changed project release metadata to lock the application version at `1.8.0`.

### Fixed
- Fixed missing core translation coverage found across active public pages during the language-key audit.
- Fixed audit blind spots on critical page actions by adding non-blocking audit events and change details.

## [1.7.9] - 2026-06-04

### Added
- Added admin-only System Cache maintenance page at `public/pages/system-cache.php` for discovering and clearing standard project cache locations.
- Added dynamic cache discovery for `app/cache`, `public/cache`, and `storage/cache`, including file count, total size, and last-modified summary.
- Added cache-clearing AJAX endpoint with CSRF validation, admin permission enforcement, OPcache/APCu best-effort clearing, and audit logging.
- Added `upnm30` to the registered downstream project list for `sync-updates.sh`.
- Added core file protection standard and protected files registry documentation for downstream project governance.
- Added `tools/core-file-protection-audit.php` to validate protected core markers before release or update collection.

### Changed
- Changed System Cache clearing feedback to use the existing global loader and update the page in place without forcing a page refresh.
- Changed active framework pages to include a protected core read-only header for downstream programmers.
- Changed active framework controllers to include a protected core read-only header for downstream programmers.
- Changed framework AJAX endpoints and shared AJAX helpers to include a protected core read-only header for downstream programmers.
- Changed framework classes and services to include a protected core read-only header for downstream programmers.
- Changed bootstrap/includes, setting helpers/constants, configuration, root public entry files, root language wrappers, and core language files to include a protected core marker for downstream programmers.
- Changed page/template generator output so generated page, controller, and CSS files are marked as project-generated and safe to customize.
- Changed update collection scripts to include core file protection docs and audit tooling in framework update packages.
- Changed developer guidance and sync-ignore notes to include final core protection release checks for downstream programmers.
- Changed Developer Guide references and handover checklist to point programmers to core protection standards, protected file registry, and audit validation.
- Changed project release metadata to lock the application version at `1.7.9`.

### Fixed
- Preserved cache directory structure, `.gitkeep`, `.htaccess`, and active user sessions during cache-clearing operations.

## [1.7.8] - 2026-05-20

### Added
- Added `.sync-update-ignore` support to `sync-updates.sh` and `update-files.sh` so selected update files can be excluded from `updates/` collection and downstream sync distribution.
- Added `e-prestasi` to the registered downstream project list for `sync-updates.sh`.

### Changed
- Changed global loader behavior so the full-page loader is now reserved for sidebar navigation, while in-page actions rely on local loading states.
- Changed `kumpulan-pengguna.php` group, menu, and module flows to use standardized SweetAlert handling, faster modal-open sequencing, and earlier success feedback after confirmed server writes.
- Changed project release metadata to lock the application version at `1.7.8`.

### Fixed
- Fixed `kumpulan-pengguna.php` table refresh behavior so add/edit/delete menu actions no longer create malformed or ghost rows during in-place updates.
- Fixed group delete-button visibility so the main table now follows the same eligibility rules as the backend, including protected groups and assigned-user checks.
- Fixed `kumpulan-pengguna.php` Module Access column so the action button remains available for manageable groups instead of appearing unintentionally disabled.
- Fixed post-transaction feedback timing across group and module management flows so success alerts are shown without waiting for heavier sidebar or table refresh work to finish.

## [1.7.7] - 2026-05-08

### Added
- Added Super Admin `View As` impersonation from `senarai-pengguna.php`, including start/stop AJAX endpoints, a reason prompt, view-only mode, support-action mode, and a topbar banner with manual stop.
- Added impersonation access-policy registration for start and stop endpoints.
- Added system-configured `View As Timeout (Minutes)` under System Settings > General > Limits, replacing the previous environment-based timeout setting.
- Added View As SOP documentation and SQL support files for `ATTEMPT` audit outcome and audit user-id normalization.

### Changed
- Changed impersonation audit ownership so request-level `user_id` and `login_id` are bound to the real actor while the effective target is preserved in impersonation metadata.
- Changed support-action write audits to use the neutral `ATTEMPT` outcome.
- Changed audit logging normalization so `audit_event.user_id` and `audit_request.user_id` store staff number (`f_nopekerja`) instead of the MySQL user primary key (`f_userID`) where possible.
- Changed project release metadata to lock the application version at `1.7.7`.

### Fixed
- Fixed View As logout, stop, timeout, and view-only write-block flows so the actor session is restored consistently.
- Fixed Profile Login Activity empty-table display so the no-records message spans the full table instead of wrapping inside the `No.` column.

## [1.7.6] - 2026-05-06

### Added
- Added sidebar menu subgroup blueprint documentation with Phase 1 SQL for optional module-level menu grouping.
- Added subgroup management endpoints and UI in `kumpulan-pengguna.php` for optional module-level menu subgroups.
- Added audit logging for menu subgroup create, update, delete, and denied delete attempts.
- Added subgroup-aware menu ordering support so grouped menu sections can be positioned alongside direct module menus.

### Changed
- Changed `Modul.php` menu loading to expose optional subgroup metadata when the subgroup schema exists, while remaining backward-compatible with the current two-level sidebar schema.
- Changed sidebar rendering to support optional nested menu subgroups inside parent modules while preserving direct module menu behavior.
- Changed menu create/edit/list/get/group-permission flows to read and write optional `f_subgroupID` values.
- Changed `kumpulan-pengguna.php` Menu Access UI to show subgroup context in a dedicated column with compact badges and cleaner status/action layout.
- Changed Menu Subgroup Management UI to use auto-populated ordering, direct icon picking, protected delete visibility, and a cleaner management form.
- Changed sidebar subgroup blueprint documentation to include final implementation notes and test checklist.
- Changed project release metadata to lock the application version at `1.7.6`.

### Fixed
- Fixed child menu edit save flow so the parent Menu Access modal waits until it is fully rendered before rebuilding its DataTable, preventing oversized/wrapped rows after save on slower deployments.
- Fixed menu subgroup delete behavior so delete actions are hidden or blocked when menus are already assigned to the subgroup.
- Fixed sidebar subgroup arrow alignment and direct sidebar item spacing for Dashboard, User Manual, and Logout entries.

## [1.7.5] - 2026-05-06

### Added
- Added Phase 1 in-app notification topbar, notification page, AJAX read/list endpoints, and core language keys.
- Added Phase 2 notification publisher and audience resolver for universal event-based notifications.
- Added Phase 3 workflow notification support with task publishing helper, action status endpoint, overdue filter metadata, and source completion/expiry helpers.
- Added notification developer examples for announcements, direct events, workflow tasks, dedupe behavior, and source completion helpers.
- Added `tools/notification-seed-test.php` to seed Phase 1-3 notification test records.
- Added Phase 4 notification admin composer page and AJAX publish endpoint for admin-managed in-app notifications.
- Added notification template management page, CRUD endpoint, and DB-backed `publishFromTemplate()` rendering.
- Added notification developer standard documentation and sample-code modal support for common programmer integration flows.
- Added topbar notification dropdown integration with unread count, compact 5-item preview, read actions, and View All navigation.

### Changed
- Changed notification admin and template management pages to use full-width workspaces and DataTables-style listing behavior.
- Changed notification setup/template modals to use tabbed professional layouts, tooltip-based field guidance, icon selection, date-time inputs, and preview surfaces.
- Changed tabbed modals across administration pages to open top aligned, while non-tabbed modals remain centered unless the page explicitly requires all modals top aligned.
- Changed `kumpulan-pengguna.php` so all modals open top aligned for a more consistent management workflow.
- Changed sidebar theme loading so a user's personal theme can be applied earlier and avoids visible fallback to the global theme on navigation.
- Changed sidebar rendering to support the configured branding image beneath the logo.
- Changed project release metadata to lock the application version at `1.7.5`.

### Fixed
- Fixed notification admin audience value display so stored audience values are shown with clearer descriptions where possible.
- Fixed notification admin and template table cell alignment so multi-line rows render top aligned.
- Fixed notification template action buttons for edit, duplicate, archive, and delete flows, including delete protection for templates currently in use.
- Fixed topbar notification badge overlap and cleaned up the notification submenu header/presentation.

## [1.7.4] - 2026-05-02

### Added
- Added core/custom language folder structure under `public/lang/core/` and `public/lang/custom/`.
- Added compatibility wrappers for `public/lang/ms.php` and `public/lang/en.php` so direct legacy includes still return merged translations.
- Added `tools/language-split-tool.php` for validating language parity, duplicate keys, custom overrides, and legacy language migration.
- Added language core/custom split audit documentation in `docs/language-core-custom-split-audit-2026-05-02.md`.

### Changed
- Changed the global language helper to load core translations first and project custom translations second.
- Changed bootstrap and System Settings JavaScript translation loading to use merged core/custom language data.
- Changed generated page language entries so project-specific keys are written to `public/lang/custom/`.
- Changed update and sync scripts to protect `public/lang/custom/*` while still distributing core language files, release metadata, and language tooling.
- Changed project release metadata to lock the application version at `1.7.4`.

### Fixed
- Fixed duplicate core translation keys reported by the language validation tool.

## [1.7.3] - 2026-05-01

### Added
- Added explicit `.env` sections for main MySQL production and development runtime targets while keeping legacy `DB_MYSQL_*` values as fallback compatibility configuration.
- Added MySQL runtime diagnostics in `tetapan-sistem.php`, including resolved key, production/development targets, dedicated/fallback indicators, and same-target warning.
- Added tabbed Additional Connections sample-code guidance for programmers, covering Service, Repository, Controller, Transaction, Read-only, Ajax Endpoint, DataTables, Dropdown, Insert Update, and Batch Sync patterns.

### Changed
- Changed main MySQL bootstrap handling so `MAIN_DB_ENVIRONMENT` can be resolved earlier and MySQL runtime caches are cleared when production/development settings change.
- Changed database settings AJAX behavior so MySQL and Sybase runtime summaries update in place after save instead of requiring a full page refresh.
- Changed Additional Connections sample-code modal layout to use compact tabs with per-example copy actions.
- Changed legacy MySQL `.env` comments to clearly mark `DB_MYSQL_*` as temporary fallback values.

### Fixed
- Fixed stale MySQL runtime information in the Database settings UI after switching between production and development.
- Fixed stale Sybase runtime summary values after changing Sybase environment or operational mode.
- Fixed database settings UI sync paths so fallback AJAX handlers also refresh runtime summary values.

## [1.7.2] - 2026-04-23

### Added
- Added runtime baseline documentation in `README.md` for `PHP 8.3.30`, Docker `php:8.3.30-apache`, and `MySQL 8.0.41`.
- Added PHP 8.4 readiness audit documentation in `docs/php84-readiness-audit-2026-04-23.md`.

### Changed
- Changed Docker runtime from `php:8.2-apache` to `php:8.3.30-apache` to align container runtime with the current server baseline.
- Changed landing-page messaging in `public/index.php` so the public entry screen positions IQS Framework as the shared core platform for downstream systems.
- Changed `forgot-password.php` user feedback so restricted account flows return a generic SweetAlert review message without exposing policy-specific detail.
- Changed password-change notification flows in `reset-password.php` and `change-password.php` to use explicit mailer send-state handling and clearer logging.
- Changed project release metadata to lock the application version at `1.7.2`.

### Fixed
- Fixed `public/classes/Database.php` typed connection handling so instance cleanup no longer conflicts with nullable PDO lifecycle usage under the current PHP baseline.
- Fixed `public/pages/template-emel.php` save behavior so create and update actions can complete through AJAX without forcing a full page refresh.
- Fixed `public/request-unavailable.php` redirect timing to wait 5 seconds before redirect.
- Fixed forgot-password flow observability so mail, eligibility, and token-creation states are easier to trace during development.
- Fixed audit logging so incompatible `audit_event.outcome` values are normalized before insert, preventing schema truncation warnings.
- Fixed mailer environment detection and fallback logging so SMTP failures are easier to diagnose in development.

### Security
- Hardened forgot-password handling to keep restricted-account responses generic for anonymous users while preserving internal debug visibility in development.

## [1.7.1] - 2026-04-22

### Added
- Added AJAX-based module creation for `kumpulan-pengguna` through `public/ajax/module-create.php` so module changes can complete without a full page reload.

### Changed
- Changed `kumpulan-pengguna` group, menu, module, and reorder flows to use a shared silent sidebar sync path instead of mixed reload and reorder-only refresh behavior.
- Changed `kumpulan-pengguna` table updates so group create, update, delete, and access changes refresh the group listing in place while keeping the current page context.
- Changed `kumpulan-pengguna` module save behavior to remove the button spinner loader and keep sidebar updates running in the background after save.

### Fixed
- Fixed stale sidebar state after saving active-group access, menu, and module changes from `kumpulan-pengguna`.
- Fixed inconsistent sidemenu behavior where some updates required `location.reload()` before access, icon, or structure changes became visible.

## [1.7.0] - 2026-04-11

### Added
- Added BDR distance notification issue handling for `too_close`, `too_far`, `outside_allowed_region`, and `state_mismatch`, including badge/filter support and localized labels.
- Added dynamic bulk email issue selection so administrators can send notifications only for issue categories that exist in the current BDR distance result set.
- Added persistent BDR notification exclusions per staff, address hash, and issue type through `tbl_bdr_email_notification_exclusion`.
- Added SSO-only self-confirmation flow for eligible BDR notification issues through `pages/bdr-notification-confirm.php`, with declaration text, token expiry handling, staff matching, and audit-friendly confirmation metadata.
- Added bulk email job item support for self-confirm action content through `f_selfConfirmHtml` and `f_selfConfirmText`.
- Added BDR email template placeholders for `{{primary_action_html}}`, `{{primary_action_text}}`, and `{{guidance_text}}`.
- Added multi-site BDR distance support for `upnm_kampus` and `hat_mizan`, including site tabs, site-aware office labels, office addresses, office coordinates, cache scoping, export context, email context, and self-confirm exclusions.
- Added `tbl_bdr_staff_site` as the local MySQL BDR staff identity and site assignment snapshot, enabling manual HAT Mizan staff assignment where the Sybase staff view has no official site indicator.
- Added HAT Mizan staff mapping SQL scripts and multi-site migration documentation for production rollout.
- Added `public/log/.htaccess` to block direct browser access to project log files on Apache deployments.

### Changed
- Updated BDR bulk and individual notification email content to use point-form reasons and a single primary action link per address.
- Updated BDR notification email introduction text to adapt to the detected issue category, with a combined introduction for records containing multiple issues.
- Updated BDR self-confirmation page flow so unauthenticated users review token details before OneID login, declaration is required before confirmation, and used links show a completed/expired state.
- Updated BDR distance API single-record lookup to read from the local MySQL distance cache instead of requiring a live Sybase lookup during the API request.
- Updated BDR distance API to support `site`, validate invalid site values, default omitted site values to `upnm_kampus`, return site coordinates, hydrate staff identity from `tbl_bdr_staff_site`, and return `not_yet_calculated` when staff exists but no distance cache record exists yet.
- Updated BDR distance refresh behavior so recalculated rows can rehydrate table status, issue labels, notification state, and exclusion state without requiring a manual page refresh.
- Updated BDR distance page switching to load site data through AJAX instead of full page refresh.
- Updated BDR distance cache lookup, notification exclusions, bulk email jobs, and self-confirm token handling to include `f_siteCode` so Kampus UPNM and HAT Mizan records remain separated.
- Updated BDR email placeholders and message text to use site-aware destination labels instead of hard-coded UPNM wording.
- Updated temporary BDR/API/access/SSO/tetapan debug logs to be disabled by default and gated behind explicit environment flags.
- Updated SweetAlert behavior so standard modal alerts require a user click to close, while toast alerts continue to auto-close.
- Updated URL helper and login form link generation to handle both subfolder deployment and production root-domain deployment cleanly.

### Fixed
- Fixed stale logout alert behavior on repeated SSO login attempts after logout.
- Fixed AJAX/access-denied responses so JSON-like requests receive JSON instead of an HTML error response.
- Fixed duplicate-slash URL generation for production root deployment.
- Fixed SSO SP client redirects so production root-domain SSO handoff exits immediately after redirect and uses proxy-aware current URL matching.
- Fixed BDR API staff identity gaps by reading department, department code, position, email, and staff name from the local staff-site snapshot instead of relying on the distance cache table alone.
- Fixed BDR distance cache collisions for identical addresses shared by multiple staff by keeping site/staff context explicit in cache and hydration flows.

## [1.6.0] - 2026-04-08

### Added
- Expanded the System Template Generator creation modal into a tabbed flow with separate sections for template form input, page icon selection, and access mode selection.
- Increased generated page icon choices to 48 selectable icons.
- Added protected-account policy support for the special account `0530-09`, including protected badge display and stricter delete/edit governance.
- Added policy-driven SSO auto provisioning for Staff and Student identities, including configurable default group assignment and first-login application record creation.
- Added auto-provision visibility in `senarai-pengguna.php` so SSO-created accounts can be identified directly from the user listing.

### Changed
- Redesigned the System Template Generator modal to be more compact, centered, and viewport-friendly, with internal panel scrolling instead of full modal scrolling.
- Simplified `Page Name` guidance to clarify that users should enter the page name only, without `.php`.
- Refined multiple administrative UX surfaces, including audit metadata visibility, sidebar toggle behavior, modal presentation, and protected-account interaction handling.
- Extended Login Policy configuration with a dedicated `SSO Auto Provisioning` section for Staff and Student controls.
- Refined login flow handling so Staff and Student first-access behavior is distinguished more clearly between SSO provisioning, manual login readiness, and Public-user access rules.

### Fixed
- Restored DataTables behavior in `senarai-pengguna.php` after earlier initialization regressions.
- Stabilized sidebar collapsible menu behavior so parent menus can open and close reliably without unwanted page refreshes.
- Reduced generic login failures by mapping SSO auto-provision edge cases to clearer outcomes, including invalid default group configuration and unavailable source identity data.

### Security
- Hardened request-level access control for pages, AJAX endpoints, and actions using centralized access policy handling.
- Restricted audit metadata visibility to Super Admin on profile audit flows.
- Kept Public-user access strictly dependent on existing `tbl_m_user` records while limiting Staff and Student automatic record creation to SSO-only first access.

## [1.5.0] - 2026-04-07

### Added
- Added centralized access governance with support for public, super-admin-only, custom-guard, and group-menu-based request policies.
- Added current system module documentation coverage in the project README.

### Changed
- Refined administrative UX across access-protected pages, modals, audit views, and generated page workflows.

### Security
- Hardened direct URL access so page authorization is enforced server-side instead of relying only on menu visibility.
- Introduced safer handling for unavailable or unauthorized destinations with neutral user-facing messaging.

## [1.4.0] - 2026-04-03

### Added
- Added full email template management, including template listing, preview, test send, seed generation, and delivery integration.
- Expanded system template generation capabilities with DB-backed template records, modal-based generation flows, and template variants.

### Changed
- Improved generated page scaffolding with cleaner management flow and access mode support for generated pages.

## [1.3.0] - 2026-03-31

### Added
- Added login policy management and stronger OneID SSO integration flow.
- Added password lifecycle enforcement, password history controls, reset/change flows, and database-backed throttling and lockout controls.
- Added Audit Center enhancements covering events, requests, sessions, changes, security insights, and advanced filtering.

### Changed
- Refined login UX and strengthened session termination handling across admin-facing flows.
- Improved system settings behavior for OneID SSO configuration and related authentication settings.

### Security
- Hardened authentication, session control, and SSO handoff behavior.

## [1.2.0] - 2026-03-22

### Added
- Added DB-backed general system settings with language-aware runtime fallback for footer, mail notes, and shared layout content.
- Added role-based manual management and better user manual access handling.
- Added safer runtime configuration support for system-wide operational settings.

### Changed
- Migrated the external runtime architecture from a legacy single-active Sybase model to a clearer staff-and-student multi-domain runtime model.
- Moved database secrets and sensitive runtime values to environment-driven configuration for safer deployment.
- Rewrote core project documentation around architecture, features, setup, security, and deployment.

### Fixed
- Cleaned up legacy configuration, unused helpers, demo remnants, and orphaned assets.

## [1.1.0] - 2026-03-20

### Added
- Added richer profile management features, including audit trail display, audit modal improvements, device/duration helpers, and better login activity visibility.
- Added stricter group/module management flows, including module reorder support, strict delete behavior, and in-modal access refinements.
- Added layout and application configuration centralization for branding, mail, behavior, and manual access surfaces.

### Changed
- Standardized page headers, profile localization, dashboard login display, topbar language handling, and group access UI behavior.
- Extended session idle timeout handling and refined multiple administrative UI surfaces.

## [1.0.0] - 2026-02-07

### Added
- Established the locked base platform with core login, layout, session handling, theme support, translation support, user foundation, and administrative scaffolding.
- Added early user, group, role, and access-management capabilities.

### Changed
- Migrated identity handling from `f_groupKod` toward `f_groupID`-based access flow.
- Introduced hardening work for group management UI gating and non-blocking audit coverage during base platform stabilization.

### Security
- Locked the hardened base platform as the first stable baseline for subsequent feature work.

## [Pre-1.0 Foundation] - 2025-07-14

### Added
- Established the original project structure, login foundation, layout framework, theme settings, translation groundwork, and early administrative pages.
- Added early system settings, database configuration, email configuration, dashboard loading improvements, group/menu access work, and initial user management capabilities.

### Changed
- Iteratively refined UI layout, dashboard loading behavior, sidebar/menu behavior, and AJAX-based page interactions during the early build phase.
