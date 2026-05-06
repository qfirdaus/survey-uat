<?php
return [

/* =====================================================
 * DASHBOARD (dash_)
 * ===================================================== */

'breadcrumb_home'               => 'Dashboard',
'common_version'               => 'Version',
'common_version_short'         => 'Ver.',

/* Site title (used in <title>) */
'title' => 'UPNM | Project Management System - UPNM30',



/* =====================================================
 * LOGIN & AUTH (login_, config_login_)
 * ===================================================== */

// Tajuk & navigasi
'login_title'              => 'Login',
'login.title'              => 'Login',
'login_heading'            => 'Log in',
'login_welcome'            => 'Welcome',

'login_nav.home'           => 'Home',
'login_nav.faq'            => 'FAQ',
'login_nav.directory'      => 'UPNM Directory',

// Maklumat & bantuan
'login_contact_title'      => 'Information & Contact',
'login_info'               => 'Welcome to the UPNM e-Prestasi System. Please log in to continue.',
'login_contact'            => 'If you encounter any issues, please contact the system administrator.',

// Medan borang
'login_staffid'            => 'Staff ID',
'login_userid_label'       => 'Login ID',
'login_userid_placeholder' => 'login - staff no, matric no @ e-mail',
'login_userid_placeholder_format'
                          => 'Login - %s',
'login_userid_placeholder_staff'
                          => 'staff no',
'login_userid_placeholder_student'
                          => 'matric no',
'login_userid_placeholder_public'
                          => 'email',
'login_userid_placeholder_joiner'
                          => ', ',
'login_userid_placeholder_joiner_last'
                          => ' or ',
'login_userid_placeholder_unavailable'
                          => 'Manual login is unavailable under the current policy',
'login_password'           => 'Password',
'login_language'           => 'Language',

// Nota & tindakan
'login_note'               => 'For first-time login, use your Staff ID as the password.',
'login_forgot'             => 'Forgot password?',
'login_manual_password_change_hint'
                           => 'If your account is required to change its password, the system will take you straight to the update page after your current password is verified.',
'login_manual_access_status_title'
                           => 'Manual access check',
'login_manual_access_status_msg'
                           => 'Manual-login accounts must already be verified. If the password is expired or marked for change, you will not enter the dashboard and will be redirected straight into the password-change flow.',
'login_btnLogin'           => 'Login',
'login_btnOneId'           => 'OneID Login',
'login_or_continue_with'   => 'Or continue with',
'login_oneid_note'         => 'Use OneID for staff or student accounts configured for Single Sign-On.',
'login_oneid_unavailable_note'
                          => 'OneID login is currently unavailable under the active login policy.',

// Status & mesej masa
'login_locked_msg'         => 'Your account has been locked. Please try again after',
'login_locked_msg_login_id'
                          => 'Your account has been temporarily locked. Please try again after',
'login_locked_msg_login_ip'
                          => 'Too many attempts for this Login ID from the current IP. Please try again after',
'login_locked_msg_ip'
                          => 'Too many attempts from the current IP. Please try again after',
'login_seconds'            => 'seconds',

// Gagal / ralat log masuk
'login_fail_msg'           => 'Login failed. Try again:',
'login_fail_title'         => 'Login Failed',

// Validasi borang
'login_form_validation_error'
                           => 'Please enter Staff ID and password.',

// Akses & sekatan
'login_access_blocked_title'
                           => 'Access Denied',
'login_access_blocked_msg'
                           => 'Your account has been blocked. Please contact the system administrator.',
'login_account_not_verified_title'
                           => 'Account Not Verified',
'login_account_not_verified_msg'
                           => 'Your account has not been verified for manual login. Please contact the system administrator.',
'login_password_change_required_title'
                           => 'Password Change Required',
'login_password_change_required_msg'
                           => 'Your account requires a password change before login can continue.',
'login_password_expired_title'
                           => 'Password Expired',
'login_password_expired_msg'
                           => 'Your password has expired and must be updated before login can continue.',
'password_change_page_title'
                           => 'Change Password',
'password_change_kicker'
                           => 'Account Security',
'password_change_heading'
                           => 'Update your password',
'password_change_reason_required'
                           => 'The system requires you to change your password before manual access can continue.',
'password_change_reason_expired'
                           => 'Your password has expired. Set a new password to continue manual login.',
'password_change_login_id_label'
                           => 'Login ID',
'password_change_policy_summary'
                           => 'Use at least 8 characters with a mix of uppercase letters, lowercase letters, and numbers. Do not include your Login ID in the password.',
'password_change_new_password_label'
                           => 'New password',
'password_change_new_password_hint'
                           => 'Minimum 8 characters, including at least one uppercase letter, one lowercase letter, and one number.',
'password_change_confirm_password_label'
                           => 'Confirm new password',
'password_change_live_title'
                           => 'Live check',
'password_change_rule_confirm_match'
                           => 'Password confirmation matches',
'password_change_rule_no_login_id'
                           => 'Password does not contain the Login ID',
'password_change_submit_btn'
                           => 'Save Password',
'password_change_footer_note'
                           => 'After success, sign in again using your new password.',
'password_change_success_title'
                           => 'Password Updated',
'password_change_success_msg'
                           => 'Your password has been updated successfully. Please sign in again using the new password.',
'password_change_notification_subject'
                           => 'Your password has been updated',
'password_change_session_invalid_title'
                           => 'Invalid Password Change Session',
'password_change_session_invalid_msg'
                           => 'The password change session is not valid. Please restart the login flow.',
'password_change_session_expired_msg'
                           => 'The password change session has expired. Please sign in again to continue.',
'password_change_error_required'
                           => 'Please enter the new password and its confirmation.',
'password_change_error_mismatch'
                           => 'The password confirmation does not match.',
'password_change_error_min_length'
                           => 'The password must be at least 8 characters long.',
'password_change_error_min_length_template'
                           => 'The password must be at least %d characters long.',
'password_change_error_uppercase'
                           => 'The password must include at least one uppercase letter.',
'password_change_error_lowercase'
                           => 'The password must include at least one lowercase letter.',
'password_change_error_number'
                           => 'The password must include at least one number.',
'password_change_error_symbol'
                           => 'The password must include at least one symbol.',
'password_change_error_contains_login'
                           => 'The password must not contain your Login ID.',
'password_change_error_csrf'
                           => 'The security token is invalid. Reload the page and try again.',
'password_change_error_user_not_found'
                           => 'Your account could not be found in the system. Please contact the system administrator.',
'password_change_error_reuse_current'
                           => 'The new password must be different from the current password.',
'password_change_error_reuse_history'
                           => 'The new password must not match any of your last 5 passwords.',
'password_change_error_update_failed'
                           => 'Failed to update your password. Please try again or contact the system administrator.',
'forgot_password_page_title'
                           => 'Forgot Password',
'forgot_password_kicker'
                           => 'Account Recovery',
'forgot_password_heading'
                           => 'Request a password reset link',
'forgot_password_intro'
                           => 'Enter the Login ID or registered email for your manual-login account. If the account is eligible, the system will send a one-time reset link to the registered email address.',
'forgot_password_login_id_label'
                           => 'Login ID',
'forgot_password_login_id_placeholder'
                           => 'Enter your Login ID',
'forgot_password_login_id_hint'
                           => 'You can use the actual Login ID or the registered email. For public users, the Login ID is usually the registered email address.',
'forgot_password_submit_btn'
                           => 'Send Reset Link',
'forgot_password_back_to_login'
                           => 'Back to login',
'forgot_password_footer_note'
                           => 'For security reasons, the system shows the same message even when the account is not found or not eligible.',
'forgot_password_success_title'
                           => 'Request Received',
'forgot_password_success_msg'
                           => 'If your account is eligible for password reset, a reset link has been sent to the registered email address.',
'forgot_password_success_reference'
                           => 'The reset request has been recorded for',
'forgot_password_mail_subject'
                           => 'Reset your account password',
'forgot_password_error_required'
                           => 'Please enter your Login ID.',
'forgot_password_error_csrf'
                           => 'The security token is invalid. Reload the page and try again.',
'forgot_password_error_rate_limited'
                           => 'Too many password reset requests. Please try again in a few minutes.',
'forgot_password_error_mail_failed'
                           => 'The reset email could not be sent. %s',
'forgot_password_error_mail_failed_reason_unknown'
                           => 'The failure reason was not recorded.',
'forgot_password_error_token_create_failed'
                           => 'The reset token could not be recorded. Check the password reset table structure.',
'forgot_password_error_ineligible_debug'
                           => 'The request could not be processed through this channel.',
'forgot_password_review_title'
                           => 'Request Received',
'forgot_password_review_msg'
                           => 'Your request has been received. Follow-up action is subject to current account controls and access policy.',
'forgot_password_review_ok'
                           => 'Understood',
'forgot_password_feature_unavailable'
                           => 'The password reset feature is not fully available in this environment yet. Please contact the system administrator.',
'reset_password_page_title'
                           => 'Reset Password',
'reset_password_kicker'
                           => 'Security Link',
'reset_password_heading'
                           => 'Set a new password',
'reset_password_intro'
                           => 'Use this one-time link to set a new password for your manual-login account.',
'reset_password_token_invalid'
                           => 'This reset link is invalid, already used, or has expired. Please request a new link.',
'reset_password_request_new_link'
                           => 'Request a new link',
'reset_password_submit_btn'
                           => 'Set Password',
'reset_password_success_title'
                           => 'Password Reset Successful',
'reset_password_success_msg'
                           => 'Your password has been reset successfully. Please sign in using the new password.',
'login_maintenance_mode_title'
                           => 'Maintenance Active',
'login_maintenance_mode_msg'
                           => 'The system is currently under maintenance. Please try again shortly.',
'login_category_disabled_title'
                           => 'Login Not Allowed',
'login_category_disabled_msg'
                           => 'Login access for your account is not available at this time. Please contact the administrator if needed.',
'login_manual_not_allowed_title'
                           => 'Manual Login Not Allowed',
'login_manual_not_allowed_msg'
                           => 'Your account is not allowed to use manual login. Please use Single Sign-On (SSO).',
'login_sso_first_login_required_title'
                           => 'Use SSO First',
'login_sso_first_login_required_msg'
                           => 'Your first access for this account must be completed through Single Sign-On (SSO). After the application record is created, manual login can be used if the policy allows it.',
'login_manual_account_not_ready_title'
                           => 'Account Not Activated',
'login_manual_account_not_ready_msg'
                           => 'Your account has not been activated for manual access in this application yet. Please contact the system administrator.',
'login_sso_not_allowed_title'
                           => 'SSO Login Not Allowed',
'login_sso_not_allowed_msg'
                           => 'Your account is not allowed to use Single Sign-On (SSO) at this time.',
'login_sso_payload_invalid_title'
                           => 'Invalid SSO Payload',
'login_sso_payload_invalid_msg'
                           => 'The authentication data received from Single Sign-On (SSO) is incomplete or invalid. Please try again.',
'login_sso_session_expired_title'
                           => 'SSO Session Expired',
'login_sso_session_expired_msg'
                           => 'The Single Sign-On (SSO) authentication session has expired. Please start the login flow again through OneID.',
'login_sso_user_not_found_title'
                           => 'Account Not Found',
'login_sso_user_not_found_msg'
                           => 'Your account was not found in this system. Please contact the system administrator.',
'login_sso_account_not_provisioned_title'
                           => 'Access Not Ready',
'login_sso_account_not_provisioned_msg'
                           => 'Your account has not been activated for this application yet. Please contact the system administrator.',
'login_sso_default_group_invalid_title'
                           => 'Access Setup Incomplete',
'login_sso_default_group_invalid_msg'
                           => 'Automatic account preparation could not be completed because the default access group is not configured correctly. Please contact the system administrator.',
'login_sso_source_unavailable_title'
                           => 'Identity Source Unavailable',
'login_sso_source_unavailable_msg'
                           => 'The system could not read your account details from the source system at this time. Please try again later or contact the system administrator.',
'login_sso_auto_provision_failed_title'
                           => 'Login Could Not Be Completed',
'login_sso_auto_provision_failed_msg'
                           => 'Your SSO identity was received, but the application record could not be prepared at this time. Please contact the system administrator.',
'login_sso_service_unreachable_title'
                           => 'SSO Service Unreachable',
'login_sso_service_unreachable_msg'
                           => 'The system could not reach the Single Sign-On (SSO) service at this time. Please try again later.',

// Akaun dikunci / dibuka
'login_locked_title'       => 'Account Locked',
'login_unlocked_title'     => 'Account Unlocked',
'login_unlocked_msg'
                           => 'Your account has been unlocked. Please log in again.',

// Ralat sistem (controller / config)
'config_login_error_title'
                           => 'Login Error',
'config_login_error_message'
                           => 'An error occurred during the login process. Please try again.',


/* =====================================================
 * PROFILE (profile_)
 * ===================================================== */

// =========================
// Tajuk & Breadcrumb
// =========================
'profile_title'                 => 'User Profile',
'profile_breadcrumb_dashboard'  => 'Dashboard',
'profile_breadcrumb'            => 'Profile',

// =========================
// Status
// =========================
'profile_status_active'         => 'Active',
'profile_status_inactive'       => 'Inactive',

// =========================
// Aksesibiliti / Media
// =========================
'profile_avatar_alt'            => 'User avatar',

// =========================
// Maklumat Asas
// =========================
'profile_no_staf'               => 'Staff No.',
'profile_no_pekerja'            => 'Employee No.',
'profile_jabatan'               => 'Department',
'profile_emel'                  => 'Email',
'profile_lang_title'            => 'Language Preference',
'profile_lang_card_title'       => 'Language Preference',
'profile_lang_label'            => 'Preferred Language',
'profile_lang_help'             => 'This language will be used for your account as long as it remains active in the system.',
'profile_lang_option_ms'        => 'Bahasa Melayu',
'profile_lang_option_en'        => 'English',
'profile_lang_save_btn'         => 'Save Language',
'profile_lang_save_success'     => 'Your language preference has been saved successfully.',
'profile_lang_session_note'     => 'Choose the main display language for your account. Changes will apply on the next session across modules that support multiple languages.',

// =========================
// Butang & Quick Actions
// =========================
'profile_btn_copy_no_staf'      => 'Copy Staff No.',
'profile_btn_copy_email'        => 'Copy Email',
'profile_identity_summary'      => 'Identity Summary',
'profile_panel_subtitle'        => 'Account and identity information for the active user in the system.',
'profile_no_job_info'           => 'No job information',
'profile_no_department_info'    => 'No department information',
'profile_jawatan'               => 'Position',

// =========================
// Tabs
// =========================
'profile_tabs_label'            => 'User profile tabs',
'profile_tab_profil_pengguna'   => 'User Profile',
'profile_tab_login_aktiviti'    => 'Login Activity',
'profile_tab_jejak_audit'       => 'Audit Trail',

// =========================
// Login Activity
// =========================
'profile_login_date'            => 'Date & Time',
'profile_login_ip'              => 'IP Address',
'profile_login_device'          => 'Device',
'profile_login_duration'        => 'Duration',
'profile_login_status'          => 'Status',
'profile_login_actions'         => 'Actions',

'profile_login_active'          => 'Active',
'profile_login_ended'           => 'Ended',
'profile_login_current'         => 'Current',
'profile_login_kill_session'    => 'Terminate session',

'profile_login_aktiviti_empty'  => 'No login activity records found.',

// SweetAlert – tamatkan sesi
'profile_login_kill_confirm_title'
                                => 'Terminate Session?',
'profile_login_kill_confirm_text'
                                => 'Are you sure you want to terminate this session? The user will be forced to log out.',
'profile_login_kill_confirm_yes'
                                => 'Yes, Terminate',
'profile_login_kill_confirm_no' => 'Cancel',

'profile_login_kill_force_title'
                                => 'Your session will be terminated',
'profile_login_kill_force_text'
                                => 'You will be logged out in',

'profile_login_kill_success'
                                => 'Session terminated successfully',
'profile_login_kill_success_text'
                                => 'The session has been terminated',

'profile_login_kill_error'
                                => 'Failed to terminate session',
'profile_login_kill_error_network'
                                => 'Network error. Please try again.',
'profile_login_kill_error_no_session'
                                => 'Invalid session ID',

/* =====================================================
 * SETTINGS (config result titles)
 * These keys used by TetapanSistemController for save results
 * ===================================================== */
'emel_title'        => 'Email Settings',
'emel_title_save'   => 'Email settings saved successfully',
'bahasa_title'      => 'Language Settings',
'bahasa_title_save' => 'Language settings saved successfully',
'tema_title'        => 'Theme Settings',
'tema_title_save'   => 'Theme settings updated successfully',
'config_js_btn_tutup' => 'Close',

// =========================
// Audit Trail
// =========================

'profile_audit_date'            => 'Date & Time',
'profile_audit_ip'              => 'IP Address',
'profile_audit_outcome'         => 'Outcome',
'profile_audit_severity'        => 'Severity',
'profile_audit_actions'         => 'Actions',


'profile_audit_view_meta'       => 'View metadata',


'profile_audit_field'           => 'Field',

'profile_audit_no_field_changes'
                                => 'No field changes recorded.',


'profile_audit_modal_close'     => 'Close',

// =========================
// DataTables (Profile)
 // =========================
'profile_dt_show'               => 'Show',
'profile_dt_records'            => 'records',
'profile_dt_search'             => 'Search',
'profile_dt_no_records'         => 'No records found',
'profile_dt_info'
                                => 'Showing _START_ to _END_ of _TOTAL_ records',
'profile_dt_info_empty'
                                => 'Showing 0 to 0 of 0 records',
'profile_dt_filtered'
                                => 'filtered from _MAX_ total records',
'profile_dt_previous'           => 'Previous',
'profile_dt_next'               => 'Next',
'profile_dt_error'              => 'Error loading data',
'profile_dt_error_msg'          => 'Failed to retrieve data.',

// =========================
// Lain-lain
// =========================
'profile_loading'               => 'Loading…',
'profile_loading_label'         => 'Loading...',
'profile_loading_aria'          => 'Loading',
'profile_js_copied'             => 'Copied',
'profile_copy_empty'            => 'No text to copy',
'profile_copy_wait'             => 'Please wait a moment before copying again',
'profile_copy_failed'           => 'Failed to copy text',
'profile_error_load'            => 'Error loading profile data. Please try again or contact the system administrator.',
'profile_refresh_failed'        => 'Error refreshing data',
'profile_dt_load_failed'        => 'Error loading data table',
'profile_datatables_timeout'    => 'DataTables failed to load within the timeout period',
'profile_empty_notice'
                                => 'Profile not found. Login session may have expired or record does not exist.',
'profile_duration_seconds_short'=> 's',
'profile_duration_minutes_short'=> 'm',
'profile_duration_hours_short'  => 'h',
'profile_duration_days_short'   => 'd',
'profile_device_unknown'        => 'Unknown',
'profile_device_ipad'           => 'iPad',
'profile_device_iphone'         => 'iPhone',
'profile_device_android'        => 'Android',
'profile_device_mobile'         => 'Mobile',
'profile_device_windows'        => 'Windows',
'profile_device_macos'          => 'macOS',
'profile_device_linux'          => 'Linux',
'profile_device_chromeos'       => 'Chrome OS',
'profile_audit_user'            => 'User',
'profile_audit_activity'        => 'Activity',
'profile_audit_title'           => 'Audit Trail',
'profile_audit_event_id'        => 'Event ID',
'profile_audit_summary_short'   => 'Quick Info',
'profile_audit_no_info'         => 'No information',
'profile_data_label'            => 'Data',
'profile_audit_tab_summary'     => 'Summary',
'profile_audit_tab_changes'     => 'Changes',
'profile_audit_tab_extra'       => 'Extra Info',
'profile_audit_tab_raw'         => 'Raw Data',
'profile_audit_primary_changes' => 'Key Changes',
'profile_audit_search_changes'  => 'Search changes...',
'profile_audit_extra_info'      => 'Extra Info',
'profile_audit_raw_data'        => 'Raw Data',
'profile_audit_no_changes'      => 'No changes',
'profile_before_label'          => 'Before',
'profile_after_label'           => 'After',
'profile_before_raw_label'      => 'Before',
'profile_after_raw_label'       => 'After',
'profile_close_label'           => 'Close',
'profile_load_metadata_failed'  => 'Failed to load event metadata',
'profile_metadata_forbidden_title' => 'Restricted View',
'profile_metadata_forbidden_text'  => 'Audit trail metadata is available for Super Admin review only.',
'profile_swal_ok'               => 'OK',
'profile_audit_changes_separator' => '-- Changes --',
'profile_audit_download_failed' => 'Failed to download JSON file',

/* =====================================================
 * SENARAI PENGGUNA (userList_)
 * ===================================================== */

// =========================
// Tajuk & Breadcrumb
// =========================
'userList_page_heading_main'     => 'System Users',

// =========================
// Kolum Jadual
// =========================
'userList_col_no'                => 'No.',
'userList_col_name_staffid'      => 'Name (Staff ID)',
'userList_col_department'        => 'Department',
'userList_col_university'        => 'University Name',
'userList_col_position'          => 'Position',
'userList_col_group'             => 'Group',
'userList_col_access'            => 'Access',
'userList_col_actions'           => 'Actions',

// =========================
// Status & Paparan
// =========================
'userList_avatar_alt'            => 'User avatar',
'userList_empty_value'           => '—',
'userList_http_status_prefix'    => 'HTTP',
'userList_no_records'            => 'No records',
'userList_loading_staff'         => 'Loading staff list',
'userList_loading_user_list'     => 'Loading user list',
'userList_no_staff_data'         => 'No staff data',
'userList_processing'            => 'Processing...',
'userList_loading'               => 'Loading...',
'userList_dt_length_menu'        => 'Show _MENU_ records',
'userList_access_granted'        => 'Allowed',
'userList_access_blocked'        => 'Blocked',
'userList_dt_search_label'       => 'Search:',
'userList_dt_info'               => 'Showing _START_ to _END_ of _TOTAL_ entries',
'userList_dt_info_empty'         => 'No records',
'userList_dt_paginate_prev'      => 'Previous',
'userList_dt_paginate_next'      => 'Next',
'userList_dt_zero_records'       => 'No matching records found',
'userList_btn_ok'                => 'OK',

// =========================
// Tindakan
// =========================
'userList_action_change_group'   => 'Change group',
'userList_action_delete_user'    => 'Delete user',

// =========================
// Modal — Umum
// =========================
'userList_modal_title'           => 'Change User Group',
'userList_modal_title_public'    => 'Update Public User',
'userList_modal_add_title'       => 'Add Staff',
'userList_modal_add_student_title' => 'Add Student',
'userList_modal_add_public_title' => 'Add Public',
'userList_modal_label_reset_password' => 'Reset Password',

'userList_modal_btn_save'        => 'Save',
'userList_modal_btn_add'         => 'Add',
'userList_modal_btn_close'       => 'Close',
'userList_modal_btn_cancel'      => 'Cancel',

// =========================
// Modal — Label Maklumat
// =========================
'userList_modal_label_name'      => 'Name',
'userList_modal_label_department'=> 'Department',
'userList_modal_label_public_university'
                                => 'University Name',
'userList_modal_label_position' => 'Position',
'userList_modal_label_group'    => 'Group',
'userList_modal_label_access'   => 'Access',
'userList_modal_label_staff'    => 'Staff',
'userList_modal_label_student'  => 'Student',
'userList_modal_label_public_name' => 'Full Name',
'userList_modal_label_public_nickname' => 'Nickname',
'userList_modal_label_public_email' => 'Email Address',
'userList_modal_label_public_phone' => 'Phone Number',
'userList_modal_label_public_idno' => 'ID Number',
'userList_modal_label_public_password' => 'Password',
'userList_modal_label_public_password_confirm' => 'Confirm Password',
'userList_modal_label_faculty'  => 'Faculty',
'userList_modal_label_program'  => 'Program',
'userList_modal_label_level'    => 'Study Level',
'userList_modal_label_status_category' => 'Status Category',
'userList_primary_role_label'   => 'Primary Role',

// =========================
// Modal — Seksyen
// =========================
'userList_modal_section_user_info'
                                => 'User Information',
'userList_modal_section_staff_info'
                                => 'Staff Information',
'userList_modal_section_student_info'
                                => 'Student Information',
'userList_modal_section_public_info'
                                => 'Public User Information',
'userList_modal_section_settings'
                                => 'User Settings',
'userList_public_password_hint'  => 'Leave blank if you do not want to change the password.',
'userList_public_password_reset_forces_change'
                                => 'Setting or resetting the password here will force the user to change it on the next login.',
'userList_password_reset_forces_change'
                                => 'Resetting the password here will force the user to change it on the next login.',

// =========================
// Placeholder
// =========================
'userList_modal_placeholder_select_staff'
                                => 'Select staff...',
'userList_modal_placeholder_select_student'
                                => 'Search active student...',
'userList_modal_placeholder_select_public'
                                => 'Select public user...',
'userList_modal_placeholder_select_group'
                                => 'Select group...',
'userList_group_filter_placeholder'
                                => '-- Select group --',
'userList_modal_add_role'       => '+ Role',
'userList_modal_extra_role_title' => 'Additional Roles',
'userList_role_none'            => 'No additional roles.',

// =========================
// Validasi / Keadaan
// =========================
'userList_staff_already_exists'  => 'Already Exists',
'userList_student_already_exists' => 'Already Exists',
'userList_user_default'          => 'User',

// =========================
// Pengesahan Padam
// =========================
'userList_delete_confirm_title'  => 'Delete User?',
'userList_delete_confirm_message'
                                => 'Are you sure you want to delete this user?',
'userList_delete_confirm_warning'
                                => 'This action cannot be undone.',
'userList_delete_confirm_yes'    => 'Yes, Delete',

// =========================
// Kejayaan
// =========================
'userList_success_add'           => 'User added successfully.',
'userList_success_add_student'   => 'Student added successfully.',
'userList_success_delete'        => 'User deleted successfully.',
'userList_success_update_roles'  => 'Additional roles updated successfully.',
'userList_success_title'         => 'Success',
'userList_success_update_group'  => 'User group and access updated successfully.',
'userList_success_update_public' => 'Public user information updated successfully.',

// =========================
// Ralat
// =========================
'userList_error_title'           => 'Error',
'userList_loading_student'       => 'Loading students',
'userList_err_load_student'      => 'Failed to load student data.',
'userList_btn_saving'            => 'Saving...',
'userList_err_update_public'     => 'Please review the public user details and try again.',

// Buttons
'userList_sync_button'           => 'Sync Data',
'userList_sync_staff_button'     => 'Sync Staff',
'userList_sync_student_button'   => 'Sync Student',
'userList_tab_staff'             => 'Staff Access',
'userList_tab_student'           => 'Student Access',
'userList_tab_public'            => 'Public Access',
'userList_col_name_matric'       => 'Name / Matric No.',
'userList_col_name_login'        => 'Name / Login ID',
'userList_col_faculty'           => 'Faculty',
'userList_sync_processing'       => 'Processing...',
'userList_add_button'            => 'Add Staff',
'userList_add_student_button'    => 'Add Student',
'userList_add_public_button'     => 'Add Public',
'userList_search_placeholder'    => 'Search',
'userList_debug_group_ui_title'  => 'DEBUG GROUP UI',
'userList_debug_group_ui_stats'  => 'groups: %d, by_id: %d, by_code: %d, css_rules: %d',
'userList_debug_group_ui_hint'   => 'Append {query} to view this panel.',
'userList_sync_student_pending_title' => 'Sync Student',
'userList_sync_student_pending_text'  => 'Student data sync will be enabled in the next phase.',
'userList_public_pending_title'  => 'Add Public',
'userList_public_pending_text'   => 'Add Public flow will be enabled in the next phase.',

'userList_err_add_failed'        => 'Failed to add user.',
'userList_err_delete_failed'     => 'Failed to delete user.',
'userList_err_load_data'         => 'Failed to load data.',
'userList_err_load_staff'        => 'Error loading staff.',
'userList_err_param'             => 'Incomplete parameters.',
'userList_err_update_group'      => 'Failed to update group.',

'userList_err_invalid_response'
                                => 'Error: Invalid server response',
'userList_err_invalid_json'
                                => 'Error: Invalid server response (not JSON).',
'userList_err_non_json'
                                => 'Error: Server response is not JSON.',
'userList_err_server'            => 'Server error',
'userList_err_unknown'           => 'Unknown error.',
'userList_err_no_permission'     => 'You do not have permission to perform this action.',
'userList_rate_limit_title'      => 'Too Fast',
'userList_rate_limit_text'       => 'Please wait a moment before trying again.',
'userList_protected_badge'       => 'Protected Account',
'userList_protected_tooltip'     => 'This account is protected by the system. It cannot be deleted, and access changes are only allowed by the account owner.',
'userList_auto_provisioned_badge' => 'Auto Provisioned',
'userList_auto_provisioned_tooltip' => 'This account was created automatically through %s login.',
'userList_protected_delete_denied' => 'This user account is protected by the system and cannot be deleted.',
'userList_protected_self_manage_only' => 'This user account is protected by the system and can only be managed by the account owner.',
'userList_ajax_invalid_data'     => 'Invalid data.',
'userList_ajax_rate_limited'     => 'Too many requests. Please try again in a moment.',
'userList_ajax_system_error'     => 'A system error occurred. Please contact the system administrator.',
'userList_ajax_invalid_user_param' => 'Invalid user parameter.',
'userList_ajax_name_required'    => 'Name cannot be empty.',
'userList_ajax_invalid_email'    => 'Invalid email address.',
'userList_ajax_password_min'     => 'Password must be at least 6 characters.',
'userList_ajax_password_confirm_mismatch' => 'Password confirmation does not match.',
'userList_ajax_user_not_found'   => 'User not found.',
'userList_ajax_public_only'      => 'Only public users can be updated through this flow.',
'userList_ajax_invalid_group'    => 'The user group is invalid or does not exist in the system.',
'userList_ajax_invalid_public_group' => 'The selected group is not valid for public access.',
'userList_ajax_email_exists'     => 'A user with this email address already exists in the system.',
'userList_ajax_delete_permission_superadmin' => 'You do not have permission to delete users. Only Super Admin is allowed.',
'userList_ajax_invalid_user_id'  => 'Invalid user ID.',
'userList_ajax_user_not_found_in_system' => 'User was not found in the system.',
'userList_ajax_delete_self_denied' => 'You are not allowed to delete your own account.',
'userList_ajax_delete_failed_backend' => 'Failed to delete user data.',
'userList_ajax_invalid_action'   => 'Invalid action.',
'userList_ajax_incomplete_params_userid' => 'Incomplete parameters (userID is required).',
'userList_ajax_incomplete_params_group_or_flag' => 'Incomplete parameters (groupID or flag is required).',
'userList_ajax_user_schema_invalid' => 'User schema does not contain f_groupID or f_groupKod.',
'userList_ajax_group_not_found'  => 'Group not found.',
'userList_ajax_no_fields_update' => 'No fields to update.',
'userList_ajax_update_record_failed' => 'Failed to update the user record.',
'userList_ajax_user_not_found_db' => 'User was not found in the database.',
'userList_ajax_no_change_group'  => 'No changes made. The group remains the same.',
'userList_ajax_no_change_access' => 'No changes made. Access remains the same.',
'userList_ajax_roles_update_failed' => 'A system error occurred while updating roles.',

// =========================
// Sync
// =========================
'userList_sync_success_title'    => 'Sync Successful',
'userList_sync_success_message'  => 'Data synced successfully.',
'userList_sync_result_message'   => 'Sync completed. %d records updated, %d records skipped, %d errors.',
'userList_sync_summary_title'    => 'Sync Summary',
'userList_sync_updated'          => 'Updated',
'userList_sync_skipped'          => 'Skipped',
'userList_sync_errors'           => 'Errors',
'userList_sync_total'            => 'Total',
'userList_sync_error_title'      => 'Sync Failed',
'userList_sync_error'            => 'Error during data sync.',


/* =====================================================
 * KUMPULAN PENGGUNA (userGroup_)
 * ===================================================== */

// =========================
// Tajuk & Breadcrumb
// =========================
'userGroup_page_title'              => 'User Groups',
'userGroup_intro'                   => 'List of user groups.',

// =========================
// Jadual Utama
// =========================
'userGroup_col_code'                => 'Group Code',
'userGroup_col_name'                => 'Group Name',
'userGroup_col_module_access'       => 'Module Access',
'userGroup_col_menu_access'         => 'Menu Access',
'userGroup_col_group_access'        => 'Group Access',
'userGroup_col_menu'                => 'Menu',
'userGroup_col_reorder' => 'Reorder',
'userGroup_col_status'              => 'Status',
'userGroup_col_actions'             => 'Actions',

'userGroup_no_records'              => 'No records',
'userGroup_loading' => 'Loading data',

// =========================
// Butang & Aksi
// =========================
'userGroup_btn_add_menu'            => 'Add Menu',
'modul_tambah'                      => 'Add Module',
'modul_tambah_title'                => 'Add Module',
'modul_edit_label'                  => 'Edit',
'modul_kemaskini_title'             => 'Update Module',
'modul_nama_ms'                     => 'Module Name (BM)',
'modul_nama_en'                     => 'Module Name (EN)',
'modul_icon'                        => 'Icon',
'modul_icon_help'                   => 'Select a module icon from the suggested list.',
'modul_icon_group_general'          => 'General',
'modul_icon_group_users'            => 'Users',
'modul_icon_group_system'           => 'System',
'modul_icon_group_files'            => 'Files & Documents',
'modul_icon_group_data'             => 'Data & Reports',
'modul_icon_group_security'         => 'Security',
'modul_icon_group_communication'    => 'Communication & Organization',
'modul_icon_group_more'             => 'Others',
'modul_susunan'                     => 'Order',
'modul_order_auto_help'             => 'The order is generated automatically by the system and cannot be changed manually.',
'modul_simpan'                      => 'Save',
'modul_batal'                       => 'Cancel',
'modul_berjaya_title'               => 'Success',
'modul_berjaya_msg'                 => 'Module added successfully.',
'modul_kemaskini_msg'               => 'Module updated successfully.',
'modul_ralat_title'                 => 'Error',
'modul_ralat_duplikat'              => 'Module name already exists. Please use another name.',
'modul_ralat_wajib'                 => 'Module Name (BM) is required.',
'modul_ralat_tidak_sah'             => 'Invalid module ID.',
'modul_ralat_tidak_jumpa'           => 'Module not found.',
'userGroup_btn_close'               => 'Close',
'userGroup_btn_save'                => 'Save',

// =========================
// Label Kecil
// =========================
'userGroup_label_module'            => 'module',
'userGroup_label_menu'              => 'menu',
'userGroup_label_group'             => 'group',
'userGroup_label_modul_fallback'    => 'Module',

// =========================
// Susun Menu
// =========================
'userGroup_move_up' => 'Move up',
'userGroup_move_down' => 'Move down',

// =========================
// Status
// =========================
'userGroup_status_on' => 'ON',
'userGroup_status_off' => 'OFF',

// =========================
// Modal — Tambah / Sunting Menu
// =========================
'userGroup_modal_add_menu_title'    => 'Add Menu',
'userGroup_modal_edit_menu_title' => 'Edit Menu',
'userGroup_field_menu_domain' => 'Menu Domain',
'userGroup_field_menu_domain_help' => 'Define the functional domain for this menu.',
'userGroup_menu_domain_staff' => 'STAFF',
'userGroup_menu_domain_student' => 'STUDENT',
'userGroup_menu_domain_public' => 'PUBLIC',
'userGroup_menu_domain_shared' => 'SHARED',
'userGroup_field_menu_staff_only_visibility' => 'Visibility During Staff Only',
'userGroup_field_menu_staff_only_visibility_help' => 'Control whether this menu remains visible when Staff Only mode is active.',
'userGroup_menu_staff_only_show' => 'Show',
'userGroup_menu_staff_only_hide' => 'Hide',
'userGroup_menu_staff_only_show_full' => 'Show in Staff Only',
'userGroup_menu_staff_only_hide_full' => 'Hide in Staff Only',
'userGroup_col_visibility' => 'Visibility',
'userGroup_menu_path_info' => 'View menu path',

// =========================
// Modal — Akses
// =========================
'userGroup_modal_group_access_title'=> 'Group Access',
'userGroup_modal_summary_title'     => 'Access Summary',
'userGroup_modal_pick_menu_title'   => 'Select Menu',
'userGroup_modal_group_create_title'=> 'Add Group',
'userGroup_modal_group_edit_title'  => 'Edit Group',

// =========================
// Medan Borang
// =========================
'userGroup_field_group'             => 'Group',
'userGroup_field_group_code'        => 'Group Code',
'userGroup_field_group_name'        => 'Group Name',
'userGroup_field_group_category'    => 'User Category',
'userGroup_field_group_category_help' => 'Define whether this group is for Staff, Student, or Public access.',
'userGroup_field_group_identity'    => 'Group Identity',
'userGroup_field_group_presentation'=> 'Presentation & Style',
'userGroup_field_group_access_setup'=> 'Access Setup',
'userGroup_field_group_preview'     => 'Group Preview',
'userGroup_col_category'            => 'Category',
'userGroup_field_modul'             => 'Module',
'userGroup_field_subgroup'          => 'Subgroup',
'userGroup_field_subgroup_help'     => 'This is optional. Use subgroup to split menus under the same parent module.',
'userGroup_subgroup_none'           => 'No subgroup',
'userGroup_subgroup_manage'         => 'Manage Subgroup',
'userGroup_subgroup_modal_title'    => 'Menu Subgroup Management',
'userGroup_subgroup_code'           => 'Subgroup Code',
'userGroup_subgroup_code_placeholder' => 'Example: admin_access',
'userGroup_subgroup_icon'           => 'Icon',
'userGroup_subgroup_order'          => 'Order',
'userGroup_subgroup_required'       => 'Please select a module and fill in the subgroup name.',
'userGroup_subgroup_not_found'      => 'Subgroup not found.',
'userGroup_subgroup_not_same_module' => 'The selected subgroup does not belong to this module.',
'userGroup_subgroup_in_use'         => 'This subgroup is currently used by menu items. Move the menus before deleting it.',
'userGroup_subgroup_save_success'   => 'Subgroup saved successfully.',
'userGroup_subgroup_delete_success' => 'Subgroup deleted successfully.',
'userGroup_subgroup_confirm_delete' => 'Delete this subgroup?',
'userGroup_subgroup_load_fail'      => 'Failed to load subgroup list.',
'userGroup_btn_reset'               => 'Reset',
'userGroup_field_color'             => 'Color',
'userGroup_field_color_help'        => 'Pick a color visually.',
'userGroup_field_pick_module'       => 'Select Module',
'userGroup_field_pick_module_help'  => 'Select one or more modules for this group.',
'userGroup_field_pick_menu'         => 'Select Menu (depends on Module)',
'userGroup_field_pick_menu_help'    => 'Menus are shown based on selected modules.',
'userGroup_field_path'              => 'Path',
'userGroup_field_path_placeholder'  => 'example: report.php',

'userGroup_field_name_ms'           => 'Name (MS)',
'userGroup_field_name_en'           => 'Name (EN)',

'userGroup_field_status'            => 'Status',
'userGroup_field_position_label' => 'Position in target module',
'userGroup_position_top' => 'Top',
'userGroup_position_bottom' => 'Bottom',

'userGroup_loading_modules'         => 'Loading modules…',

// =========================
// Ralat & Validasi
// =========================
'userGroup_error_unknown'           => 'Unknown error.',
'userGroup_error_network'           => 'Network error.',
'userGroup_error_save'              => 'Failed to save.',
'userGroup_error_load'              => 'Failed to load data.',
'userGroup_error_reorder' => 'Failed to reorder.',
'userGroup_error_load_access' => 'Failed to load access.',
'userGroup_error_load_menu' => 'Failed to load menu.',
'userGroup_error_get_menu' => 'Failed to retrieve menu details.',
'userGroup_error_update_status'     => 'Failed to update status.',

'userGroup_err_path_required'       => 'Path is required.',
'userGroup_err_group_code_name_required' => 'Please fill Group Code, Group Name, and Category.',
'userGroup_err_modul_required'      => 'Please select Module.',
'userGroup_err_add_menu' => 'Failed to add menu.',
'userGroup_err_save_menu' => 'Failed to save menu.',
'userGroup_err_server'              => 'Server error',

// =========================
// SweetAlert — Padam
// =========================
'userGroup_confirm_title'           => 'Confirmation',
'userGroup_confirm_delete_group_text' => 'Delete group "{name}"?',
'userGroup_confirm_yes_delete'      => 'Yes, Delete',
'userGroup_confirm_yes'             => 'Yes, delete',
'userGroup_confirm_cancel'          => 'Cancel',
'userGroup_confirm_delete_menu_title' => 'Delete menu "{name}"?',
'userGroup_confirm_delete_menu_intro' => 'Menu <strong>{name}</strong> will be <u>deleted</u>.',
'userGroup_confirm_delete_menu_cleanup' => 'This menu will also be removed from <em>all groups</em> that reference this ID.',
'userGroup_confirm_delete_menu_irreversible' => 'This action cannot be undone.',
'userGroup_confirm_delete_menu_fallback' => 'Delete menu "{name}"? This menu will also be removed from all groups.',
'userGroup_delete_module_confirm_title' => 'Delete this module?',
'userGroup_delete_module_confirm_text' => 'Module "{name}" will be deleted. This action cannot be undone.',
'userGroup_delete_module_confirm_fallback' => 'Delete module "{name}"?',

'userGroup_error'                   => 'Error',
'userGroup_not_allowed_title'       => 'Not Allowed',
'userGroup_delete_failed_title'     => 'Failed',
'userGroup_deleted_title'           => 'Deleted',
'userGroup_delete_fail'             => 'Failed to delete menu.',
'userGroup_delete_group_success'    => 'Group deleted successfully.',
'userGroup_delete_group_fail'       => 'Failed to delete group.',
'userGroup_delete_group_network_fail' => 'Network error while deleting group.',
'userGroup_delete_menu_cleanup_success' => 'Menu "{name}" was removed from all groups.',
'userGroup_delete_module_not_allowed' => 'You do not have permission to delete modules.',
'userGroup_delete_module_invalid_id' => 'Invalid module ID.',
'userGroup_delete_module_not_found' => 'Module not found.',
'userGroup_delete_module_has_menus' => 'Module cannot be deleted because it still has {count} menus.',
'userGroup_delete_module_fail' => 'Failed to delete module.',
'userGroup_delete_module_success' => 'Module deleted successfully.',
'userGroup_delete_module_network_fail' => 'Network error while deleting module.',
'userGroup_module_delete_label' => 'Delete',
'userGroup_module_reorder_note' => 'Drag modules to change the display order. The order is saved immediately.',
'userGroup_module_drag_label' => 'Drag to reorder',
'userGroup_module_reorder_not_allowed' => 'You do not have permission to reorder modules.',
'userGroup_module_reorder_invalid_payload' => 'Invalid module order payload.',
'userGroup_module_reorder_minimum' => 'At least two modules are required to reorder.',
'userGroup_module_reorder_incomplete' => 'Module order is incomplete.',
'userGroup_rate_limit_text'         => 'Too many requests. Please try again in a few moments.',
'userGroup_method_not_allowed' => 'Method not allowed.',
'userGroup_csrf_invalid' => 'Invalid CSRF token.',
'userGroup_menu_save_success_create' => 'Menu added successfully',
'userGroup_menu_save_success_update' => 'Menu updated successfully',
'userGroup_err_group_modul_path_required' => 'Please select Group, Module, and fill in Path.',
'userGroup_pick_module_aria'        => 'Select module',
'userGroup_pick_menu_button'        => 'Menu',
'userGroup_pick_menu_none'          => 'No active menu for this module.',
'userGroup_pick_menu_on'            => 'ON',
'userGroup_pick_menu_off'           => 'OFF',
'userGroup_summary_load_fail'       => 'Failed to load summary.',
'userGroup_summary_empty'           => 'No records',
'userGroup_summary_no_menu'         => 'No menu',
'userGroup_summary_col_module'      => 'Module',
'userGroup_summary_col_menu'        => 'Menu',
'userGroup_reorder_label'           => 'Reorder',
'userGroup_group_invalid_id'        => 'Invalid group ID.',
'userGroup_menu_invalid_id'         => 'Invalid menu ID.',
'userGroup_group_not_found'         => 'Group not found.',
'userGroup_menu_not_found'          => 'Menu not found.',
'userGroup_target_module_not_found' => 'Target module not found.',
'userGroup_menu_path_duplicate'     => 'Path is already used in this module.',
'userGroup_group_code_duplicate'    => 'Group code already exists.',
'userGroup_group_code_conflict'     => 'Conflicting group code detected. Please contact the system administrator.',
'userGroup_group_create_required'   => 'Group code, name, and category are required.',
'userGroup_group_create_permission_denied' => 'You do not have permission to add groups.',
'userGroup_group_delete_permission_denied' => 'You do not have permission to delete groups.',
'userGroup_group_permissions_not_allowed' => 'You do not have permission to change group permissions.',
'userGroup_menu_create_permission_denied' => 'You do not have permission to add menus.',
'userGroup_menu_update_permission_denied' => 'You do not have permission to update menus.',
'userGroup_menu_delete_permission_denied' => 'You do not have permission to delete menus.',
'userGroup_menu_status_permission_denied' => 'You do not have permission to change menu status.',
'userGroup_invalid_payload'         => 'Incomplete parameters.',
'userGroup_menu_not_same_module'    => 'Menus are not in the same module.',
'userGroup_menu_read_order_error'   => 'Error reading menu order.',
'userGroup_group_system_protected'  => 'System groups cannot be deleted.',
'userGroup_group_users_assigned'    => 'There are still users assigned to this group. Please move those users before deleting the group.',
'userGroup_server_error_prefix'     => 'Server error:',
'userGroup_ok'                      => 'OK',
'userGroup_non_json_response'       => 'Server did not return JSON. Preview:',

// =========================
// Undo (Opsyenal)
 // =========================
'userGroup_undo_btn'                => 'Undo',
'userGroup_undo_title'              => 'Undo',
'userGroup_undo_message'            => 'Menu "%s" has been deleted.',
'userGroup_undo_info'
                                      => 'Undo requires a server-side endpoint. Please contact the administrator.',

// =========================
// Carian & DataTables
// =========================
'userGroup_search_group_placeholder'=> 'Search group...',
'userGroup_search_menu_placeholder' => 'Search...',
'userGroup_dt_length_menu' => 'Show _MENU_ entries',
'userGroup_dt_info'
                                      => 'Showing _START_ to _END_ of _TOTAL_ entries',
'userGroup_dt_info_empty' => 'No entries',
'userGroup_dt_info_filtered'
                                      => '(filtered from _MAX_ total entries)',
'userGroup_dt_paginate_first'       => 'First',
'userGroup_dt_paginate_last' => 'Last',
'userGroup_dt_paginate_next'        => 'Next',
'userGroup_dt_paginate_previous'    => 'Previous',
'userGroup_edit_group'              => 'Edit Group',
'userGroup_delete_group'            => 'Delete Group',
'userGroup_info_title'              => 'Notice',
'userGroup_info_select_group_first' => 'Please select a group first using the Group Access button.',
'userGroup_btn_menu_label'          => 'Menu',
'userGroup_btn_module_label'        => 'Module',
'userGroup_btn_group_label'         => 'Group',
'userGroup_loading_short'           => 'Loading…',
'userGroup_load_modules_fail'       => 'Failed to load modules from: {url} — {error}',
'userGroup_no_modules_found'        => 'No modules found.',


/* =====================================================
 * MATRIKS AKSES (access_)
 * ===================================================== */

// =========================
// Tajuk & Pengenalan
// =========================
'access_title'        => 'Access Matrix',
'access_intro'        => 'Read-only access matrix for system menus.',

// =========================
// Jadual
// =========================
'access_col_no'       => '#',
'access_menu'         => 'Menu',
'access_path'         => 'Path',
'access_modul'        => 'Module',
'access_user_level'   => 'User Level',

// =========================
// Tahap Pengguna
// =========================
'access_ada'          => 'Has Access',
'access_tiada'        => 'No Access',

// =========================
// Paparan
// =========================
'access_no'           => 'No records',


/* =====================================================
 * TETAPAN SISTEM (config_, config_js_, config_db_)
 * ===================================================== */

/* =========================
 * Tajuk
 * ========================= */
'config_system' => 'System Configuration',

/* =========================
 * Tab Navigasi
 * ========================= */
'config_tab_general' => 'General',
'config_tab_auth'    => 'Login Policy',
'config_tab_emel'   => 'Email',
'config_tab_db'     => 'Database',
'config_tab_tema'   => 'Theme',
'config_tab_bahasa' => 'Language',

'config_tab_auth_intro' => 'Control who may log in and which authentication method is allowed for each user category.',
'config_auth_intro_title' => 'Policy Evaluation Order',
'config_auth_subtab_overview' => 'Policy Overview',
'config_auth_subtab_global' => 'Global Access',
'config_auth_subtab_category' => 'Login Category Control',
'config_auth_subtab_password' => 'Password Policy',
'config_auth_subtab_sso' => 'SSO Control',
'config_auth_overview_title' => 'Policy Overview',
'config_auth_overview_sub' => 'Use this view to review policy precedence and the evaluated runtime snapshot before saving changes.',
'config_auth_intro_point_maintenance' => 'Maintenance mode overrides normal login access for all non-Super Admin users.',
'config_auth_intro_point_category' => 'Category control determines whether Staff, Student, and Public users may log in.',
'config_auth_intro_point_sso' => 'SSO settings determine the login method only after access is allowed.',
'config_auth_section_global' => 'Global Access',
'config_auth_section_global_sub' => 'This setting has the highest operational impact on login availability.',
'config_auth_section_category' => 'Login Category Control',
'config_auth_section_category_sub' => 'Decide which user categories are allowed to pass the login gate.',
'config_auth_section_sso' => 'SSO Control',
'config_auth_section_sso_sub' => 'Define whether login uses SSO, manual authentication, or category-based hybrid routing.',
'config_auth_section_summary' => 'Policy Summary',
'config_auth_section_summary_sub' => 'Review the current evaluated policy state before saving changes.',
'config_auth_maintenance_mode' => 'Maintenance Mode',
'config_auth_maintenance_mode_help' => 'When enabled, only Super Admin can log in.',
'config_auth_login_enable_staf' => 'Enable Staff Login',
'config_auth_login_enable_staf_help' => 'Allow users in the Staff category to log in.',
'config_auth_login_enable_pelajar' => 'Enable Student Login',
'config_auth_login_enable_pelajar_help' => 'Allow users in the Student category to log in.',
'config_auth_login_enable_umum' => 'Enable Public Login',
'config_auth_login_enable_umum_help' => 'Allow users in the Public category to log in.',
'config_auth_auto_provision_title' => 'SSO Auto Provisioning',
'config_auth_auto_provision_sub' => 'Allow first-time Staff and Student users to be created automatically through SSO using the configured default group.',
'config_auth_auto_provision_staff_panel' => 'Staff Auto Provision',
'config_auth_auto_provision_staff_panel_sub' => 'Only applies on first login through SSO. Manual staff login still requires an existing app user record.',
'config_auth_auto_provision_student_panel' => 'Student Auto Provision',
'config_auth_auto_provision_student_panel_sub' => 'Only applies on first login through SSO. Manual student login still requires an existing app user record.',
'config_auth_auto_provision_staf_sso' => 'Enable Staff SSO Auto Provision',
'config_auth_auto_provision_staf_sso_help' => 'Automatically create a Staff app record when a valid SSO user has no existing tbl_m_user record.',
'config_auth_auto_provision_pelajar_sso' => 'Enable Student SSO Auto Provision',
'config_auth_auto_provision_pelajar_sso_help' => 'Automatically create a Student app record when a valid SSO user has no existing tbl_m_user record.',
'config_auth_default_group_staff_code' => 'Default Staff Group Code',
'config_auth_default_group_staff_code_help' => 'Group code assigned to newly auto-provisioned Staff users after successful first-time SSO login.',
'config_auth_default_group_student_code' => 'Default Student Group Code',
'config_auth_default_group_student_code_help' => 'Group code assigned to newly auto-provisioned Student users after successful first-time SSO login.',
'config_auth_auto_provision_note' => 'Auto provisioning only applies through SSO. Staff and Student manual login still requires an existing application account.',
'config_auth_sso_enabled' => 'Enable SSO',
'config_auth_sso_enabled_help' => 'Enable Single Sign-On as an available authentication mechanism.',
'config_auth_sso_site_id' => 'OneID Site ID',
'config_auth_sso_site_id_help' => 'Used for the OneID application registration of this system.',
'config_auth_sso_idp_domain' => 'OneID IdP Domain',
'config_auth_sso_idp_domain_help' => 'Base URL of the OneID Identity Provider used for SSO redirection and token validation.',
'config_auth_sso_mode' => 'SSO Mode',
'config_auth_sso_mode_help' => 'Choose how the authentication method is applied to each allowed user category.',
'config_auth_sso_mode_effective' => 'Mode Summary',
'config_auth_sso_mode_all' => 'ALL',
'config_auth_sso_mode_manual' => 'MANUAL',
'config_auth_sso_mode_hybrid' => 'HYBRID',
'config_auth_sso_mode_all_note' => 'In ALL mode, Staff and Student users must use SSO. Public users may still log in manually.',
'config_auth_sso_mode_manual_note' => 'In MANUAL mode, all allowed categories use manual login.',
'config_auth_sso_mode_hybrid_note' => 'In HYBRID mode, each category follows its own configured login method.',
'config_auth_hybrid_header' => 'Hybrid Category Mapping',
'config_auth_hybrid_sub' => 'Define the login method for each category when SSO Mode is set to HYBRID.',
'config_auth_sso_hybrid_staf' => 'Staff Login Method',
'config_auth_sso_hybrid_staf_help' => 'Choose the login method for Staff users.',
'config_auth_sso_hybrid_pelajar' => 'Student Login Method',
'config_auth_sso_hybrid_pelajar_help' => 'Choose the login method for Student users.',
'config_auth_sso_hybrid_umum' => 'Public Login Method',
'config_auth_sso_hybrid_umum_help' => 'Choose the login method for Public users.',
'config_auth_hybrid_option_sso' => 'SSO',
'config_auth_hybrid_option_manual' => 'Manual',
'config_auth_enabled' => 'Enabled',
'config_auth_disabled' => 'Disabled',
'config_auth_allowed' => 'Allowed',
'config_auth_blocked' => 'Blocked',
'config_auth_category_note' => 'If all categories are disabled, only Super Admin remains able to log in.',
'config_auth_summary_status' => 'Configuration Status',
'config_auth_summary_status_ok' => 'Policy snapshot is ready for runtime use.',
'config_auth_summary_status_invalid_note' => 'Configuration must be corrected before runtime enforcement is enabled.',
'config_auth_summary_effective' => 'Effective Summary',
'config_auth_summary_not_configured' => 'Not configured',
'config_auth_summary_warnings' => 'Warnings',
'config_auth_summary_errors' => 'Errors',
'config_auth_status_valid' => 'Valid',
'config_auth_status_warning' => 'Valid with Warning',
'config_auth_status_invalid' => 'Invalid',
'config_auth_summary_maintenance_on' => 'Maintenance mode is enabled. Only Super Admin can log in.',
'config_auth_summary_maintenance_off' => 'Maintenance mode is disabled. Normal policy evaluation applies.',
'config_auth_summary_staff_enabled' => 'Staff login is enabled.',
'config_auth_summary_staff_disabled' => 'Staff login is disabled.',
'config_auth_summary_student_enabled' => 'Student login is enabled.',
'config_auth_summary_student_disabled' => 'Student login is disabled.',
'config_auth_summary_public_enabled' => 'Public login is enabled.',
'config_auth_summary_public_disabled' => 'Public login is disabled.',
'config_auth_summary_sso_enabled' => 'SSO is enabled in %s mode.',
'config_auth_summary_sso_disabled' => 'SSO is disabled. All allowed categories use manual login.',
'config_auth_summary_staff_auto_provision_enabled' => 'Staff SSO auto provision is enabled with default group %s.',
'config_auth_summary_staff_auto_provision_disabled' => 'Staff SSO auto provision is disabled.',
'config_auth_summary_student_auto_provision_enabled' => 'Student SSO auto provision is enabled with default group %s.',
'config_auth_summary_student_auto_provision_disabled' => 'Student SSO auto provision is disabled.',
'config_auth_warning_sso_disabled_mode' => 'SSO mode is configured but SSO is currently disabled.',
'config_auth_warning_all_categories_blocked' => 'All login categories are blocked. Only Super Admin will remain able to log in.',
'config_auth_warning_staff_auto_provision_group_missing' => 'Staff SSO auto provision is enabled but the default staff group code is empty.',
'config_auth_warning_student_auto_provision_group_missing' => 'Student SSO auto provision is enabled but the default student group code is empty.',
'config_auth_warning_staff_auto_provision_category_disabled' => 'Staff SSO auto provision is enabled while staff login is disabled.',
'config_auth_warning_student_auto_provision_category_disabled' => 'Student SSO auto provision is enabled while student login is disabled.',
'config_auth_warning_staff_auto_provision_route_manual' => 'Staff SSO auto provision is enabled but the current staff login route is not SSO.',
'config_auth_warning_student_auto_provision_route_manual' => 'Student SSO auto provision is enabled but the current student login route is not SSO.',
'config_auth_actions_note' => 'Changes here directly affect the active login policy and the allowed authentication method for each user category.',
'config_auth_save' => 'Save Login Policy',
'config_auth_success_title' => 'Success',
'config_auth_success_text' => 'Login policy settings were saved successfully.',
'config_auth_success_text_summary' => 'Login policy settings were saved successfully. Changes: %s.',
'config_auth_validation_title' => 'Validation Error',
'config_auth_validation_bool' => '%s must be a valid on/off value.',
'config_auth_validation_enum' => '%s must be one of the allowed values: %s.',
'config_auth_validation_int_range' => '%s must be a number between %d and %d.',
'config_auth_password_policy_core' => 'Password Core Policy',
'config_auth_password_policy_core_help' => 'These settings control the baseline rules used by password reset and change-password flows.',
'config_auth_password_min_length' => 'Minimum Password Length',
'config_auth_password_min_length_help' => 'Minimum number of characters required for a new password.',
'config_auth_password_expiry_days' => 'Password Expiry (Days)',
'config_auth_password_expiry_days_help' => 'Number of days before a password expires and must be updated.',
'config_auth_password_history_count' => 'Password History Count',
'config_auth_password_history_count_help' => 'Number of previous passwords that cannot be reused.',
'config_auth_password_reset_token_minutes' => 'Reset Link Expiry (Minutes)',
'config_auth_password_reset_token_minutes_help' => 'Maximum lifetime of a password reset link before it becomes invalid.',
'config_auth_password_complexity' => 'Password Complexity Rules',
'config_auth_password_complexity_help' => 'Choose which password composition checks must be enforced in change-password and reset-password flows.',
'config_auth_password_require_uppercase' => 'Require Uppercase Letter',
'config_auth_password_require_uppercase_help' => 'Require at least one uppercase letter in every new password.',
'config_auth_password_require_lowercase' => 'Require Lowercase Letter',
'config_auth_password_require_lowercase_help' => 'Require at least one lowercase letter in every new password.',
'config_auth_password_require_number' => 'Require Number',
'config_auth_password_require_number_help' => 'Require at least one numeric digit in every new password.',
'config_auth_password_require_symbol' => 'Require Symbol',
'config_auth_password_require_symbol_help' => 'Require at least one symbol such as ! @ # or % in every new password.',
'config_auth_password_block_loginid_variants' => 'Block Login ID Variants',
'config_auth_password_block_loginid_variants_help' => 'Reject passwords that contain the Login ID or close normalized variants of it.',
'config_auth_login_security' => 'Login Security Guardrails',
'config_auth_login_security_help' => 'Configure the failed-attempt threshold and lockout duration used when manual login keeps failing.',
'config_auth_login_max_attempts' => 'Maximum Failed Attempts',
'config_auth_login_max_attempts_help' => 'Number of failed manual-login attempts allowed before the identifier is locked.',
'config_auth_login_lock_seconds' => 'Lockout Duration (Seconds)',
'config_auth_login_lock_seconds_help' => 'How long the manual-login lockout remains active after the maximum failed attempts is reached.',
'config_auth_login_identifier_ip_max_attempts' => 'Login ID + IP Failed Attempts',
'config_auth_login_identifier_ip_max_attempts_help' => 'Maximum failed attempts allowed for the same Login ID from the same IP before that pair is throttled.',
'config_auth_login_identifier_ip_lock_seconds' => 'Login ID + IP Lockout Duration (Seconds)',
'config_auth_login_identifier_ip_lock_seconds_help' => 'How long the Login ID and IP pair remains throttled after hitting its failed-attempt limit.',
'config_auth_login_ip_max_attempts' => 'IP Failed Attempts',
'config_auth_login_ip_max_attempts_help' => 'Maximum failed attempts allowed from the same IP across accounts before that IP is throttled.',
'config_auth_login_ip_lock_seconds' => 'IP Lockout Duration (Seconds)',
'config_auth_login_ip_lock_seconds_help' => 'How long the IP remains throttled after hitting its failed-attempt limit.',
'config_auth_password_policy_future_note' => 'This subtab is intended to grow with future password settings such as complexity rules, Login ID matching rules, and forced-change behavior.',
'config_auth_save_error_title' => 'Save Error',
'config_auth_save_error_text' => 'Failed to save login policy settings. Please try again or contact the system administrator.',
'config_auth_system_error_title' => 'System Error',
'config_auth_system_error_text' => 'An error occurred while saving login policy settings. Please check the system log for more details.',
'config_auth_audit_message' => 'Login policy settings updated (%d fields): %s',
'config_auth_audit_no_changes' => 'no field changes',

'config_general_brand_header' => 'System Identity',
'config_general_brand_sub' => 'Primary display and system metadata',
'config_general_mail_header' => 'Mail Identity',
'config_general_mail_sub' => 'System name and common links for email templates',
'config_general_site_title' => 'Site Title',
'config_general_site_favicon' => 'Favicon Path',
'config_general_site_default_home' => 'Default Home Route',
'config_general_system_name' => 'System Name',
'config_general_meta_author' => 'Meta Author',
'config_general_support_email' => 'Support Email',
'config_general_branding_login_header_logo' => 'Login Header Logo',
'config_general_branding_login_panel_logo' => 'Login Panel Logo',
'config_general_branding_topbar_logo_light' => 'Topbar Logo Light',
'config_general_branding_topbar_logo_dark' => 'Topbar Logo Dark',
'config_general_branding_topbar_logo_sm' => 'Topbar Logo Small',
'config_general_branding_sidebar_logo' => 'Sidebar Logo',
'config_general_session_idle_timeout_minutes' => 'Idle Timeout (Minutes)',
'config_general_upload_manual_max_mb' => 'Manual Upload Max Size (MB)',
'config_general_footer_text' => 'Footer Text',
'config_general_footer_text_ms' => 'Footer Text (BM)',
'config_general_footer_text_en' => 'Footer Text (EN)',
'config_general_org_name' => 'Organization Name',
'config_general_org_short' => 'Organization Short Code',
'config_general_org_website' => 'Organization Website',
'config_general_mail_system_name' => 'Mail System Name',
'config_general_mail_action_url' => 'Default Action URL',
'config_general_mail_footer_note' => 'Mail Footer Note',
'config_general_mail_footer_note_ms' => 'Mail Footer Note (BM)',
'config_general_mail_footer_note_en' => 'Mail Footer Note (EN)',
'config_general_note' => 'These settings only store overrides in the database. The settings.php file remains the base system configuration.',
'config_general_subtab_site' => 'Site',
'config_general_subtab_branding' => 'Branding',
'config_general_subtab_identity' => 'System & Organization',
'config_general_subtab_mail' => 'Mail',
'config_general_subtab_limits' => 'Limits',
'config_general_subtab_site_note' => 'Site settings control the browser title, favicon, and the system default entry route.',
'config_general_subtab_branding_note' => 'All branding paths refer to visual assets such as login, topbar, and sidebar logos.',
'config_general_subtab_identity_note' => 'This section controls system identity, organization details, metadata, and the global footer.',
'config_general_subtab_mail_note' => 'Use this subtab for general identity values used by the system email templates.',
'config_general_subtab_limits_note' => 'These behavior limits affect session inactivity timeout and the maximum manual upload size.',
'config_general_site_title_help' => 'Primary system name for the browser title and general display.',
'config_general_site_favicon_help' => 'Path to the small icon shown on the browser tab.',
'config_general_site_default_home_help' => 'Main landing route after login and for system logo links.',
'config_general_branding_login_header_logo_help' => 'Logo displayed at the top area of the login page.',
'config_general_branding_login_panel_logo_help' => 'Primary logo inside the login panel.',
'config_general_branding_topbar_logo_light_help' => 'Logo used for the light topbar theme.',
'config_general_branding_topbar_logo_dark_help' => 'Logo used for the dark topbar theme.',
'config_general_branding_topbar_logo_sm_help' => 'Compact logo version for the small topbar state.',
'config_general_branding_sidebar_logo_help' => 'Logo displayed inside the system sidebar.',
'config_general_system_name_help' => 'Official system name for the main application display.',
'config_general_meta_author_help' => 'Meta author value used in the page head metadata.',
'config_general_support_email_help' => 'Primary support email for administrator or user reference.',
'config_general_org_name_help' => 'Full name of the organization that owns the system.',
'config_general_org_short_help' => 'Short code or abbreviation for the organization.',
'config_general_org_website_help' => 'Official organization website URL.',
'config_general_footer_text_help' => 'Global footer text shown at the bottom of the system.',
'config_general_mail_system_name_help' => 'System name shown in email templates.',
'config_general_mail_action_url_help' => 'Default action link used by system emails when applicable.',
'config_general_mail_footer_note_help' => 'Standard footer note shown at the end of system emails.',
'config_general_session_idle_timeout_minutes_help' => 'Inactivity duration before the system shows the session timeout warning.',
'config_general_upload_manual_max_mb_help' => 'Maximum PDF file size limit for the user manual module.',
'config_general_actions_note' => 'Changes here override the base settings.php values without rewriting the original file.',
'config_general_save' => 'Save General Settings',
'config_general_success_title' => 'General Settings',
'config_general_success_text' => 'General settings saved successfully.',
'config_general_success_text_summary' => 'General settings saved successfully. Changes: %s.',
'config_general_validation_title' => 'Validation Error',
'config_general_validation_max' => '%s is too long (maximum %d characters).',
'config_general_validation_email' => '%s must be a valid email address.',
'config_general_validation_url' => '%s must be a valid URL or #.',
'config_general_validation_int' => '%s must be a valid integer.',
'config_general_validation_int_range' => '%s must be between %d and %d.',
'config_general_save_error_title' => 'Save Error',
'config_general_save_error_text' => 'Failed to save general settings. Please try again or contact the system administrator.',
'config_general_system_error_title' => 'System Error',
'config_general_system_error_text' => 'An error occurred while saving general settings. Please check the system log for more details.',
'config_general_audit_message' => 'General settings updated (%d fields): %s',
'config_general_audit_no_changes' => 'no field changes',

/* =========================
 * TAB EMEL
 * ========================= */
'config_tab_emel_header_setting'        => 'Email Server Configuration',
'config_tab_emel_header_setting_sub'    => 'Server configuration',
'config_tab_emel_driver'                => 'Email Driver',
'config_tab_emel_host'                  => 'Email Host',
'config_tab_emel_port'                  => 'Port',
'config_tab_emel_encryption'            => 'Encryption',
'config_tab_emel_sel_tiada'             => 'None',

'config_tab_emel_header_emel'            => 'Email Account Details',
'config_tab_emel_header_emel_sub'        => 'Sender identity and credentials',
'config_tab_emel_account_emel'           => 'Email Account (Username)',
'config_tab_emel_katalaluan_emel'        => 'Email Password',
'config_tab_emel_password_hint'          => 'Leave blank to keep current password',
'config_tab_emel_from'                   => 'Email From',
'config_tab_emel_from_name'              => 'Sender Name',
'config_tab_emel_note_server'            => 'Use the actual SMTP configuration permitted by the server.',
'config_tab_emel_note_sender'            => 'Ensure the From address and SMTP account match the server policy to avoid rejected messages.',
'config_tab_emel_actions_note'           => 'Save only after the SMTP details and email account have been verified.',

'config_tab_emel_uji_emel'               => 'Test Email Connection',
'config_tab_emel_simpan_tetapan_emel'    => 'Save Email Settings',
'config_email_validation_title'          => 'Validation Error',
'config_email_validation_max'            => '%s is too long (maximum %d characters).',
'config_email_validation_host'           => '%s is invalid. Please enter a valid domain or IP address.',
'config_email_validation_port_numeric'   => '%s must be numeric.',
'config_email_validation_port_range'     => '%s must be between %d and %d.',
'config_email_validation_email'          => '%s is invalid. Please enter a valid email address.',
'config_email_validation_encryption'     => '%s is invalid. Only %s are allowed.',
'config_email_validation_driver'         => '%s is invalid. Only %s are allowed.',
'config_email_success_text_summary'      => 'Email settings saved successfully. Changes: %s.',
'config_email_save_error_title'          => 'Save Error',
'config_email_save_error_text'           => 'Failed to save email settings. Please try again or contact the system administrator.',
'config_email_system_error_title'        => 'System Error',
'config_email_system_error_text'         => 'An error occurred while saving email settings. Please check the system log for more details.',
'config_email_audit_message'             => 'Email settings updated (%d fields): %s',
'config_email_audit_no_changes'          => 'no field changes',

/* =========================
 * TAB DATABASE
 * ========================= */
'config_tab_db_container_sub'            => 'Manage Sybase runtime selection and view the main MySQL connection details.',
'config_tab_db_header'                   => 'Sybase (Select One Only)',
'config_tab_db_header_sub'               => 'Select one active Sybase connection',
'config_tab_db_sybase_header'            => 'Only one Sybase connection can be active at a time.',
'config_tab_db_sybase_sambungan'         => 'Connection Name',
'config_tab_db_sybase_keterangan'        => 'Description',
'config_tab_db_environment_production'   => 'Production',
'config_tab_db_environment_production_desc'
                                        => 'Use the production staff Sybase connection for live system operations.',
'config_tab_db_environment_development'  => 'Development',
'config_tab_db_environment_development_desc'
                                        => 'Use the development staff Sybase connection for testing and staging work.',
'config_tab_db_mode_header'              => 'Operational Mode',
'config_tab_db_mode_header_sub'          => 'Choose which Sybase domains are enabled for the system',
'config_tab_db_mode_note'                => 'This mode determines whether the system only uses the staff domain or allows both staff and student domains.',
'config_tab_db_mode_column'              => 'Mode',
'config_tab_db_mode_desc_column'         => 'Description',
'config_tab_db_mode_staff_only'          => 'Staff Only',
'config_tab_db_mode_staff_only_desc'     => 'Only the staff domain is used. The student connection remains disabled.',
'config_tab_db_mode_staff_student'       => 'Staff + Student',
'config_tab_db_mode_staff_student_desc'  => 'Both staff and student domains are enabled.',
'config_tab_db_runtime_header'           => 'Current Runtime Summary',
'config_tab_db_runtime_header_sub'       => 'This summary shows how the current runtime will behave after the settings are saved.',
'config_tab_db_runtime_field'            => 'Component',
'config_tab_db_runtime_value'            => 'Runtime Value',
'config_tab_db_runtime_staff'            => 'Sybase Staff',
'config_tab_db_runtime_student'          => 'Sybase Student',
'config_tab_db_runtime_environment'      => 'Environment',
'config_tab_db_runtime_mode'             => 'Operational Mode',
'config_tab_db_runtime_disabled'         => 'Disabled',
'config_tab_db_subtab_sybase'            => 'Sybase',
'config_tab_db_subtab_mysql'             => 'MySQL',
'config_tab_db_subtab_additional'        => 'Additional Connections',
'config_tab_db_sybase_subtab_note'       => 'Manage Sybase runtime selection, operational mode, and the active connection summary in one view.',
'config_tab_db_mysql_subtab_note'        => 'This view shows the primary MySQL connection that remains active for the system.',
'config_tab_db_mysql_environment_header' => 'Main MySQL Environment',
'config_tab_db_mysql_environment_sub'    => 'Choose the active environment for the primary MySQL system connection.',
'config_tab_db_mysql_environment_production_desc'
                                        => 'Use the primary production MySQL connection for live system operations.',
'config_tab_db_mysql_environment_development_desc'
                                        => 'Use the primary development MySQL connection for testing and staging.',

'config_tab_db_sybase_nama_production'   => 'e-HRMDB (Production)',
'config_tab_db_sybase_nama_production_penerangan'
                                        => 'Primary database',

'config_tab_db_sybase_nama_development'  => 'e-HRMDB (Development)',
'config_tab_db_sybase_nama_development_penerangan'
                                        => 'Development database',

'config_tab_db_mysql'                    => 'MySQL (Always Active)',
'config_tab_db_mysql_sub'                => 'Always active connection',
'config_tab_db_mysql_header'             => 'This connection is always active for the main system.',
'config_tab_db_mysql_sambungan'          => 'Field',
'config_tab_db_mysql_keterangan'         => 'Information',
'config_tab_db_mysql_host'               => 'Host',
'config_tab_db_mysql_driver'             => 'Driver',
'config_tab_db_mysql_database'           => 'Database',
'config_tab_db_mysql_user'               => 'User',
'config_tab_db_mysql_status'             => 'Status',
'config_tab_db_additional_note'          => 'Additional connections are managed separately for reporting, reference, integration, and supporting transactions without affecting the 3 main system databases.',
'config_tab_db_additional_header'        => 'Additional Connections Registry',
'config_tab_db_additional_sub'           => 'Each connection here is optional and only used by features that need it.',
'config_tab_db_additional_refresh'       => 'Refresh',
'config_tab_db_additional_add'           => 'Add Connection',
'config_tab_db_additional_search'        => 'Search code, name, type, purpose...',
'config_tab_db_additional_filter_all_types' => 'All database types',
'config_tab_db_additional_filter_all_status' => 'All statuses',
'config_tab_db_additional_enabled'       => 'Enabled',
'config_tab_db_additional_disabled'      => 'Disabled',
'config_tab_db_additional_code'          => 'Code',
'config_tab_db_additional_name'          => 'Name',
'config_tab_db_additional_type'          => 'Type',
'config_tab_db_additional_purpose'       => 'Purpose',
'config_tab_db_additional_env'           => 'Environment',
'config_tab_db_additional_status'        => 'Status',
'config_tab_db_additional_last_test'     => 'Last Test',
'config_tab_db_additional_actions'       => 'Actions',
'config_tab_db_additional_loading'       => 'Loading additional connection list...',
'config_tab_db_additional_empty_title'   => 'No additional connections yet.',
'config_tab_db_additional_empty_text'    => 'Add the first connection for reporting, reference, or integration.',
'config_tab_db_additional_modal_add'     => 'Add Additional Connection',
'config_tab_db_additional_modal_edit'    => 'Update Additional Connection',
'config_tab_db_additional_modal_sub'     => 'Changes here will not alter the main MySQL and Sybase runtime.',
'config_tab_db_additional_driver_mode'   => 'Driver Mode',
'config_tab_db_additional_notes'         => 'Notes',
'config_tab_db_additional_notes_placeholder'
                                        => 'Optional notes for administrator reference',
'config_tab_db_additional_enabled_default' => 'Connection enabled',
'config_tab_db_additional_supports_prod' => 'Supports production',
'config_tab_db_additional_supports_dev'  => 'Supports development',
'config_tab_db_additional_env_configs'   => 'Environment Configurations',
'config_tab_db_additional_env_configs_sub'
                                        => 'Add one or more environment rows based on the required driver and OS.',
'config_tab_db_additional_add_env_row'   => 'Add Env Row',
'config_tab_db_additional_save'          => 'Save Connection',
'config_tab_db_additional_last_test_none' => 'Not tested yet',
'config_tab_db_additional_inspect_title' => 'Additional Connection Details',
'config_tab_db_additional_schema_title'  => 'Schema Preview',
'config_tab_db_additional_data_preview_title' => 'Data Preview',
'config_tab_db_additional_sample_code'   => 'Sample Code',
'config_tab_db_additional_sample_code_programmer' => 'Sample Code for Programmer',
'config_tab_db_additional_sample_code_note' => 'Use this helper so credentials, environment, driver fallback, and PDO cache are controlled by the system registry. Do not hardcode DSN, host, username, or password in modules.',
'config_tab_db_additional_sample_basic_pdo' => 'Basic PDO',
'config_tab_db_additional_sample_prepared_query' => 'Prepared Query',
'config_tab_db_additional_sample_transaction' => 'Transaction',
'config_tab_db_additional_sample_error_handling' => 'Error Handling',
'config_tab_db_additional_copy'          => 'Copy',
'config_tab_db_additional_copied'        => 'Copied',
'config_tab_db_additional_connection'    => 'Additional Connection',
'config_tab_db_additional_family'        => 'Family',
'config_tab_db_additional_edit'          => 'Edit',
'config_tab_db_additional_test'          => 'Test Connection',
'config_tab_db_additional_enable'        => 'Enable',
'config_tab_db_additional_disable'       => 'Disable',
'config_tab_db_additional_no_env_rows'   => 'No env rows',
'config_tab_db_additional_env_row'       => 'Env Row',
'config_tab_db_additional_env_row_help'  => 'Each row represents one environment, OS, and driver combination.',
'config_tab_db_additional_remove'        => 'Remove',
'config_tab_db_additional_os_family'     => 'OS Family',
'config_tab_db_additional_os_any'        => 'Any',
'config_tab_db_additional_os_windows'    => 'Windows',
'config_tab_db_additional_os_linux'      => 'Linux',
'config_tab_db_additional_active'        => 'Active',
'config_tab_db_additional_username'      => 'Username',
'config_tab_db_additional_password'      => 'Password',
'config_tab_db_additional_charset'       => 'Charset',
'config_tab_db_additional_search_short'  => 'Search',
'config_tab_db_additional_not_found'     => 'Additional connection not found.',
'config_tab_db_additional_empty_response' => 'Empty server response. Please check the server log for data preview.',
'config_tab_db_additional_refresh_failed' => 'Failed to refresh additional connections.',
'config_tab_db_additional_form_missing'  => 'Additional connection form is not available.',
'config_tab_db_additional_save_failed'   => 'Failed to save additional connection.',
'config_tab_db_additional_save_success'  => 'Additional connection saved successfully.',
'config_tab_db_additional_inspect_failed' => 'Failed to load additional connection details.',
'config_tab_db_additional_schema_failed' => 'Failed to load additional connection schema preview.',
'config_tab_db_additional_data_preview_failed' => 'Failed to load additional connection data preview.',
'config_tab_db_additional_test_failed'   => 'Additional connection test failed.',
'config_tab_db_additional_test_success'  => 'Additional connection test passed.',
'config_tab_db_additional_object_name'   => 'Object Name',
'config_tab_db_additional_object_type'   => 'Type',
'config_tab_db_additional_preview_action' => 'Preview',
'config_tab_db_additional_no_objects'    => 'No objects found.',
'config_tab_db_additional_no_rows'       => 'No rows found.',
'config_tab_db_additional_current_db'    => 'Current Database',
'config_tab_db_additional_current_user'  => 'Current User',
'config_tab_db_additional_server_time'   => 'Server Time',
'config_tab_db_additional_server_version' => 'Server Version',
'config_tab_db_additional_active_driver' => 'Active Driver',
'config_tab_db_additional_configured_driver' => 'Configured Driver',
'config_tab_db_additional_database'      => 'Database',
'config_tab_db_additional_ping'          => 'Ping',

'config_tab_db_simpan_tetapan_db'        => 'Save Database Settings',
'config_tab_db_actions_note'             => 'Ensure the selected environment and operational mode have been tested and verified before saving.',
'config_db_validation_title'             => 'Validation Error',
'config_db_validation_required'          => 'Please complete the database configuration selection.',
'config_db_validation_invalid'           => 'Invalid database configuration selection.',
'config_db_success_title'                => 'Success',
'config_db_success_text_summary'         => 'Database settings saved successfully. MySQL: %s. Sybase environment: %s. Mode: %s.',
'config_db_connection_error_title'       => 'Database Connection Error',
'config_db_connection_error_text'        => 'Database connection failed. Please review the database connection configuration or contact the system administrator.',
'config_db_runtime_error_text'           => 'An error occurred while activating the database.',
'config_db_system_error_title'           => 'System Error',
'config_db_system_error_text'            => 'An error occurred while activating the database. Please try again or contact the system administrator.',
'config_db_audit_message'                => 'Database settings updated: %s',
'config_db_audit_summary'                => 'Staff DB: %s -> %s | Environment: %s -> %s | Mode: %s -> %s',

/* =========================
 * TAB TEMA
 * ========================= */
'config_tab_tema_komponen'               => 'Component',
'config_tab_tema_pilihan'                => 'Theme Option',

// Layout
'config_tab_tema_komponen_layout'        => 'Layout Mode',
'config_tab_tema_komponen_layout_sub'    => 'Layout mode',
'config_tab_tema_pilihan_layout_terang'  => 'Light',
'config_tab_tema_pilihan_layout_gelap'   => 'Dark',
'config_tab_tema_note_layout'            => 'Choose the primary layout mode for the system experience.',
'config_tab_tema_desc_layout_light'      => 'Clean and neutral light mode',
'config_tab_tema_desc_layout_dark'       => 'Suitable for night use',
'config_tab_tema_penerangan_layout_terang_penerangan'
                                        => 'Fully light design — standard light mode.',
'config_tab_tema_penerangan_layout_gelap_penerangan'
                                        => 'Dark layout — suitable for night use.',

// Topbar
'config_tab_tema_komponen_topbar'        => 'Topbar Color',
'config_tab_tema_komponen_topbar_sub'    => 'Topbar color',
'config_tab_tema_pilihan_topbar_terang'  => 'Light',
'config_tab_tema_pilihan_topbar_gelap'   => 'Dark',
'config_tab_tema_pilihan_layout_brand'   => 'Brand',
'config_tab_tema_pilihan_layout_emerald' => 'Emerald',
'config_tab_tema_pilihan_layout_navy'    => 'Navy',
'config_tab_tema_pilihan_layout_sunset'  => 'Sunset',
'config_tab_tema_pilihan_layout_mist'    => 'Mist',
'config_tab_tema_pilihan_layout_strawberry' => 'Strawberry Pink',
'config_tab_tema_pilihan_layout_matcha' => 'Matcha',
'config_tab_tema_note_topbar'            => 'Match the topbar color with the selected mode and system visual identity.',
'config_tab_tema_desc_topbar_light'      => 'Suitable for light mode',
'config_tab_tema_desc_topbar_dark'       => 'Suitable for dark mode',
'config_tab_tema_desc_topbar_brand'      => 'Official system color',
'config_tab_tema_desc_topbar_emerald'    => 'Fresh modern green with a professional tone',
'config_tab_tema_desc_topbar_navy'       => 'Deep corporate blue for a formal interface',
'config_tab_tema_desc_topbar_sunset'     => 'Warm sunset orange with stronger visual character',
'config_tab_tema_desc_topbar_mist'       => 'Soft frosted gradient for a bright and polished interface',
'config_tab_tema_desc_topbar_strawberry' => 'Soft strawberry pink with a warm and modern character',
'config_tab_tema_desc_topbar_matcha' => 'Soft matcha green with a calm, fresh, and premium feel',
'config_tab_tema_penerangan_topbar_terang_penerangan'
                                        => 'Light topbar, suitable for light mode.',
'config_tab_tema_penerangan_topbar_gelap_penerangan'
                                        => 'Dark topbar, suitable for night or dark mode.',
'config_tab_tema_penerangan_topbar_brand_penerangan'
                                        => 'Topbar follows system brand color.',

// Sidebar
'config_tab_tema_komponen_sidebar'       => 'Sidebar Color',
'config_tab_tema_komponen_sidebar_sub'   => 'Sidebar color',
'config_tab_tema_pilihan_sidebar_terang' => 'Light',
'config_tab_tema_pilihan_sidebar_gelap'  => 'Dark',
'config_tab_tema_pilihan_sidebar_brand'  => 'Brand',
'config_tab_tema_pilihan_sidebar_emerald' => 'Emerald',
'config_tab_tema_pilihan_sidebar_navy'    => 'Navy',
'config_tab_tema_pilihan_sidebar_sunset'  => 'Sunset',
'config_tab_tema_pilihan_sidebar_mist'    => 'Mist',
'config_tab_tema_pilihan_sidebar_strawberry' => 'Strawberry Pink',
'config_tab_tema_pilihan_sidebar_matcha' => 'Matcha',
'config_tab_tema_note_sidebar'           => 'Choose the clearest and most comfortable sidebar color for daily navigation.',
'config_tab_tema_desc_sidebar_light'     => 'Clean white background',
'config_tab_tema_desc_sidebar_dark'      => 'Comfortable for the eyes',
'config_tab_tema_desc_sidebar_brand'     => 'Primary brand color',
'config_tab_tema_desc_sidebar_emerald'   => 'Clean modern green for professional navigation',
'config_tab_tema_desc_sidebar_navy'      => 'Formal dark blue for a corporate navigation tone',
'config_tab_tema_desc_sidebar_sunset'    => 'Warm sunset tone with a stronger visual presence',
'config_tab_tema_desc_sidebar_mist'      => 'Soft mist gradient with a clean and premium navigation feel',
'config_tab_tema_desc_sidebar_strawberry' => 'Richer strawberry rose for navigation that feels soft yet distinctive',
'config_tab_tema_desc_sidebar_matcha' => 'Soft and mature matcha green for calmer navigation',
'theme_emerald' => 'Emerald',
'theme_navy' => 'Navy',
'theme_sunset' => 'Sunset',
'theme_mist' => 'Mist',
'theme_strawberry' => 'Strawberry Pink',
'theme_matcha' => 'Matcha',
'config_tab_tema_penerangan_sidebar_terang_penerangan'
                                        => 'Light sidebar with clean white background.',
'config_tab_tema_penerangan_sidebar_gelap_penerangan'
                                        => 'Dark sidebar, comfortable for night mode.',
'config_tab_tema_penerangan_sidebar_brand_penerangan'
                                        => 'Sidebar uses main system brand color.',

'config_tab_db_simpan_tetapan_tema'      => 'Save Theme Settings',
'config_tab_tema_actions_note'           => 'Save only after the layout, topbar, and sidebar combination feels right.',
'config_theme_validation_title'          => 'Validation Error',
'config_theme_validation_invalid'        => '%s is invalid. Only %s are allowed.',

// =========================
// Email Template
// =========================
'emailTemplate_page_title' => 'Email Template',
'emailTemplate_list_title' => 'Email Template List',
'emailTemplate_list_subtitle' => 'Manage reusable email templates by role, category, and system workflow.',
'emailTemplate_error_load_records' => 'Failed to load email template records.',
'emailTemplate_status_active' => 'Active',
'emailTemplate_status_draft' => 'Draft',
'emailTemplate_status_archived' => 'Archived',
'emailTemplate_role_staff' => 'Staff',
'emailTemplate_role_student' => 'Student',
'emailTemplate_role_public' => 'Public',
'emailTemplate_role_admin' => 'Administrator',
'emailTemplate_category_welcome' => 'Welcome',
'emailTemplate_category_notification' => 'Notification',
'emailTemplate_category_reminder' => 'Reminder',
'emailTemplate_category_approval' => 'Approval',
'emailTemplate_category_rejection' => 'Rejection',
'emailTemplate_category_security' => 'Security',
'emailTemplate_category_custom' => 'Custom',
'emailTemplate_placeholder_group_recipient' => 'Recipient',
'emailTemplate_placeholder_group_organization' => 'Organization',
'emailTemplate_placeholder_group_system' => 'System',
'emailTemplate_placeholder_group_sender' => 'Sender',
'emailTemplate_placeholder_group_date' => 'Date',
'emailTemplate_summary_total' => 'Total Templates',
'emailTemplate_summary_active' => 'Active',
'emailTemplate_summary_draft' => 'Draft',
'emailTemplate_summary_archived' => 'Archived',
'emailTemplate_hero_kicker' => 'Email Template Workspace',
'emailTemplate_hero_title' => 'One general module to manage email templates, render previews, and hand off directly to developers.',
'emailTemplate_hero_subtitle' => 'Start with seed templates aligned to real system use cases, then refine placeholders and content for each module workflow.',
'emailTemplate_action_create' => 'Add Template',
'emailTemplate_action_filter' => 'Filter',
'emailTemplate_btn_seed_templates' => 'Import Seed Templates',
'emailTemplate_filter_role' => 'Role',
'emailTemplate_filter_category' => 'Category',
'emailTemplate_filter_status' => 'Status',
'emailTemplate_filter_search' => 'Search',
'emailTemplate_filter_all_roles' => 'All Roles',
'emailTemplate_filter_all_categories' => 'All Categories',
'emailTemplate_filter_all_statuses' => 'All Statuses',
'emailTemplate_filter_search_placeholder' => 'Search name, code, or subject',
'emailTemplate_col_template' => 'Template',
'emailTemplate_col_usage' => 'Usage',
'emailTemplate_col_role' => 'Role',
'emailTemplate_col_category' => 'Category',
'emailTemplate_col_subject' => 'Subject',
'emailTemplate_col_status' => 'Status',
'emailTemplate_col_updated' => 'Updated',
'emailTemplate_col_actions' => 'Actions',
'emailTemplate_badge_default' => 'Default',
'emailTemplate_badge_default_active' => 'Active Default',
'emailTemplate_default_note' => 'Set another default first before archiving.',
'emailTemplate_usage_label' => 'Usage',
'emailTemplate_inline_general_placeholders' => 'General placeholders',
'emailTemplate_inline_seed_templates' => 'Seed templates',
'emailTemplate_btn_edit' => 'Edit',
'emailTemplate_btn_duplicate' => 'Duplicate',
'emailTemplate_btn_archive' => 'Archive',
'emailTemplate_btn_delete' => 'Delete',
'emailTemplate_btn_close' => 'Close',
'emailTemplate_btn_confirm' => 'OK',
'emailTemplate_btn_cancel' => 'Cancel',
'emailTemplate_btn_archive_confirm' => 'Yes, Archive',
'emailTemplate_btn_delete_confirm' => 'Yes, Delete',
'emailTemplate_btn_save' => 'Save Template',
'emailTemplate_btn_update' => 'Update Template',
'emailTemplate_modal_create_title' => 'Add Email Template',
'emailTemplate_modal_edit_title' => 'Update Email Template',
'emailTemplate_modal_subtitle' => 'Prepare the core template details, email content, general placeholders, and render preview before handing the template to developers.',
'emailTemplate_tab_editor' => 'Details & Editor',
'emailTemplate_tab_placeholders' => 'Placeholders',
'emailTemplate_tab_preview' => 'Preview & Test',
'emailTemplate_tab_developer' => 'Developer',
'emailTemplate_field_template_name' => 'Template Name',
'emailTemplate_field_template_code' => 'Template Code',
'emailTemplate_field_role' => 'Role',
'emailTemplate_field_category' => 'Category',
'emailTemplate_field_status' => 'Status',
'emailTemplate_field_description' => 'Short Description',
'emailTemplate_field_description_placeholder' => 'Summarize the purpose of this template',
'emailTemplate_field_subject' => 'Email Subject',
'emailTemplate_field_body_html' => 'HTML Content',
'emailTemplate_field_body_text' => 'Text Content',
'emailTemplate_field_notes' => 'Internal Notes',
'emailTemplate_field_is_default' => 'Default template for this role and category',
'emailTemplate_select_role' => 'Select role',
'emailTemplate_select_category' => 'Select category',
'emailTemplate_hint_body_html' => 'Use plain HTML here. Review the final output in the Preview & Test tab.',
'emailTemplate_error_archive_default_blocked' => 'The default template cannot be archived until another template is set as default for the same role and category.',
'emailTemplate_error_duplicate_failed' => 'The template copy could not be generated. Please try again.',
'emailTemplate_archive_default_tooltip' => 'Set another template as default before archiving this one.',
'emailTemplate_delete_default_tooltip' => 'Set another template as default before deleting this template.',
'emailTemplate_delete_used_tooltip' => 'Templates that have been used cannot be deleted.',
'emailTemplate_placeholder_title' => 'General Placeholders',
'emailTemplate_placeholder_subtitle' => 'Click a placeholder to insert it directly into the active field.',
'emailTemplate_guideline_title' => 'System Guidelines',
'emailTemplate_guideline_1' => 'Template codes act as stable references for system modules and integrations.',
'emailTemplate_guideline_2' => 'Default templates support email flows that resolve by role and category only.',
'emailTemplate_guideline_3' => 'Page-specific placeholders are supplied through integration on the relevant module or page.',
'emailTemplate_preview_title' => 'Preview & Test Send',
'emailTemplate_preview_subtitle' => 'Use sample JSON to test placeholders, inspect final output, and send a test email before publishing.',
'emailTemplate_field_sample_variables' => 'Sample Variables JSON',
'emailTemplate_field_test_email' => 'Test Email',
'emailTemplate_btn_preview' => 'Render Preview',
'emailTemplate_btn_test_send' => 'Send Test Email',
'emailTemplate_preview_subject_title' => 'Preview Result',
'emailTemplate_preview_subject_subtitle' => 'Subject, placeholder status, and text output will appear here.',
'emailTemplate_preview_used_placeholders' => 'Used Placeholders',
'emailTemplate_preview_missing_placeholders' => 'Placeholders Missing Values',
'emailTemplate_preview_invalid_placeholders' => 'Invalid Placeholders',
'emailTemplate_preview_text_output' => 'Text Output',
'emailTemplate_preview_html_title' => 'HTML Preview',
'emailTemplate_preview_html_subtitle' => 'Final email rendering after being wrapped with the standard system layout.',
'emailTemplate_dev_title' => 'Programmer Integration Guide',
'emailTemplate_dev_subtitle' => 'Use this section to see the placeholders used, the default system placeholders, and a sample code snippet for calling the template.',
'emailTemplate_dev_used_placeholders' => 'Placeholders Used In This Template',
'emailTemplate_dev_default_placeholders' => 'Available Default Placeholders',
'emailTemplate_dev_programmer_values' => 'Values The Programmer Must Supply',
'emailTemplate_dev_reference_notes' => 'Quick Notes',
'emailTemplate_dev_note_1' => 'Default placeholders come from render context or system settings during template rendering.',
'emailTemplate_dev_note_2' => 'Non-default placeholders must be supplied by the programmer through the variables array.',
'emailTemplate_dev_note_3' => 'Use the template code as the stable reference in module integration.',
'emailTemplate_dev_snippet_title' => 'Sample Code',
'emailTemplate_dev_snippet_subtitle' => 'This code is generated based on the current template code and placeholders.',
'emailTemplate_dev_copy_snippet' => 'Copy Code',
'emailTemplate_dev_no_placeholders' => 'No placeholders are used.',
'emailTemplate_dev_no_programmer_values' => 'No custom values are required.',
'emailTemplate_dev_badge_default' => 'Default',
'emailTemplate_dev_badge_programmer' => 'Programmer',
'emailTemplate_dev_badge_general' => 'General',
'emailTemplate_dev_snippet_copied' => 'Sample code copied successfully.',
'emailTemplate_preview_empty_subject' => 'Not generated yet',
'emailTemplate_preview_empty_text' => 'Click Render Preview to see the text output of this template.',
'emailTemplate_preview_success' => 'Template preview was generated successfully.',
'emailTemplate_preview_failed_title' => 'Preview Failed',
'emailTemplate_error_preview_required' => 'Subject and HTML content are required for preview.',
'emailTemplate_error_preview_failed' => 'A system error occurred while generating the email template preview.',
'emailTemplate_error_sample_json_invalid' => 'Sample variables must be valid JSON.',
'emailTemplate_test_send_success' => 'Test email was sent successfully.',
'emailTemplate_test_send_success_title' => 'Test Email Sent',
'emailTemplate_test_send_failed_title' => 'Test Email Failed',
'emailTemplate_error_test_email_invalid' => 'Test email address is invalid.',
'emailTemplate_error_test_send_failed' => 'The test email could not be sent.',
'emailTemplate_network_error' => 'A network error occurred while processing the request.',
'emailTemplate_error_invalid_csrf' => 'Your session has expired. Refresh the page and try again.',
'emailTemplate_error_validation' => 'Please review the email template details that were entered.',
'emailTemplate_error_template_code_required' => 'Template code is required.',
'emailTemplate_error_template_code_format' => 'Template code may only contain uppercase letters, numbers, dashes, and underscores.',
'emailTemplate_error_template_code_exists' => 'Template code is already in use.',
'emailTemplate_modal_close_aria' => 'Close',
'emailTemplate_field_template_code_example' => 'STAFF_REMINDER_APPROVAL',
'emailTemplate_field_test_email_placeholder' => 'admin@example.com',
'emailTemplate_swal_ok' => 'OK',
'emailTemplate_loading_processing' => 'Processing...',
'emailTemplate_loading_preview' => 'Preview...',
'emailTemplate_loading_sending' => 'Sending...',
'emailTemplate_error_invalid_json' => 'Invalid JSON.',
'emailTemplate_preview_empty_used' => 'None',
'emailTemplate_preview_empty_missing' => 'Complete',
'emailTemplate_preview_empty_invalid' => 'None',
'emailTemplate_error_test_email_required' => 'A test email address is required.',
'emailTemplate_error_preview_rate_limited' => 'Too many preview requests. Please wait a moment and try again.',
'emailTemplate_error_test_send_rate_limited' => 'Too many test email requests. Please wait a moment and try again.',
'emailTemplate_error_invalid_action' => 'The requested action is invalid.',
'emailTemplate_error_subject_too_long' => 'The template subject is too long.',
'emailTemplate_error_body_html_too_long' => 'The template HTML content is too long.',
'emailTemplate_error_body_text_too_long' => 'The template text content is too long.',
'emailTemplate_error_sample_json_too_large' => 'The sample variables JSON is too large.',
'emailTemplate_error_template_name_required' => 'Template name is required.',
'emailTemplate_error_role_required' => 'Recipient role is required.',
'emailTemplate_error_category_required' => 'Email category is required.',
'emailTemplate_error_subject_required' => 'Template subject is required.',
'emailTemplate_error_body_html_required' => 'Email content is required.',
'emailTemplate_error_status_required' => 'Template status is invalid.',
'emailTemplate_save_success_create' => 'Email template was created successfully.',
'emailTemplate_save_success_update' => 'Email template was updated successfully.',
'emailTemplate_duplicate_success' => 'Email template copy was created successfully.',
'emailTemplate_archive_success' => 'Email template was archived successfully.',
'emailTemplate_seed_success' => 'Seed templates were imported successfully.',
'emailTemplate_archive_confirm' => 'Archive this template?',
'emailTemplate_archive_confirm_text' => 'This template will be moved to archived status.',
'emailTemplate_delete_confirm' => 'Delete this template?',
'emailTemplate_delete_confirm_text' => 'This template will be permanently deleted if it has never been used.',
'emailTemplate_flash_success_title' => 'Success',
'emailTemplate_flash_error_title' => 'Error',
'emailTemplate_error_template_not_found' => 'Email template was not found.',
'emailTemplate_delete_success' => 'Email template was deleted successfully.',
'emailTemplate_error_delete_default_blocked' => 'The default template cannot be deleted until another template is set as default for the same role and category.',
'emailTemplate_error_delete_used_blocked' => 'Email templates that have been used cannot be deleted.',
'emailTemplate_error_rate_limited' => 'Too many requests. Please wait a moment and try again.',
'emailTemplate_save_fail' => 'Email template could not be saved.',
'emailTemplate_empty_title' => 'No email templates yet',
'emailTemplate_empty_subtitle' => 'Start by importing seed templates or create a new template manually.',
'config_theme_success_text_summary'      => 'Theme settings updated successfully. Changes: %s.',
'config_theme_save_error_title'          => 'Save Error',
'config_theme_save_error_text'           => 'Failed to save theme settings. Please try again or contact the system administrator.',
'config_theme_system_error_title'        => 'System Error',
'config_theme_system_error_text'         => 'An error occurred while saving theme settings. Please check the system log for more details.',
'config_theme_audit_message'             => 'Theme settings updated (%d fields): %s',
'config_theme_audit_no_changes'          => 'no field changes',

/* =========================
 * TAB BAHASA
 * ========================= */
'config_tab_bahasa_header'               => 'Available Languages',
'config_tab_bahasa_header_sub'           => 'Available languages',
'config_tab_bahasa_header_details'       => 'Select the languages to be enabled in the system.',
'config_tab_bahasa_default'              => 'Default Language',
'config_tab_bahasa_kodBahasa'            => 'Language Code',
'config_tab_bahasa_peneranganBahasa'     => 'Language Description',
'config_tab_bahasa_status_aktif'         => 'Active',
'config_tab_bahasa_simpan_tetapan_bahasa'=> 'Save Language Settings',
'config_tab_bahasa_actions_note'         => 'Ensure at least one language remains active and one default language is selected.',
'config_language_validation_title'       => 'Validation Error',
'config_language_validation_required'    => 'Please select at least one language to enable.',
'config_language_validation_invalid'     => 'Language "%s" is invalid. Only %s are allowed.',
'config_language_validation_default_required' => 'Please select one default language for the system.',
'config_language_validation_default_invalid' => 'Default language "%s" is invalid.',
'config_language_validation_default_not_active' => 'The default language must be in the active language list.',
'config_language_success_text_summary'   => 'Language settings saved successfully. Active: %s. Default: %s.',
'config_language_save_error_title'       => 'Save Error',
'config_language_save_error_text'        => 'Failed to save language settings. Please try again or contact the system administrator.',
'config_language_system_error_title'     => 'System Error',
'config_language_system_error_text'      => 'An error occurred while saving language settings. Please check the system log for more details.',
'config_language_audit_message'          => 'Language settings updated: %s',
'config_language_audit_message_summary'  => 'Active: %s | Default: %s',

/* =========================
 * JS / SWEETALERT
 * ========================= */
'config_js_loading'              => 'Loading…',
'config_js_memproses'            => 'Processing…',

'config_js_confirm_emel'         => 'Are you sure you want to save email settings?',
'config_js_confirm_general'      => 'Are you sure you want to save general settings?',
'config_js_confirm_auth'         => 'Are you sure you want to save this login policy?',
'config_js_confirm_db'           => 'Are you sure you want to save database settings?',
'config_js_confirm_tema'         => 'Are you sure you want to save default theme settings?',
'config_js_confirm_bahasa'       => 'Are you sure you want to save the active language list?',

'config_js_btn_ya_simpan'        => 'Yes, save',
'config_js_btn_ya_teruskan'      => 'Yes, continue',
'config_js_btn_ok'               => 'OK',
'config_js_btn_cancel'           => 'Cancel',
'config_js_btn_loading_save'     => 'Saving...',

// Uji Emel
'config_js_confirm_uji_emel'     => 'Are you sure you want to test this email connection?',
'config_js_input_uji_emel'       => 'Enter Test Email',
'config_js_label_uji_emel'       => 'Email address for test delivery',
'config_js_placeholder_uji_emel' => 'e.g.: apps_email@upnm.edu.my',
'config_js_valid_emel_kosong'    => 'Email address cannot be empty',
'config_js_valid_email_format'   => 'Invalid email format',
'config_js_valid_email_full'     => 'Invalid email format. Please enter a valid email address.',
'config_js_valid_host_format'    => 'Invalid host format (domain or IP)',
'config_js_valid_port_range'     => 'Port must be between 1 and 65535',
'config_js_system_error_title'   => 'System Error',
'config_js_module_not_ready'     => 'The system settings module has not finished loading. Please try again.',
'config_js_invalid_server_response' => 'Invalid server response.',
'config_js_save_failed'          => 'Failed to save settings.',
'config_js_save_success_default' => 'Settings saved successfully.',
'config_js_save_system_error'    => 'System error while saving settings.',
'config_js_validation_review_marked' => 'Review the marked inputs before saving.',
'config_js_saving_changes'       => 'The system is saving your changes...',
'config_js_invalid_input'        => 'Invalid input.',
'config_js_field_fallback_label' => 'Field',
'config_js_uji_emel_btn'         => 'Test Now',
'config_js_uji_emel_btn_loading' => 'Testing…',
'config_js_uji_emel_btn_default' => 'Test Email Connection',

// Status JS
'config_js_berjaya'              => 'Success',
'config_js_ralat'                => 'Error',
'config_js_emel_berjaya'         => '✅ Email sent successfully.',
'config_js_emel_uji_berjaya'     => 'Test email successfully sent to :email.',
'config_js_emel_gagal'           => '❌ Failed to send email.',
'config_js_emel_uji_gagal'       => '❌ Failed to send email: :error',
'config_js_ralat_sistem'         => '❌ System error while testing connection.',
'config_js_tiada_bahasa'         => 'No Language Selected',
'config_js_pilih_bahasa'         => 'Please select at least one language.',
'config_js_tiada_bahasa_default' => 'No Default Language Selected',
'config_js_pilih_bahasa_default' => 'Please select one default language from the active languages list.',

/* =========================
 * ALERT DB (Controller)
 * ========================= */
'config_db_sambungan_tidak_sah'   => 'Invalid Connection',
'config_db_pilihan_tidak_wujud'   => 'Selected connection does not exist.',
'config_db_sambungan_gagal'       => 'Connection Failed',
'config_db_sambungan_gagal_msg'   => 'Unable to connect to database ":db".',
'config_db_sambungan_ok'          => 'Connection Successful',
'config_db_sambungan_ok_msg'      => 'Connection ":db" updated successfully.',
'config_db_ralat_simpan'          => 'Save Error',
'config_db_ralat_simpan_msg'      => 'Failed to save settings to file.',

'config_alert_title'              => 'Are you sure?',
'config_alert_no'                 => 'Cancel',

/* =====================================================
 * FORM LIST & EMAIL APPLICATION (formList_, email_)
 * ===================================================== */
'formList_error_no_permission'    => 'You do not have permission to perform this action.',
'formList_page_title'             => 'Form List',
'formList_breadcrumb_home'        => 'Dashboard',
'formList_col_name'               => 'Form Name',
'formList_col_category'           => 'Category',
'formList_col_path'               => 'Path',
'formList_col_status'             => 'Status',
'formList_col_action'             => 'Action',
'formList_status_active'          => 'Active',
'formList_status_inactive'        => 'Inactive',
'formList_no_records'             => 'No records',
'formList_modal_add_title'        => 'Add Form',
'formList_modal_edit_title'       => 'Update Form',
'formList_modal_label_section'    => 'Section PIC',
'formList_select_option'          => '-- Select --',
'formList_modal_label_path'       => 'Path',
'formList_placeholder_path'       => 'permohonan-emel.php',
'formList_modal_label_name_ms'    => 'Malay Name',
'formList_modal_label_name_en'    => 'English Name',
'formList_modal_label_icon'       => 'Icon',
'formList_placeholder_icon'       => 'ri-file-line',
'formList_preview'                => 'Preview',
'formList_modal_label_status'     => 'Status',
'formList_btn_close'              => 'Close',
'formList_btn_save'               => 'Save',
'formList_btn_update'             => 'Update',
'formList_btn_add'                => 'Add Form',
'formList_loading'                => 'Loading...',
'formList_dt_search_placeholder'  => 'Search',
'formList_dt_length_menu'         => 'Show _MENU_ records',
'formList_dt_info'                => 'Showing _START_ to _END_ of _TOTAL_ entries',
'formList_dt_info_empty'          => 'No records',
'formList_dt_paginate_prev'       => 'Previous',
'formList_dt_paginate_next'       => 'Next',
'formList_success_title'          => 'Success',
'formList_error_title'            => 'Error',
'formList_error_fetch_data'       => 'Failed to fetch data.',
'formList_error_invalid_response' => 'Server returned an invalid response.',
'formList_error_generic'          => 'An error occurred.',
'formList_draft_title'            => 'Draft Found',
'formList_draft_text'             => 'You have an unsent email application draft. Do you want to continue that draft?',
'formList_draft_continue'         => 'Continue Draft',
'formList_draft_new'              => 'New Application',
'formList_processing_title'       => 'Processing...',
'formList_processing_text'        => 'Please wait a moment',
'formList_submit_success_text'    => 'Application submitted successfully',
'formList_system_error_title'     => 'System Error',
'formList_action_pdf'             => 'PDF',
'formList_error_invalid_method'   => 'Invalid request method.',
'formList_error_invalid_id'       => 'Invalid ID.',
'formList_error_not_found'        => 'Data not found.',
'formList_error_invalid_csrf'     => 'Invalid security token.',
'formList_error_required_fields'  => 'Please complete the required information.',
'formList_error_duplicate_name'   => 'The form name already exists.',
'formList_success_created'        => 'Form added successfully.',
'formList_success_updated'        => 'Form updated successfully.',

'email_tab_pemohon'               => 'Applicant',
'email_tab_email'                 => 'Email Information',
'email_tab_confirm'               => 'Confirmation',
'email_field_full_name'           => 'Full Name',
'email_field_position'            => 'Position',
'email_field_taraf_jawatan'       => 'Employment Status',
'email_taraf_tetap'               => 'Permanent',
'email_taraf_pinjaman'            => 'Secondment',
'email_taraf_sambilan'            => 'Part-time',
'email_taraf_kontrak'             => 'Contract',
'email_taraf_sementara'           => 'Temporary',
'email_field_department'          => 'Department',
'email_field_phone_office'        => 'Office Phone No.',
'email_phone_office_placeholder'  => 'Example: 03-12345678',
'email_field_phone_mobile'        => 'Mobile Phone No.',
'email_phone_mobile_placeholder'  => 'Example: 012-3456789',
'email_field_alternative_email'   => 'Alternative Email',
'email_placeholder_alternative_email' => 'email@gmail.com',
'email_field_staff_id'            => 'Staff No.',
'email_btn_next'                  => 'Next',
'email_field_requested_email'     => 'Requested Email',
'email_requested_email_placeholder' => 'name@upnm.edu.my',
'email_format_note'               => 'Use the official UPNM email format.',
'email_field_purpose'             => 'Application Purpose',
'email_purpose_placeholder'       => 'State the purpose of this official email application.',
'email_btn_back'                  => 'Back',
'email_declaration_title'         => 'Applicant Declaration',
'email_declaration_text'          => 'I confirm that all information provided is true and I am responsible for the use of the requested official email.',
'email_field_applicant_name'      => 'Applicant Name',
'email_field_application_date'    => 'Application Date',
'email_btn_confirm_submit'        => 'Confirm and Submit',
'email_error_invalid_method'      => 'Invalid request method.',
'email_error_invalid_staff'       => 'Invalid staff information.',
'email_error_invalid_draft'       => 'Invalid draft.',
'email_error_draft_not_found'     => 'Draft not found.',
'email_error_invalid_csrf'        => 'Invalid security token.',
'email_error_incomplete_applicant' => 'Please complete the applicant information.',
'email_error_incomplete_application' => 'The application information is incomplete.',
'email_error_application_not_found' => 'Application data not found.',
'email_error_invalid_id'          => 'Invalid ID.',
'email_error_generic'             => 'An error occurred while processing the email application.',
'email_mail_admin_intro'          => 'A new email application has been received.',
'email_mail_label_application_no' => 'Application No.',
'email_mail_label_name'           => 'Name',
'email_mail_label_requested_email' => 'Requested Email',
'email_mail_label_purpose'        => 'Purpose',
'email_mail_admin_subject'        => 'ACTION REQUIRED: New Email Application [%s]',
'email_submit_admin_mail_failed'  => 'Failed to send email to the ICT Section: %s',
'email_mail_user_intro'           => 'Your email application has been received.',
'email_mail_user_subject'         => 'Email Application Confirmation [%s]',
'email_pdf_library_missing'       => 'TCPDF library not found.',
'email_pdf_not_found'             => 'Application data not found.',
'email_pdf_forbidden'             => 'You do not have permission to view this application.',
'email_pdf_title'                 => 'Email Application',
'email_pdf_header_official'       => 'OFFICIAL EMAIL APPLICATION',
'email_pdf_field_application_no'  => 'Application No.',
'email_pdf_field_applicant_name'  => 'Applicant Name',
'email_pdf_field_staff_id'        => 'Staff No.',
'email_pdf_field_requested_email' => 'Requested Email',
'email_pdf_field_purpose'         => 'Application Purpose',
'email_pdf_field_application_date' => 'Application Date',
'email_pdf_prepared_by'           => 'Prepared By',
'email_pdf_applicant'             => 'Applicant',
'email_pdf_reviewed_by'           => 'Reviewed By',
'email_pdf_ict_section'           => 'ICT Email Section',


/* =====================================================
 * UI GLOBAL (theme_, topbar_, sidebar_, footer_, logout_)
 * ===================================================== */

/* =========================
 * TEMA (Offcanvas / Global)
 * ========================= */
'theme_title'                 => 'Theme Settings',
'theme_close'                 => 'Close',
'theme_customize'             => 'Customize',
'theme_customize_sub'         => 'Color, menu, and other settings',

'theme_color_scheme'          => 'Color Scheme',
'theme_topbar_color'          => 'Topbar Color',
'theme_menu_color'            => 'Sidebar/Menu Color',
'theme_light'                 => 'Light',
'theme_dark'                  => 'Dark',
'theme_brand'                 => 'Brand',

'theme_note_preview'          => 'Changes here are preview only. To save permanently, use the System Settings page.',
'theme_note_preview_fallback' => 'Changes here are preview only. To save permanently, use the System Settings page.',
'theme_applied'               => 'Theme Applied',
'theme_'                      => 'Theme',

/* =========================
 * TOPBAR
 * ========================= */
'topbar_welcome'              => 'Welcome!',
'topbar_keluar'               => 'Logout',

// Profil & menu
'topbar_switch_role'          => 'Switch Role',
'topbar_switch_role_title'    => 'Switch Role',
'topbar_switch_role_select'   => 'Select Role',
'topbar_switch_role_primary_label' => 'Primary role',
'topbar_switch_role_primary_tag'   => 'Primary Role',
'topbar_switch_role_none'     => 'No other roles are allowed.',
'topbar_switch_role_err_select' => 'Please select a role.',
'topbar_switch_role_err_invalid' => 'Please select a valid role.',
'topbar_switch_role_saving'   => 'Saving...',
'topbar_switch_role_success_title' => 'Role {role}',
'topbar_switch_role_success_text'  => 'Display and system access have been updated according to the newly selected role, <strong>{role}</strong>.',

/* =========================
 * SIDEBAR
 * ========================= */
'sidebar_main'                => 'Main',
'sidebar_dashboard'           => 'Dashboard',
'sidebar_dashboard_stats'     => 'Statistics',
'sidebar_user_manual'         => 'User Manual',
'sidebar_modul'               => 'System Modules',
'sidebar_kawalan'             => 'System Control',
'sidebar_keluar'              => 'Logout',

'sidebar_profile_empty'       => 'Profile not found',
'sidebar_loading'             => 'Loading...',

/* =========================
 * FOOTER
 * ========================= */
'footer_it'                   => 'BTMK | Digital Application Section',
'footer_about'                => 'About Us',
'footer_help'                 => 'Help',
'footer_contact'              => 'Contact Us',

'footer_content_updating_title'
                              => 'Information',
'footer_content_updating'     => 'Content is being updated.',
'footer_content_updating_ok'  => 'OK',

/* =========================
 * LOGOUT (SweetAlert)
 * ========================= */
'logout_alert_title'          => 'Confirmation',
'logout_alert_text'           => 'Are you sure you want to log out?',
'logout_alert_yes'            => 'Yes, log out',
'logout_alert_no'             => 'Cancel',

'logout_title'                => 'Logged Out Successfully',
'logout_msg'                  => 'You have logged out of the system.',


/* =====================================================
 * KUMPULAN PENGGUNA (userGroup_)
 * ===================================================== */

/* =========================
 * Butang & Aksi
 * ========================= */
'userGroup_edit' => 'Edit',
'userGroup_delete'                  => 'Delete',


/* =========================
 * Label Kecil
 * ========================= */

/* =========================
 * Status
 * ========================= */

/* =========================
 * Modal — Menu
 * ========================= */





/* =========================
 * Modal — Akses Kumpulan
 * ========================= */

/* =========================
 * SweetAlert — Padam
 * ========================= */


/* =========================
 * Ralat
 * ========================= */


'userGroup_bootstrap_missing'
                                    => 'Bootstrap JS not loaded. Ensure bootstrap.bundle.min.js is included.',





/* =====================================================
 * KUNCI PEMANTAUAN & SISTEM
 * ===================================================== */

/* =====================================================
 * KUNCI UMUM / PELBAGAI
 * ===================================================== */
'actions' => 'Actions',
'btn_save' => 'Save',
'type' => 'Type',
'ujian_db' => 'Database Test',

/* =====================================================
 * KUNCI PENGURUSAN PROJEK
 * ===================================================== */

/* =====================================================
 * KUNCI BUTANG/TINDAKAN UMUM
 * ===================================================== */
'btn_update' => 'Update',
'btn_close' => 'Close',
'updating' => 'Updating',

/* =====================================================
 * DASHBOARD (BASE)
 * ===================================================== */
'dashboard_title' => 'Dashboard',
'dashboard_breadcrumb' => 'Dashboard',
'dashboard_welcome' => 'Welcome',
'dashboard_last_login' => 'Last login',
'dashboard_resources_title' => 'System Resources',
'dashboard_refresh' => 'Refresh',
'dashboard_resources_col_resource' => 'Resource',
'dashboard_resources_col_usage' => 'Usage',
'dashboard_resources_col_status' => 'Status',
'dashboard_status_ok' => 'OK',
'dashboard_status_warning' => 'Warning',
'dashboard_status_critical' => 'Critical',
'dashboard_status_unknown' => 'Unknown',
'dashboard_status_degraded' => 'Degraded',
'dashboard_resource_cpu' => 'CPU',
'dashboard_resource_memory' => 'Memory',
'dashboard_resource_disk' => 'Disk',
'dashboard_health_db' => 'Database',
'dashboard_health_connected' => 'Connected',
'dashboard_health_conn_failed' => 'Connection failed',
'dashboard_health_app' => 'Application',
'dashboard_health_bootstrap_ok' => 'Bootstrap loaded',
'dashboard_health_config_incomplete' => 'Configuration incomplete',
'dashboard_health_storage' => 'Storage',
'dashboard_health_storage_free' => '%s%% free',
'dashboard_health_unavailable' => 'Unavailable',
'dashboard_health_cache' => 'Cache',
'dashboard_health_enabled' => 'Enabled',
'dashboard_health_readonly' => 'Read-only',
'dashboard_health_disabled' => 'Disabled',
'dashboard_env_production' => 'production',
'dashboard_env_development' => 'development',
'dashboard_env_debug_on' => 'debug ON',
'dashboard_env_debug_off' => 'debug OFF',
'dashboard_health_audit' => 'Audit/Log',
'dashboard_health_writable' => 'Writable',
'dashboard_health_not_writable' => 'Not writable',
'dashboard_health_cron' => 'Scheduled Jobs',
'dashboard_health_unknown' => 'Unknown',
'dashboard_health_tz' => 'Time & Timezone',

/* =====================================================
 * FAQ
 * ===================================================== */
'faq_title' => 'Frequently Asked Questions (FAQ)',
'faq_heading' => 'System FAQ',
'faq_intro' => 'Refer to general system guidance intended for all users. Choose a category or use search to find the answer that best matches what you need to know.',
'faq_label_category' => 'Category',
'faq_placeholder_cari' => 'Search within selected category…',
'faq_tiada_padamu' => 'No matching result found. Try another keyword.',
'faq_count_display' => 'of',
'faq_count_soalan' => 'questions shown',
'faq_cat_semua' => 'All',
'faq_cat_account_access' => 'Account & Access',
'faq_cat_navigation' => 'Navigation & Usage',
'faq_cat_profile_settings' => 'Profile & Settings',
'faq_cat_user_management' => 'Data & Records',
'faq_cat_group_management' => 'Security & Privacy',
'faq_cat_support' => 'Support & Help',

'faq_item_01_q' => 'How do I log in to the system properly?',
'faq_item_01_a' => '<p>Use the user ID assigned to you together with a valid password on the login page. Make sure the information is entered carefully, including upper- and lower-case characters if the system distinguishes them.</p><p>After a successful login, you will be taken to the main page of the system. If you are using a shared or public computer, always remember to log out when you are done to keep your account secure.</p>',
'faq_item_02_q' => 'Why am I unable to log in even though my information seems correct?',
'faq_item_02_a' => '<p>Login problems can happen for several reasons, such as a recently changed password, an expired session, unstable network access, or a temporary account lock after repeated failed attempts.</p><p>The first step is to check your user ID and password again, then try once more after a short pause. If the issue continues, capture the error message if one appears and contact the responsible support person or system administrator so the issue can be reviewed more quickly.</p>',
'faq_item_03_q' => 'Why might the menu I see be different from another user’s menu?',
'faq_item_03_a' => '<p>The system usually displays menus based on the role, task scope, or access assigned to each user account. Because of this, not every user will see the same modules or functions.</p><p>This is normal and is intended to keep the system focused, organized, and secure. If you believe you need access to a particular function in order to perform your work, refer the matter to the person responsible for managing system access.</p>',
'faq_item_04_q' => 'What is the purpose of the dashboard or main page?',
'faq_item_04_a' => '<p>The dashboard or main page usually serves as the first overview after login. It may show important information, shortcuts to commonly used modules, and a general snapshot of the current system state.</p><p>The dashboard helps you start your work more efficiently without having to search manually for every feature. If it contains widgets, summary cards, or quick links, treat them as a starting point before moving into the detailed modules you need.</p>',
'faq_item_05_q' => 'What is the best way to use the sidebar menu?',
'faq_item_05_a' => '<p>The sidebar is the main navigation area used to move between modules and pages. Use it to identify the section that matches your task, then open the page most closely related to the work you want to do.</p><p>If a menu contains submenus, expand the category first and review the available options. The easiest way to work smoothly is to become familiar with the overall menu structure so you can navigate the system more confidently and consistently.</p>',
'faq_item_06_q' => 'How can I find information more quickly in the system?',
'faq_item_06_a' => '<p>Many pages that display records provide search, filtering, or sorting tools. Use the search field to narrow the list and use filters when you want to focus on a category, date, or status.</p><p>It is also helpful to pay attention to the module name and the page title so you understand the context of the data being shown. This reduces confusion and makes it easier to search in the correct place the first time.</p>',
'faq_item_07_q' => 'How do I change the display language of the system?',
'faq_item_07_a' => '<p>The display language can usually be changed from your profile area or from the language control provided in the interface. Once selected, the system will use that language on pages and modules that support multilingual display.</p><p>If the change does not appear immediately, try refreshing the page or signing in again. This depends on how each part of the system loads its content and whether the new language is applied instantly within the current session.</p>',
'faq_item_08_q' => 'How do I change the theme or visual appearance of the system?',
'faq_item_08_a' => '<p>Theme settings allow you to adjust the look and feel of the interface, such as light mode, dark mode, or certain color styles used in the application. These options are normally available through the profile page or settings page that is available to you.</p><p>Changing the theme does not alter any data or system function. It only changes the visual presentation. If you spend long periods in the system, choose the theme that is easiest for you to read and most comfortable for daily use.</p>',
'faq_item_09_q' => 'What kind of information is usually shown on the user profile page?',
'faq_item_09_a' => '<p>The profile page typically displays your basic account details such as name, account identity, email, department, role, and personal preferences like language or theme. Its purpose is to help you confirm that your user information is correct and up to date.</p><p>In some systems, the profile page may also display login history, active session details, or selected activity records. Use this page as the main place to review the current state of your own account in the system.</p>',
'faq_item_10_q' => 'How should I review or manage information shown in data tables?',
'faq_item_10_a' => '<p>When you are on a page that shows a table, begin by reading the column headers so you understand what kind of information is being displayed. After that, use search, filters, and pagination to review the records in a more organized way.</p><p>If the system provides action buttons such as view, update, or download, always confirm that you are working on the correct record before proceeding. This habit reduces mistakes and makes your data review process more systematic.</p>',
'faq_item_11_q' => 'What do statuses, labels, or badges usually mean on a record?',
'faq_item_11_a' => '<p>Status labels or badges generally indicate the current condition of a record, such as active, incomplete, in progress, successful, or requiring further action. Different modules may use slightly different terms, but the purpose is the same: to help you understand the record quickly.</p><p>When you see a status, it is best to read it together with the rest of the row, including date, owner, or available actions. Doing so gives you a more accurate understanding before you decide what to do next.</p>',
'faq_item_12_q' => 'What should I do before making changes to data?',
'faq_item_12_a' => '<p>Before making any change, review the record details carefully and make sure you are on the correct item. Read the field labels, the current values, and any guidance shown on the form or page.</p><p>If the change is important, it is also helpful to prepare supporting information such as reference documents, record numbers, or related dates in advance. This reduces mistakes and makes the update process smoother and more reliable.</p>',
'faq_item_13_q' => 'How can I protect security and privacy while using the system?',
'faq_item_13_a' => '<p>Do not share your password, do not leave your session open without supervision, and avoid storing sensitive information in unsafe places. If you use a shared computer, always log out once your work is complete.</p><p>You should also be careful when downloading, uploading, or sharing information from the system. Make sure your actions follow your organization’s internal rules, especially when the information involved is sensitive or intended only for internal use.</p>',
'faq_item_14_q' => 'What should I do if the system shows an error or behaves unexpectedly?',
'faq_item_14_a' => '<p>If an error occurs, do not immediately repeat the same action many times. Instead, note the error message, the time it happened, the module you were using, and what you were doing just before the issue appeared.</p><p>This information is very useful during troubleshooting. If possible, take a screenshot and send it to the support team or system administrator. The clearer your description is, the easier it will be to identify and resolve the issue.</p>',
'faq_item_15_q' => 'Where can I get help if I am still unsure how to use the system?',
'faq_item_15_a' => '<p>If you are still unsure about a feature, first refer to the guidance already provided in the system, such as the user manual, help notes, or this FAQ page. Many common questions can be resolved through these references.</p><p>If you still need assistance, contact the helpdesk, support officer, or system administrator assigned by your organization. Explain the issue clearly, include screenshots if necessary, and mention what steps you have already tried so the support process can be more accurate and efficient.</p>',

'session_idle_title' => 'Still there?',
    'session_idle_text' => 'No activity for %d minutes. Stay signed in?',
'session_idle_stay_connected' => 'Stay Connected',
'session_idle_logout_now' => 'Log Out',
'session_idle_timeout_text' => 'Auto log out in 1 minute.',
'session_idle_timeout_title' => 'Session Ended',
'session_idle_timeout_logout_now' => 'No response. The system will log you out now.',
'session_idle_keepalive_failed' => 'Session refresh failed. You will be logged out.',
'manual_unauthorized_access' => 'You are not allowed to access this page.',
'access_notice_title' => 'System Notice',
'access_notice_text' => 'The requested destination is unavailable. Please continue using the navigation provided in the system.',
'access_missing_page_text' => 'The requested page does not exist or is no longer available. Please use the navigation provided in the system.',
'manual_csrf_reload' => 'Invalid CSRF token. Please reload the page and try again.',
'manual_page_title' => 'Manage User Manuals',
'manual_breadcrumb_home' => 'Home',
'manual_col_no' => '#',
'manual_col_group' => 'Role (Group)',
'manual_col_status' => 'Manual Status',
'manual_col_updated_at' => 'Last Updated',
'manual_col_actions' => 'Actions',
'manual_none' => 'None',
'manual_no_groups_found' => 'No user groups found.',
'manual_status_saved' => 'Saved',
'manual_status_not_uploaded' => 'Not uploaded',
'manual_action_upload' => 'Upload manual',
'manual_action_view' => 'View manual',
'manual_action_delete' => 'Delete manual',
'manual_upload_modal_title' => 'Upload User Manual',
'manual_upload_modal_intro' => 'Please upload the user guide for role:',
'manual_upload_modal_subtext' => 'The manual for this group will be updated immediately after a successful upload.',
'manual_upload_field_label' => 'PDF File (Maximum %dMB)',
'manual_upload_help_text' => 'Only PDF files are allowed. The system will validate the file before saving.',
'manual_upload_replace_notice' => 'The existing manual will be replaced with this new file.',
'manual_btn_cancel' => 'Cancel',
'manual_btn_upload_save' => 'Upload & Save',
'manual_upload_processing_btn' => 'Saving...',
'manual_upload_loading_title' => 'Upload Manual',
'manual_upload_loading_text' => 'Uploading file...',
'manual_upload_success_title' => 'Manual Updated',
'manual_upload_error_title' => 'Upload Failed',
'manual_upload_select_file' => 'Please select a PDF file first.',
'manual_btn_sync_groups' => 'Check Groups',
'manual_btn_close' => 'Close',
'manual_btn_delete' => 'Delete',
'manual_dt_length_menu' => 'Show _MENU_ records',
'manual_dt_info' => 'Showing _START_ to _END_ of _TOTAL_ records',
'manual_dt_info_empty' => 'Showing 0 to 0 of 0 records',
'manual_dt_paginate_prev' => 'Previous',
'manual_dt_paginate_next' => 'Next',
'manual_dt_zero_records' => 'No matching records found',
'manual_dt_search_label' => 'Search',
'manual_sync_loading_title' => 'Check Groups',
'manual_sync_loading_text' => 'Checking groups...',
'manual_sync_success_title' => 'Group Check Complete',
'manual_sync_success_fallback' => 'Group check completed.',
'manual_sync_error_title' => 'Group Check Failed',
'manual_unknown_error' => 'Unknown error.',
'manual_group_fallback' => 'this group',
'manual_delete_confirm_title' => 'Delete Manual?',
'manual_delete_confirm_text' => 'Are you sure you want to delete the manual for {group}?',
'manual_alert_success_title' => 'Success',
'manual_alert_error_title' => 'Error',
'manual_sync_no_groups' => 'No groups to check.',
'manual_sync_result' => 'Group check completed. New: %d, Updated: %d.',
'manual_sync_failed' => 'Failed to check and sync manual groups.',
'manual_group_invalid' => 'Invalid user group.',
'manual_file_incomplete' => 'Incomplete file information.',
'manual_upload_error' => 'Error while uploading file.',
'manual_upload_invalid' => 'Invalid uploaded file.',
'manual_upload_pdf_only' => 'Please upload PDF files only.',
'manual_upload_invalid_pdf' => 'The uploaded file is not a valid PDF.',
'manual_upload_max_size' => 'File size exceeds the %dMB limit.',
'manual_record_update_failed' => 'Failed to update manual record.',
'manual_upload_success' => 'Manual uploaded and updated successfully.',
'manual_upload_store_failed' => 'Failed to store uploaded file.',
'manual_delete_record_failed' => 'Failed to delete manual record.',
'manual_delete_success' => 'Manual deleted successfully.',
'manual_not_found' => 'Manual not found.',
'manual_method_not_allowed' => 'Request method is not allowed.',
'manual_csrf_invalid' => 'Invalid CSRF token.',
'manual_action_forbidden' => 'You are not allowed to perform this action.',
'manual_server_sync_error' => 'Server error while syncing manual groups.',
'manual_upload_failed_generic' => 'Manual upload failed.',
'manual_server_upload_error' => 'Server error while uploading manual.',
'studentSearch_mode_disabled' => 'Student mode is not enabled. Switch Operational Mode to Staff + Student first.',
'studentSearch_system_error' => 'System error while searching students.',
'studentLookup_page_title' => 'Student Search',
'studentLookup_header_title' => 'Student Data Search',
'studentLookup_header_subtitle' => 'Review active student data from view v210 through the Student Sybase domain.',
'studentLookup_environment' => 'Environment',
'studentLookup_mode' => 'Operational Mode',
'studentLookup_runtime_key' => 'Student Runtime Key',
'studentLookup_query_info_default' => 'This page is used to review active student data through the Student Sybase domain when Staff + Student mode is enabled.',
'studentLookup_query_info_search' => 'Use this page to search active student data by matric number, name, or faculty through the Student Sybase domain.',
'studentLookup_mode_disabled' => 'Student search is only available when Staff + Student mode is enabled.',
'studentLookup_error_prefix' => 'Student search error:',
'studentLookup_success_search' => 'Search completed. %1$d records found for keyword "%2$s".',
'studentLookup_col_matrik' => 'Matric No.',
'studentLookup_col_nama' => 'Name',
'studentLookup_col_fakulti' => 'Faculty',
'studentLookup_search_label' => 'Student Search',
'studentLookup_search_placeholder' => 'Search by matric no., name, or faculty',
'studentLookup_search_button' => 'Search',
'studentLookup_no_search_results' => 'No student records were found for the current search.',
'studentLookup_empty_table' => 'No student records are available to display.',
'studentLookup_loading' => 'Loading student data...',
'config_general_branding_sidebar_user_image' => 'Sidebar User Image',
'config_general_branding_sidebar_user_image_help' => 'Choose the small background image displayed below the logo in the sidebar.',
'config_general_branding_sidebar_user_image_preview' => 'Preview',
'config_general_validation_sidebar_user_image' => '%s must be selected from the allowed image list.',
'pageTemplateGenerator_page_title' => 'System Template Generator',
'pageTemplateGenerator_header_title' => 'System Template Generator',
'pageTemplateGenerator_breadcrumb_active' => 'System Template Generator',
'pageTemplateGenerator_form_title' => 'Generator Setup',
'pageTemplateGenerator_form_subtitle' => 'Choose a template, define the page identity, and review the generated files before creating them.',
'pageTemplateGenerator_field_page_name' => 'Page Name',
'pageTemplateGenerator_field_page_name_placeholder' => 'Example: senarai pelajar',
'pageTemplateGenerator_field_page_name_help' => 'Enter the page name only, without .php. Example: senarai-pelajar',
'pageTemplateGenerator_field_template' => 'Template Type',
'pageTemplateGenerator_field_template_placeholder' => 'Please select a template type',
'pageTemplateGenerator_field_title_ms' => 'Page Title (MS)',
'pageTemplateGenerator_field_title_ms_placeholder' => 'Example: Senarai Pelajar',
'pageTemplateGenerator_field_title_en' => 'Page Title (EN)',
'pageTemplateGenerator_field_title_en_placeholder' => 'Example: Student List',
'pageTemplateGenerator_field_icon' => 'Page Icon',
'pageTemplateGenerator_field_access_mode' => 'Access Mode',
'pageTemplateGenerator_field_access_mode_help' => 'Choose Super Admin Only for highly sensitive pages. Choose Group Menu Based for pages that will be granted through menu access and group assignment.',
'pageTemplateGenerator_tab_form' => 'Template Form',
'pageTemplateGenerator_tab_page_icon' => 'Page Icon',
'pageTemplateGenerator_tab_page_icon_help' => 'Choose an icon that best represents the generated page in the sidebar and module listing.',
'pageTemplateGenerator_tab_access_mode' => 'Access Mode',
'pageTemplateGenerator_access_group_menu_title' => 'Group Menu Based',
'pageTemplateGenerator_access_group_menu_help' => 'The page follows menu access. Only groups that are assigned to the menu path can open it.',
'pageTemplateGenerator_access_super_admin_title' => 'Super Admin Only',
'pageTemplateGenerator_access_super_admin_help' => 'The page is locked at policy level and can only be opened by Super Admin.',
'pageTemplateGenerator_access_mode_group_menu_based' => 'Group Menu Based',
'pageTemplateGenerator_access_mode_super_admin_only' => 'Super Admin Only',
'pageTemplateGenerator_btn_preview' => 'Preview Output',
'pageTemplateGenerator_btn_generate' => 'Generate Files',
'pageTemplateGenerator_preview_title' => 'Preview Summary',
'pageTemplateGenerator_preview_subtitle' => 'Review file names and collision status before generation.',
'pageTemplateGenerator_preview_empty' => 'No preview yet. Fill in the form and click Preview Output.',
'pageTemplateGenerator_preview_template' => 'Template',
'pageTemplateGenerator_preview_slug' => 'Page Slug',
'pageTemplateGenerator_preview_controller' => 'Controller Class',
'pageTemplateGenerator_preview_icon' => 'Page Icon',
'pageTemplateGenerator_preview_files' => 'Output Files',
'pageTemplateGenerator_preview_page_file' => 'Page File',
'pageTemplateGenerator_preview_controller_file' => 'Controller File',
'pageTemplateGenerator_preview_css_file' => 'CSS File',
'pageTemplateGenerator_exists_yes' => 'Already exists',
'pageTemplateGenerator_exists_no' => 'Available',
'pageTemplateGenerator_generated_title' => 'Generated Files',
'pageTemplateGenerator_generation_blocked' => 'Generation disabled because one or more target files already exist.',
'pageTemplateGenerator_generation_status' => 'Generation Status',
'pageTemplateGenerator_generation_status_blocked' => 'Blocked',
'pageTemplateGenerator_generation_status_ready' => 'Ready to generate',
'pageTemplateGenerator_error_csrf' => 'Invalid CSRF token.',
'pageTemplateGenerator_success_generate' => 'Files were generated successfully.',
'pageTemplateGenerator_success_title' => 'Files Generated Successfully',
'pageTemplateGenerator_btn_ok' => 'OK',
'pageTemplateGenerator_list_title' => 'Generated Templates',
'pageTemplateGenerator_list_subtitle' => 'Manage generated page templates and review the output artifacts created by the system.',
'pageTemplateGenerator_action_create' => 'Create New Template',
'pageTemplateGenerator_col_template_name' => 'Template Name',
'pageTemplateGenerator_col_type' => 'Type',
'pageTemplateGenerator_col_page' => 'Page',
'pageTemplateGenerator_col_status' => 'Status',
'pageTemplateGenerator_col_last_updated' => 'Last Updated',
'pageTemplateGenerator_col_actions' => 'Actions',
'pageTemplateGenerator_modal_create_title' => 'Create New Template',
'pageTemplateGenerator_modal_create_subtitle' => 'Define the template identity, review the output, and create the generated files in one flow.',
'pageTemplateGenerator_field_template_name' => 'Template Name',
'pageTemplateGenerator_field_template_name_placeholder' => 'Example: Student Listing Base',
'pageTemplateGenerator_btn_close' => 'Close',
'pageTemplateGenerator_btn_view' => 'View',
'pageTemplateGenerator_btn_visit' => 'Visit Page',
'pageTemplateGenerator_detail_title' => 'Template Details',
'pageTemplateGenerator_detail_subtitle' => 'Review the generated metadata and output paths for this template record.',
'pageTemplateGenerator_preview_db_slug' => 'Database Slug',
'pageTemplateGenerator_preview_db_slug_help' => 'Checks whether the page slug already exists in template records.',
'pageTemplateGenerator_preview_db_controller' => 'Database Controller',
'pageTemplateGenerator_preview_db_controller_help' => 'Checks whether the controller class already exists in template records.',
'pageTemplateGenerator_preview_toggle_show' => 'Show Preview Meta',
'pageTemplateGenerator_preview_toggle_hide' => 'Hide Preview Meta',
'pageTemplateGenerator_status_generated' => 'Generated',
'pageTemplateGenerator_status_archived' => 'Archived',
'pageTemplateGenerator_status_failed' => 'Failed',
'pageTemplateGenerator_required_note' => 'Fields marked with * are required.',
'pageTemplateGenerator_required_field' => 'This field is required.',
'pageTemplateGenerator_validation_required' => 'Please complete all required fields and choose a page icon.',
'pageTemplateGenerator_error_create_failed' => 'Template creation failed. Please try again or contact the system administrator.',
'topbar_notification_title' => 'Notifications',
'topbar_notification_latest' => 'Latest updates',
'topbar_notification_loading' => 'Loading...',
'topbar_notification_empty' => 'No notifications.',
'topbar_notification_load_failed' => 'Unable to load notifications.',
'topbar_notification_mark_all_read' => 'Mark All Read',
'topbar_notification_view_all' => 'View All',
'topbar_notification_read_success' => 'Notification marked as read.',
'topbar_notification_read_failed' => 'Unable to mark notification as read.',
'topbar_notification_read_all_success' => 'All notifications marked as read.',
'topbar_notification_read_all_failed' => 'Unable to mark all notifications as read.',
'notification_invalid_method' => 'Invalid request method.',
'notification_page_title' => 'Notifications',
'notification_page_subtitle' => 'Review system alerts, announcements, and task notifications assigned to you.',
'notification_filter_all' => 'All',
'notification_filter_unread' => 'Unread',
'notification_filter_read' => 'Read',
'notification_filter_action_required' => 'Action Required',
'notification_filter_overdue' => 'Overdue',
'notification_action_required' => 'Action required',
'notification_action_overdue' => 'Overdue',
'notification_action_completed' => 'Completed',
'notification_action_cancelled' => 'Cancelled',
'notification_action_expired' => 'Expired',
'notification_action_invalid' => 'Invalid notification action.',
'notification_action_success' => 'Notification action status has been updated.',
'notification_action_failed' => 'Unable to update notification action status.',
'notification_admin_page_title' => 'Notification Admin',
'notification_admin_forbidden' => 'You do not have permission to manage notifications.',
'notification_admin_publish_success' => 'Notification published successfully.',
'notification_admin_publish_failed' => 'Unable to publish notification.',
'notification_admin_publishing' => 'Publishing...',
'notification_admin_stat_total' => 'Total',
'notification_admin_stat_active' => 'Active',
'notification_admin_stat_action' => 'Action Required',
'notification_admin_stat_broadcast' => 'Broadcast',
'notification_admin_composer_title' => 'Publish Notification',
'notification_admin_composer_subtitle' => 'Create system notifications, reminders, or workflow notices for selected audiences.',
'notification_admin_event_code' => 'Event Code',
'notification_admin_template' => 'Template',
'notification_admin_no_template' => 'No template',
'notification_admin_type' => 'Type',
'notification_admin_severity' => 'Severity',
'notification_admin_priority' => 'Priority',
'notification_admin_title_ms' => 'Title MS',
'notification_admin_title_en' => 'Title EN',
'notification_admin_body_ms' => 'Body MS',
'notification_admin_body_en' => 'Body EN',
'notification_admin_audience_type' => 'Audience',
'notification_admin_audience_value' => 'Audience Value',
'notification_admin_audience_help' => 'Use comma or new line for multiple values. Leave blank for ALL.',
'notification_admin_audience_all_help' => 'ALL does not require a value.',
'notification_admin_group_picker' => 'Group Quick Pick',
'notification_admin_select_group' => 'Select group',
'notification_admin_category_picker' => 'Category Quick Pick',
'notification_admin_select_category' => 'Select category',
'notification_admin_action_url' => 'Action URL',
'notification_admin_action_label_ms' => 'Action Label MS',
'notification_admin_action_label_en' => 'Action Label EN',
'notification_admin_due_at' => 'Due At',
'notification_admin_expires_at' => 'Expires At',
'notification_admin_icon' => 'Icon',
'notification_admin_dedupe_key' => 'Dedupe Key',
'notification_admin_dedupe_behavior' => 'Dedupe Behavior',
'notification_admin_requires_action' => 'Requires user action',
'notification_admin_reset' => 'Reset',
'notification_admin_publish' => 'Publish',
'notification_admin_preview_title' => 'Preview',
'notification_admin_preview_empty_title' => 'Notification title',
'notification_admin_preview_empty_body' => 'Notification body preview will appear here.',
'notification_admin_recent_title' => 'Recent Notifications',
'notification_admin_recent_subtitle' => 'Default view for published notifications and audience delivery records.',
'notification_admin_add_template' => 'Add Template',
'notification_admin_setup_button' => 'Setup Notification',
'notification_admin_col_title' => 'Title',
'notification_admin_col_type' => 'Type',
'notification_admin_col_audience' => 'Audience',
'notification_admin_col_date' => 'Date',
'notification_template_page_title' => 'Notification Templates',
'notification_template_forbidden' => 'You do not have permission to manage notification templates.',
'notification_template_save_success' => 'Notification template saved.',
'notification_template_save_failed' => 'Unable to save notification template.',
'notification_template_duplicate_success' => 'Notification template duplicated.',
'notification_template_archive_success' => 'Notification template archived.',
'notification_template_restore_success' => 'Notification template restored.',
'notification_template_delete_success' => 'Notification template deleted.',
'notification_template_invalid_action' => 'Invalid template action.',
'notification_template_stat_total' => 'Total',
'notification_template_stat_active' => 'Active',
'notification_template_stat_archived' => 'Archived',
'notification_template_stat_action' => 'Action Templates',
'notification_template_list_title' => 'Template Registry',
'notification_template_list_subtitle' => 'Maintain reusable notification wording for modules, scheduler, and escalation flows.',
'notification_template_create' => 'Create Template',
'notification_template_col_code' => 'Template Code',
'notification_template_col_event' => 'Event Code',
'notification_template_col_title' => 'Title',
'notification_template_col_meta' => 'Meta',
'notification_template_col_status' => 'Status',
'notification_template_col_actions' => 'Actions',
'notification_template_modal_title' => 'Notification Template',
'notification_template_modal_subtitle' => 'Define reusable MS/EN notification content and placeholders.',
'notification_template_field_template_code' => 'Template Code',
'notification_template_field_event_code' => 'Event Code',
'notification_template_field_module_code' => 'Module Code',
'notification_template_field_type' => 'Type',
'notification_template_field_category' => 'Category',
'notification_template_field_severity' => 'Severity',
'notification_template_field_priority' => 'Priority',
'notification_template_field_title_ms' => 'Title MS',
'notification_template_field_title_en' => 'Title EN',
'notification_template_field_body_ms' => 'Body MS',
'notification_template_field_body_en' => 'Body EN',
'notification_template_field_action_label_ms' => 'Action Label MS',
'notification_template_field_action_label_en' => 'Action Label EN',
'notification_template_field_icon' => 'Icon',
'notification_template_field_placeholders' => 'Placeholders JSON',
'notification_template_field_requires_action' => 'Requires action by default',
'notification_template_field_status' => 'Active',
'notification_template_preview_title' => 'Preview',
'notification_template_preview_empty' => 'Template title preview',
'notification_template_close' => 'Close',
'notification_template_save' => 'Save Template',
'notification_template_saving' => 'Saving...',
'notification_template_status_active' => 'Active',
'notification_template_status_archived' => 'Archived',
'notification_template_action_edit' => 'Edit',
'notification_template_action_duplicate' => 'Duplicate',
'notification_template_action_archive' => 'Archive',
'notification_template_action_restore' => 'Restore',
'notification_template_action_delete' => 'Delete',
'notification_template_delete_confirm' => 'Delete this notification template?',

];
