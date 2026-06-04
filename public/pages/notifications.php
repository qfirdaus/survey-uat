<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_login();

if (!function_exists('h')) {
    function h($value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

function nt(string $key, string $fallback): string
{
    $value = __($key);
    return ($value === $key || $value === null || $value === '') ? $fallback : (string)$value;
}

$lang = $_SESSION['lang'] ?? 'ms';
$version = (string)($_ENV['APP_ASSET_VER'] ?? date('ymdHis'));
$PAGE_TITLE = nt('notification_page_title', 'Notifications');
$defaultHome = (string)app_config('site.default_home', 'pages/dashboard.php');
?>
<!doctype html>
<html lang="<?= h($lang) ?>" data-bs-theme="<?= h($_SESSION['theme.layout'] ?? 'light') ?>">
<head>
  <?php
    $NEED_DATERANGE = false;
    $NEED_VECTORMAP = false;
    $NEED_DATATABLES = false;
    $NEED_SELECT2 = false;
    include __DIR__ . '/../includes/head.php';
  ?>
  <style>
    .notification-center {
      width: 100%;
    }
    .notification-toolbar {
      border: 1px solid rgba(15, 23, 42, .08);
      border-radius: 8px;
      background: var(--bs-body-bg);
      box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
    }
    .notification-filter {
      border-radius: 8px !important;
    }
    .notification-list-card {
      border: 1px solid rgba(15, 23, 42, .08);
      border-radius: 8px;
      box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
    }
    .notification-page-item {
      border-bottom: 1px solid rgba(15, 23, 42, .07);
      transition: background-color .18s ease;
    }
    .notification-page-item:hover {
      background: var(--bs-light);
    }
    .notification-page-item:last-child {
      border-bottom: 0;
    }
    .notification-page-item.is-unread {
      background: rgba(var(--bs-primary-rgb), .045);
    }
    .notification-icon {
      width: 42px;
      height: 42px;
      flex: 0 0 42px;
    }
    .notification-body {
      min-width: 0;
    }
  </style>
</head>
<body data-topbar-color="<?= h($_SESSION['theme.topbar'] ?? 'light') ?>"
      data-menu-color="<?= h($_SESSION['theme.menu'] ?? $_SESSION['theme.sidebar'] ?? 'dark') ?>"
      data-layout="vertical" data-sidebar-size="default" class="loading">
<div class="wrapper">
  <?php include __DIR__ . '/../includes/topbar.php'; ?>
  <?php include __DIR__ . '/../includes/sidebar.php'; ?>

  <div class="content-page">
    <div class="content">
      <div class="container-fluid">
        <div class="row mb-3">
          <div class="col-12">
            <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
              <h4 class="page-title"><i class="ri-notification-3-line me-1"></i><?= h(nt('notification_page_title', 'Notifications')) ?></h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="<?= h(base_path($defaultHome)) ?>"><?= h(nt('common_dashboard', 'Dashboard')) ?></a></li>
                  <li class="breadcrumb-item active"><?= h(nt('notification_page_title', 'Notifications')) ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="notification-center">
          <div class="notification-toolbar p-3 mb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
              <div>
                <h5 class="mb-1"><?= h(nt('notification_page_title', 'Notifications')) ?></h5>
                <p class="text-muted mb-0"><?= h(nt('notification_page_subtitle', 'Review system alerts, announcements, and task notifications assigned to you.')) ?></p>
              </div>
              <button type="button" class="btn btn-outline-primary btn-sm" id="notificationPageReadAll">
                <i class="ri-check-double-line me-1"></i><?= h(nt('topbar_notification_mark_all_read', 'Mark All Read')) ?>
              </button>
            </div>
            <div class="btn-group mt-3 flex-wrap" role="group" aria-label="Notification filters">
              <button type="button" class="btn btn-primary notification-filter" data-filter="all"><?= h(nt('notification_filter_all', 'All')) ?></button>
              <button type="button" class="btn btn-light notification-filter" data-filter="unread"><?= h(nt('notification_filter_unread', 'Unread')) ?></button>
              <button type="button" class="btn btn-light notification-filter" data-filter="read"><?= h(nt('notification_filter_read', 'Read')) ?></button>
              <button type="button" class="btn btn-light notification-filter" data-filter="action_required"><?= h(nt('notification_filter_action_required', 'Action Required')) ?></button>
              <button type="button" class="btn btn-light notification-filter" data-filter="overdue"><?= h(nt('notification_filter_overdue', 'Overdue')) ?></button>
            </div>
          </div>

          <div class="notification-list-card bg-body" id="notificationPageList">
            <div class="p-4 text-center text-muted"><?= h(nt('topbar_notification_loading', 'Loading...')) ?></div>
          </div>
        </div>
      </div>
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
  </div>
</div>

<?php include __DIR__ . '/../includes/script.php'; ?>
<script>
(function () {
  'use strict';

  const listEl = document.getElementById('notificationPageList');
  const readAllBtn = document.getElementById('notificationPageReadAll');
  const filterBtns = document.querySelectorAll('.notification-filter');
  const csrfToken = window.csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  const baseUrl = String(window.BASE_URL || '').replace(/\/+$/, '');
  const endpoints = {
    list: <?= json_encode(base_url('ajax/notification-list.php'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
    read: <?= json_encode(base_url('ajax/notification-read.php'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
    readAll: <?= json_encode(base_url('ajax/notification-read-all.php'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
  };
  const labels = {
    loading: <?= json_encode(nt('topbar_notification_loading', 'Loading...'), JSON_UNESCAPED_UNICODE) ?>,
    empty: <?= json_encode(nt('topbar_notification_empty', 'No notifications.'), JSON_UNESCAPED_UNICODE) ?>,
    failed: <?= json_encode(nt('topbar_notification_load_failed', 'Unable to load notifications.'), JSON_UNESCAPED_UNICODE) ?>,
    action: <?= json_encode(nt('notification_action_required', 'Action required'), JSON_UNESCAPED_UNICODE) ?>,
    overdue: <?= json_encode(nt('notification_action_overdue', 'Overdue'), JSON_UNESCAPED_UNICODE) ?>
  };
  let currentFilter = 'all';

  function postJson(url, payload) {
    return fetch(url, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-Token': csrfToken
      },
      credentials: 'same-origin',
      body: JSON.stringify(payload || {})
    }).then(function (response) {
      return response.text().then(function (raw) {
        let data = {};
        try { data = raw ? JSON.parse(raw) : {}; } catch (e) { data = {}; }
        if (!response.ok || data.success === false) {
          throw new Error(data.message || data.error || labels.failed);
        }
        return data.data || data;
      });
    });
  }

  function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value == null ? '' : String(value);
    return div.innerHTML;
  }

  function normalizeUrl(url) {
    const value = String(url || '').trim();
    if (!value || /^(https?:)?\/\//i.test(value) || /^javascript:/i.test(value) || /^data:/i.test(value)) return '';
    if (value.charAt(0) === '/') return value;
    return baseUrl ? baseUrl + '/' + value.replace(/^\/+/, '') : value;
  }

  function severityClass(severity) {
    switch (String(severity || '').toLowerCase()) {
      case 'success': return 'text-success bg-success-subtle';
      case 'warning': return 'text-warning bg-warning-subtle';
      case 'danger':
      case 'error': return 'text-danger bg-danger-subtle';
      default: return 'text-primary bg-primary-subtle';
    }
  }

  function render(items) {
    if (!Array.isArray(items) || items.length === 0) {
      listEl.innerHTML = '<div class="p-4 text-center text-muted">' + escapeHtml(labels.empty) + '</div>';
      return;
    }

    listEl.innerHTML = items.map(function (item) {
      const unread = item.is_read ? '' : ' is-unread';
      const actionBadge = item.requires_action && item.action_status === 'pending'
        ? '<span class="badge ' + (item.is_overdue ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning') + ' ms-2">' + escapeHtml(item.is_overdue ? labels.overdue : labels.action) + '</span>'
        : '';
      const dueLine = item.due_label
        ? '<small class="' + (item.is_overdue ? 'text-danger' : 'text-muted') + ' d-block mt-1">' + escapeHtml(item.due_label) + '</small>'
        : '';
      const actionUrl = normalizeUrl(item.action_url || '');
      const actionButton = actionUrl
        ? '<a class="btn btn-sm btn-outline-primary ms-md-3 mt-2 mt-md-0" href="' + escapeHtml(actionUrl) + '" data-notification-action="' + escapeHtml(item.id) + '">' + escapeHtml(item.action_label || 'Open') + '</a>'
        : '';

      return [
        '<div class="notification-page-item' + unread + ' p-3" data-id="' + escapeHtml(item.id) + '">',
        '  <div class="d-flex align-items-start gap-3">',
        '    <span class="notification-icon rounded-circle d-inline-flex align-items-center justify-content-center ' + severityClass(item.severity) + '"><i class="' + escapeHtml(item.icon || 'ri-notification-3-line') + ' fs-20"></i></span>',
        '    <div class="notification-body flex-grow-1">',
        '      <div class="d-flex flex-column flex-md-row justify-content-between gap-2">',
        '        <div>',
        '          <div class="fw-semibold text-body">' + escapeHtml(item.title || '-') + actionBadge + '</div>',
        '          <div class="text-muted mt-1">' + escapeHtml(item.body || '') + '</div>',
        '          <small class="text-muted d-block mt-2">' + escapeHtml(item.time_ago || '') + '</small>',
        dueLine,
        '        </div>',
        '        <div class="text-md-end">' + actionButton + '</div>',
        '      </div>',
        '    </div>',
        '  </div>',
        '</div>'
      ].join('');
    }).join('');
  }

  function load() {
    listEl.innerHTML = '<div class="p-4 text-center text-muted">' + escapeHtml(labels.loading) + '</div>';
    postJson(endpoints.list, { mode: 'page', limit: 50, filter: currentFilter })
      .then(function (data) { render(data.items || []); })
      .catch(function (error) {
        listEl.innerHTML = '<div class="p-4 text-center text-danger">' + escapeHtml(error.message || labels.failed) + '</div>';
      });
  }

  function markRead(id, clicked) {
    if (!id) return Promise.resolve();
    return postJson(endpoints.read, { notification_id: Number(id), clicked: !!clicked });
  }

  filterBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      currentFilter = btn.dataset.filter || 'all';
      filterBtns.forEach(function (b) {
        b.classList.toggle('btn-primary', b === btn);
        b.classList.toggle('btn-light', b !== btn);
      });
      load();
    });
  });

  listEl.addEventListener('click', function (event) {
    const action = event.target.closest('[data-notification-action]');
    if (!action) return;
    event.preventDefault();
    const id = action.getAttribute('data-notification-action');
    const href = action.getAttribute('href');
    markRead(id, true).finally(function () {
      window.location.href = href;
    });
  });

  if (readAllBtn) {
    readAllBtn.addEventListener('click', function () {
      postJson(endpoints.readAll, { limit: 500 }).then(load).catch(load);
    });
  }

  load();
})();
</script>
</body>
</html>
