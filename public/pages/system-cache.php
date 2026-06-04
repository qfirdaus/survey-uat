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
require_once __DIR__ . '/../ajax/_helpers.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../controllers/SystemCacheMaintenanceController.php';

$pdo = Database::getInstance('mysql')->getConnection();
ensurePageGroupManagePermission($pdo, (string)(__('systemCache_forbidden') ?: 'You do not have permission to access system cache maintenance.'));

if (!function_exists('h')) {
    function h($value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

function sc_t(string $key, string $fallback): string
{
    $value = __($key);
    return ($value === $key || $value === null || $value === '') ? $fallback : (string)$value;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$controller = new SystemCacheMaintenanceController();
$locations = $controller->getLocations();
$summary = $controller->getSummary();
$lang = (string)($_SESSION['lang'] ?? 'ms');
$version = (string)($_ENV['APP_ASSET_VER'] ?? date('ymdHis'));
$PAGE_TITLE = sc_t('systemCache_page_title', 'System Cache');
?>
<!doctype html>
<html lang="<?= h($lang) ?>" data-bs-theme="<?= h($_SESSION['theme.layout'] ?? 'light') ?>">
<head>
  <?php
    $NEED_DATERANGE = false;
    $NEED_VECTORMAP = false;
    $NEED_DATATABLES = true;
    $NEED_SELECT2 = false;
    include __DIR__ . '/../includes/head.php';
  ?>
  <meta name="csrf-token" content="<?= h((string)$_SESSION['csrf_token']) ?>">
  <link href="<?= h(base_url('assets/css/datatables-standard.css')) ?>?v=<?= h($version) ?>" rel="stylesheet">
  <style>
    .system-cache-summary .card { border-radius: 8px; border: 1px solid rgba(15,23,42,.08); box-shadow: 0 8px 22px rgba(15,23,42,.05); }
    .system-cache-summary .stat-icon { width: 42px; height: 42px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; background: rgba(var(--bs-primary-rgb), .1); color: var(--bs-primary); font-size: 1.35rem; }
    .system-cache-table-card { border-radius: 8px; border: 1px solid rgba(15,23,42,.08); box-shadow: 0 8px 22px rgba(15,23,42,.05); }
    #systemCacheTable th, #systemCacheTable td { vertical-align: middle; }
    .system-cache-location { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; font-size: .86rem; }
    .system-cache-actions { gap: .5rem; }
  </style>
</head>
<body data-topbar-color="<?= h($_SESSION['theme.topbar'] ?? 'light') ?>"
      data-menu-color="<?= h($_SESSION['theme.menu'] ?? 'light') ?>"
      data-layout="vertical"
      data-sidebar-size="default"
      class="loading">
<div class="wrapper">
  <?php include __DIR__ . '/../includes/topbar.php'; ?>
  <?php include __DIR__ . '/../includes/sidebar.php'; ?>

  <div class="content-page">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0"><i class="ri-delete-bin-6-line me-1"></i><?= h(sc_t('systemCache_page_title', 'System Cache')) ?></h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="<?= h(base_url('pages/dashboard.php')) ?>"><?= h(sc_t('common_dashboard', 'Dashboard')) ?></a></li>
                  <li class="breadcrumb-item active"><?= h(sc_t('systemCache_breadcrumb_active', 'Clear Cache')) ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="row system-cache-summary g-3 mb-3">
          <div class="col-xl-3 col-md-6">
            <div class="card mb-0"><div class="card-body d-flex align-items-center gap-3">
              <span class="stat-icon"><i class="ri-folder-2-line"></i></span>
              <div><div class="text-muted small"><?= h(sc_t('systemCache_stat_locations', 'Cache Locations')) ?></div><h4 class="mb-0" id="systemCacheStatLocations"><?= h((string)$summary['locations']) ?></h4></div>
            </div></div>
          </div>
          <div class="col-xl-3 col-md-6">
            <div class="card mb-0"><div class="card-body d-flex align-items-center gap-3">
              <span class="stat-icon"><i class="ri-file-list-3-line"></i></span>
              <div><div class="text-muted small"><?= h(sc_t('systemCache_stat_files', 'Cache Files')) ?></div><h4 class="mb-0" id="systemCacheStatFiles"><?= h((string)$summary['files']) ?></h4></div>
            </div></div>
          </div>
          <div class="col-xl-3 col-md-6">
            <div class="card mb-0"><div class="card-body d-flex align-items-center gap-3">
              <span class="stat-icon"><i class="ri-hard-drive-3-line"></i></span>
              <div><div class="text-muted small"><?= h(sc_t('systemCache_stat_size', 'Cache Size')) ?></div><h4 class="mb-0" id="systemCacheStatSize" data-cache-total-bytes="<?= h((string)$summary['bytes']) ?>"><?= h((string)$summary['size']) ?></h4></div>
            </div></div>
          </div>
          <div class="col-xl-3 col-md-6">
            <div class="card mb-0"><div class="card-body">
              <div class="d-flex justify-content-between"><span class="text-muted small"><?= h(sc_t('systemCache_stat_opcache', 'OPcache')) ?></span><span class="badge bg-secondary-subtle text-secondary"><?= h((string)$summary['opcache']['label']) ?></span></div>
              <div class="d-flex justify-content-between mt-2"><span class="text-muted small"><?= h(sc_t('systemCache_stat_apcu', 'APCu')) ?></span><span class="badge bg-secondary-subtle text-secondary"><?= h((string)$summary['apcu']['label']) ?></span></div>
            </div></div>
          </div>
        </div>

        <div class="card system-cache-table-card">
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 system-cache-actions">
              <div>
                <h5 class="card-title mb-1"><?= h(sc_t('systemCache_table_title', 'Discovered Cache Locations')) ?></h5>
                <p class="text-muted mb-0"><?= h(sc_t('systemCache_table_subtitle', 'Only cache files inside standard project cache folders are listed. Directory structure is preserved.')) ?></p>
              </div>
              <div class="d-flex flex-wrap system-cache-actions">
                <button type="button" class="btn btn-outline-danger" id="btnClearSelected">
                  <i class="ri-checkbox-multiple-line me-1"></i><?= h(sc_t('systemCache_action_clear_selected', 'Clear Selected')) ?>
                </button>
                <button type="button" class="btn btn-danger" id="btnClearAll">
                  <i class="ri-delete-bin-line me-1"></i><?= h(sc_t('systemCache_action_clear_all', 'Clear All Cache')) ?>
                </button>
              </div>
            </div>

            <div class="table-responsive">
              <table id="systemCacheTable" class="table table-striped table-bordered align-middle w-100">
                <thead>
                  <tr>
                    <th style="width:44px"><input type="checkbox" class="form-check-input" id="selectAllCache"></th>
                    <th><?= h(sc_t('systemCache_col_location', 'Location')) ?></th>
                    <th><?= h(sc_t('systemCache_col_files', 'Files')) ?></th>
                    <th><?= h(sc_t('systemCache_col_size', 'Size')) ?></th>
                    <th><?= h(sc_t('systemCache_col_modified', 'Last Modified')) ?></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($locations as $location): ?>
                  <tr data-cache-location-id="<?= h((string)$location['id']) ?>">
                    <td><input type="checkbox" class="form-check-input cache-location-check" value="<?= h((string)$location['id']) ?>"></td>
                    <td><span class="system-cache-location"><?= h((string)$location['location']) ?></span></td>
                    <td data-cache-files><?= h((string)$location['files']) ?></td>
                    <td data-cache-size data-cache-bytes="<?= h((string)$location['bytes']) ?>"><?= h((string)$location['size']) ?></td>
                    <td data-cache-modified><?= h((string)$location['last_modified']) ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php if ($locations === []): ?>
                  <tr><td colspan="5" class="text-center text-muted py-4"><?= h(sc_t('systemCache_empty', 'No standard cache locations were found.')) ?></td></tr>
                <?php endif; ?>
                </tbody>
              </table>
            </div>
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
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  const actionUrl = <?= json_encode(base_url('ajax/system-cache-action.php'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
  const selectAll = document.getElementById('selectAllCache');
  const checks = Array.from(document.querySelectorAll('.cache-location-check'));
  const text = {
    confirmTitle: <?= json_encode(sc_t('systemCache_confirm_title', 'Clear System Cache?'), JSON_UNESCAPED_UNICODE) ?>,
    confirmText: <?= json_encode(sc_t('systemCache_confirm_text', 'This action will remove discovered cache files and reset PHP cache.'), JSON_UNESCAPED_UNICODE) ?>,
    cancel: <?= json_encode(sc_t('systemCache_confirm_cancel', 'Cancel'), JSON_UNESCAPED_UNICODE) ?>,
    clear: <?= json_encode(sc_t('systemCache_confirm_clear', 'Clear Cache'), JSON_UNESCAPED_UNICODE) ?>,
    success: <?= json_encode(sc_t('systemCache_success_title', 'Cache Cleared'), JSON_UNESCAPED_UNICODE) ?>,
    error: <?= json_encode(sc_t('config_js_ralat', 'Error'), JSON_UNESCAPED_UNICODE) ?>,
    noSelection: <?= json_encode(sc_t('systemCache_error_no_selection', 'Select at least one cache location.'), JSON_UNESCAPED_UNICODE) ?>,
    loading: <?= json_encode(sc_t('systemCache_loading', 'Clearing cache...'), JSON_UNESCAPED_UNICODE) ?>,
    note: <?= json_encode(sc_t('systemCache_success_note', 'Users do not need to logout/login after clearing cache. A page refresh is normally sufficient.'), JSON_UNESCAPED_UNICODE) ?>
  };

  if (window.jQuery && jQuery.fn.DataTable && checks.length > 0) {
    jQuery('#systemCacheTable').DataTable({
      pageLength: 10,
      order: [[1, 'asc']],
      columnDefs: [{ targets: 0, orderable: false, searchable: false }]
    });
  }

  selectAll?.addEventListener('change', function () {
    checks.forEach((check) => { check.checked = selectAll.checked; });
  });

  document.getElementById('btnClearSelected')?.addEventListener('click', function () {
    const selected = checks.filter((check) => check.checked).map((check) => check.value);
    if (selected.length === 0) {
      showAlert('warning', text.error, text.noSelection);
      return;
    }
    confirmAndClear('selected', selected);
  });

  document.getElementById('btnClearAll')?.addEventListener('click', function () {
    confirmAndClear('all', []);
  });

  async function confirmAndClear(scope, selected) {
    if (window.Swal && typeof Swal.fire === 'function') {
      const result = await Swal.fire({
        icon: 'warning',
        title: text.confirmTitle,
        text: text.confirmText,
        showCancelButton: true,
        confirmButtonText: text.clear,
        cancelButtonText: text.cancel,
        confirmButtonColor: '#dc3545'
      });
      if (!result.isConfirmed) return;
    } else if (!window.confirm(text.confirmTitle + '\n\n' + text.confirmText)) {
      return;
    }

    const loaderToken = showGlobalLoader(text.loading);
    const form = new FormData();
    form.set('action', 'clear');
    form.set('scope', scope);
    form.set('csrf_token', csrfToken);
    selected.forEach((id) => form.append('locations[]', id));

    try {
      const response = await fetch(actionUrl, {
        method: 'POST',
        headers: { 'X-CSRF-Token': csrfToken, 'Accept': 'application/json' },
        body: form
      });
      const data = await response.json();
      if (!response.ok || data.error || data.success === false) {
        throw new Error(data.message || text.error);
      }

      const result = data.result || {};
      hideGlobalLoader(loaderToken);
      applyClearResult(result);
      const locations = Array.isArray(result.locations_cleared) ? result.locations_cleared.length : 0;
      const details = [
        <?= json_encode(sc_t('systemCache_result_files', 'Files removed'), JSON_UNESCAPED_UNICODE) ?> + ': ' + (result.files_removed || 0),
        <?= json_encode(sc_t('systemCache_result_size', 'Size freed'), JSON_UNESCAPED_UNICODE) ?> + ': ' + (result.freed_size || '0 B'),
        <?= json_encode(sc_t('systemCache_result_locations', 'Locations cleared'), JSON_UNESCAPED_UNICODE) ?> + ': ' + locations,
        'OPcache: ' + ((result.opcache && result.opcache.message) || '-'),
        'APCu: ' + ((result.apcu && result.apcu.message) || '-'),
        text.note
      ].join('\n');

      await showAlert('success', text.success, details);
    } catch (error) {
      hideGlobalLoader(loaderToken);
      showAlert('error', text.error, error.message || text.error);
    }
  }

  function showGlobalLoader(message) {
    if (window.AppLoader && typeof window.AppLoader.show === 'function') {
      return window.AppLoader.show(message, { timeout: 60000 });
    }
    if (window.IQSLoader && typeof window.IQSLoader.show === 'function') {
      return window.IQSLoader.show(message, { timeout: 60000 });
    }
    return null;
  }

  function hideGlobalLoader(token) {
    if (window.AppLoader && typeof window.AppLoader.hide === 'function') {
      window.AppLoader.hide(token);
      return;
    }
    if (window.IQSLoader && typeof window.IQSLoader.hide === 'function') {
      window.IQSLoader.hide(token);
    }
  }

  function applyClearResult(result) {
    const cleared = Array.isArray(result.locations_cleared) ? result.locations_cleared : [];
    cleared.forEach(function (location) {
      const row = document.querySelector('tr[data-cache-location-id="' + cssEscape(location.id || '') + '"]');
      if (!row) return;
      const checkbox = row.querySelector('.cache-location-check');
      if (checkbox) checkbox.checked = false;
      const filesCell = row.querySelector('[data-cache-files]');
      const sizeCell = row.querySelector('[data-cache-size]');
      const modifiedCell = row.querySelector('[data-cache-modified]');
      if (filesCell) filesCell.textContent = '0';
      if (sizeCell) {
        sizeCell.textContent = '0 B';
        sizeCell.dataset.cacheBytes = '0';
      }
      if (modifiedCell) modifiedCell.textContent = '-';
    });

    if (selectAll) selectAll.checked = false;

    const filesStat = document.getElementById('systemCacheStatFiles');
    const sizeStat = document.getElementById('systemCacheStatSize');
    if (filesStat) {
      const currentFiles = parseInt(filesStat.textContent || '0', 10) || 0;
      filesStat.textContent = String(Math.max(0, currentFiles - (parseInt(result.files_removed || 0, 10) || 0)));
    }
    if (sizeStat) {
      const remainingBytes = Array.from(document.querySelectorAll('[data-cache-bytes]')).reduce(function (total, cell) {
        return total + (parseInt(cell.dataset.cacheBytes || '0', 10) || 0);
      }, 0);
      sizeStat.dataset.cacheTotalBytes = String(remainingBytes);
      sizeStat.textContent = formatBytes(remainingBytes);
    }
  }

  function formatBytes(bytes) {
    const value = Math.max(0, parseInt(bytes || 0, 10) || 0);
    if (value < 1024) return value + ' B';
    const units = ['KB', 'MB', 'GB', 'TB'];
    let size = value;
    for (let i = 0; i < units.length; i += 1) {
      size = size / 1024;
      if (size < 1024) {
        return size.toFixed(size >= 10 ? 1 : 2) + ' ' + units[i];
      }
    }
    return size.toFixed(1) + ' TB';
  }

  function cssEscape(value) {
    if (window.CSS && typeof window.CSS.escape === 'function') {
      return window.CSS.escape(String(value));
    }
    return String(value).replace(/"/g, '\\"');
  }

  function showAlert(icon, title, message) {
    if (window.Swal && typeof Swal.fire === 'function') {
      return Swal.fire({ icon, title, text: message });
    }
    window.alert(title + '\n\n' + message);
    return Promise.resolve();
  }
})();
</script>
</body>
</html>
