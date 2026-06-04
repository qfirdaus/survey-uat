<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */
// pages/access-matrix.php — Access Matrix view
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_login();

require_once __DIR__ . '/../controllers/AccessController.php';
$controller = new AccessController();

$lang    = $controller->lang ?? 'ms';
$profile = $controller->profile ?? [];
$matrix  = $controller->getMatrix();
$roles   = $matrix['roles'] ?? [];
$modules = $matrix['modules'] ?? [];
$rows    = []; // legacy compatibility
$version = (string)($_ENV['APP_ASSET_VER'] ?? date('ymdHis'));
$rolesCount = count($roles ?? []);
$dynamicRoleWidthPct = $rolesCount > 0 ? (65 / $rolesCount) : 0.0;
$dynamicRoleWidthStr = number_format($dynamicRoleWidthPct, 4, '.', '');
$PAGE_TITLE = (string)(__('access_title') ?? 'Access Matrix');

if (!function_exists('h')) {
    function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}

// CSRF
if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(16)); }
$csrf = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="<?= h($lang) ?>" data-bs-theme="<?= h($_SESSION['theme.layout'] ?? 'light') ?>">
<head>
    <?php include __DIR__ . '/../includes/head.php'; ?>
  <meta name="csrf-token" content="<?= h($csrf) ?>">
  <link href="<?= base_url('assets/css/datatables-standard.css') ?>?v=<?= h($version) ?>" rel="stylesheet">
  <style>
    /* Adopt group table visual style (kumpulan-pengguna.php) for #userDT */
    #userDT {
      border-radius: 8px;
      overflow: hidden;
      box-shadow: none;
      border: 1px solid rgba(148, 163, 184, 0.14);
      background: rgba(255, 255, 255, 0.96);
      table-layout: fixed;
    }
    #userDT thead {
      background: transparent;
      color: inherit;
    }
    #userDT thead th {
      font-weight: 700;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      padding: 0.72rem 0.78rem;
      border: 0;
      border-bottom: 1px solid rgba(148, 163, 184, 0.16);
      color: #334155;
      background: linear-gradient(180deg, rgba(248, 250, 252, 0.98) 0%, rgba(241, 245, 249, 0.95) 100%);
    }
    /* Module header row */
    #userDT tr.module-row td { background-color: #e6f2ff !important; font-weight:700; color:var(--bs-body-color) !important; padding: .68rem .72rem; }
    /* Remove builtin striping to keep flat look */
    #userDT tbody tr,
    #userDT tbody tr:nth-of-type(odd),
    #userDT tbody tr:nth-of-type(even) { background-color: transparent !important; }
    #userDT tbody tr { transition: background-color 0.18s ease, box-shadow 0.18s ease; }
    #userDT tbody tr:hover { background: rgba(241, 245, 249, 0.88) !important; transform: none; box-shadow: inset 0 0 0 999px rgba(241, 245, 249, 0.3); }
    #userDT tbody td { padding: 0.62rem 0.78rem; border-color: rgba(226, 232, 240, 0.9); vertical-align: middle; font-size: 0.88rem; line-height: 1.28; }
    html[data-bs-theme="dark"] #userDT thead { background: transparent; }
    html[data-bs-theme="dark"] #userDT thead th { background: linear-gradient(180deg, rgba(30, 41, 59, 0.96) 0%, rgba(15, 23, 42, 0.94) 100%); color: #dbe4f0; border-bottom-color: rgba(148, 163, 184, 0.18); }
    html[data-bs-theme="dark"] #userDT tbody tr:hover { background: rgba(30, 41, 59, 0.76) !important; box-shadow: inset 0 0 0 999px rgba(30, 41, 59, 0.18); }

    /* Preserve existing small utilities */
    .truncate-1line { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; display:block; }
    .access-badge { font-size:0.78rem; padding:.25rem .45rem; border-radius:.35rem; }
    .access-badge.yes { background: rgba(var(--bs-success-rgb, 25,135,84),0.12); color:var(--bs-success); border:1px solid rgba(var(--bs-success-rgb,25,135,84),0.15); }
    .access-badge.no  { background: rgba(var(--bs-danger-rgb,220,53,69),0.06); color:var(--bs-danger); border:1px solid rgba(var(--bs-danger-rgb,220,53,69),0.08); }
    .matrix-table .action-gap { display:flex; gap:0.35rem; }

    /* Column sizing tweaks matching kumpulan-pengguna layout */
    .col-nama { text-align:left; }
    .col-path{ text-align:center; }
    .col-akses{ text-align:center; }
    .col-path .truncate-1line { white-space:nowrap; font-size:0.95rem; }
    .group-col { white-space:normal; }

    /* DataTables wrapper niceties when table gets enhanced */
    #userDT_wrapper .dataTables_length { display: flex; align-items: center; white-space: nowrap; }
    #userDT_wrapper .dataTables_filter { text-align: right; margin-left: auto; }

    /* Match senarai-pengguna table shell */
    .content-page .card {
      border-radius: 8px;
      border: 1px solid rgba(148, 163, 184, 0.14);
      box-shadow: 0 16px 38px rgba(15, 23, 42, 0.07);
      overflow: hidden;
      backdrop-filter: blur(10px);
    }
    .content-page .card > .card-body {
      padding: 1.15rem 1.15rem 1rem;
    }
    #userDT {
      width: 100%;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: none;
      border: 1px solid rgba(148, 163, 184, 0.14);
      background: rgba(255, 255, 255, 0.96);
    }
    #userDT thead {
      background: transparent;
      color: inherit;
    }
    #userDT thead th {
      padding: 0.72rem 0.78rem;
      border: 0;
      border-bottom: 1px solid rgba(148, 163, 184, 0.16);
      background: linear-gradient(180deg, rgba(248, 250, 252, 0.98) 0%, rgba(241, 245, 249, 0.95) 100%);
      color: #334155;
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      white-space: nowrap;
    }
    #userDT tbody td {
      padding: 0.62rem 0.78rem;
      border-color: rgba(226, 232, 240, 0.9);
      font-size: 0.88rem;
      line-height: 1.28;
      vertical-align: middle;
    }
    #userDT tbody tr {
      transition: background-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
    }
    #userDT tbody tr:hover {
      background: rgba(241, 245, 249, 0.88) !important;
      transform: none;
      box-shadow: inset 0 0 0 999px rgba(241, 245, 249, 0.3);
    }
    #userDT tr.module-row td {
      background: linear-gradient(180deg, rgba(226, 232, 240, 0.72) 0%, rgba(241, 245, 249, 0.9) 100%) !important;
      color: #1e293b !important;
      border-top: 1px solid rgba(148, 163, 184, 0.14);
      border-bottom: 1px solid rgba(148, 163, 184, 0.14);
      font-size: 0.82rem;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      padding: 0.68rem 0.72rem;
    }
    html[data-bs-theme="dark"] #userDT {
      background: rgba(15, 23, 42, 0.92);
      border-color: rgba(148, 163, 184, 0.22);
    }
    html[data-bs-theme="dark"] #userDT thead th {
      background: linear-gradient(180deg, rgba(30, 41, 59, 0.96) 0%, rgba(15, 23, 42, 0.94) 100%);
      color: #dbe4f0;
      border-bottom-color: rgba(148, 163, 184, 0.18);
    }
    html[data-bs-theme="dark"] #userDT tbody td {
      border-color: rgba(51, 65, 85, 0.95);
    }
    html[data-bs-theme="dark"] #userDT tbody tr:hover {
      background: rgba(30, 41, 59, 0.76) !important;
      box-shadow: inset 0 0 0 999px rgba(30, 41, 59, 0.18);
    }
    html[data-bs-theme="dark"] #userDT tr.module-row td {
      background: linear-gradient(180deg, rgba(30, 41, 59, 0.92) 0%, rgba(15, 23, 42, 0.94) 100%) !important;
      color: #e2e8f0 !important;
      border-top-color: rgba(148, 163, 184, 0.18);
      border-bottom-color: rgba(148, 163, 184, 0.18);
    }
  </style>
</head>
<body
  data-topbar-color="<?= h($_SESSION['theme.topbar'] ?? 'light') ?>"
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

        <div class="row mb-3">
          <div class="col-12">
            <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
              <h4 class="page-title"><i class="ri-shield-keyhole-line me-1"></i> <?= __('access_title') ?? 'Access Matrix' ?></h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="dashboard.php"><i class="ri-home-4-line align-middle me-1"></i> <?= __('breadcrumb_home') ?? 'Home' ?></a></li>
                  <li class="breadcrumb-item active"><?= __('access_title') ?? 'Access Matrix' ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <p class="text-muted mb-3"><?= __('access_intro') ?? 'Read-only access matrix for system menus.' ?></p>

                <div class="table-responsive dt-standard position-relative">
                  <table id="userDT" class="table table-hover table-striped table-sm table-bordered w-100 matrix-table align-middle">
                    <colgroup>
                      <col style="width:5%">
                      <col style="width:15%">
                      <col style="width:15%">
                      <?php foreach ($roles as $r): ?>
                        <col style="width:<?= h($dynamicRoleWidthStr) ?>%">
                      <?php endforeach; ?>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="col-bil text-center"><?= __('access_col_no') ?? '#' ?></th>
                        <th class="col-nama"><?= __('access_menu') ?? 'Menu' ?></th>
                        <th class="col-path text-center" style="white-space:nowrap"><?= __('access_path') ?? 'Path' ?></th>
                        <?php foreach ($roles as $r): ?>
                          <th class="text-center group-col" title="<?= h($r['nama'] ?? $r['kod'] ?? '') ?>"><?= h($r['nama'] ?: $r['kod'] ?: __('access_user_level')) ?></th>
                        <?php endforeach; ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($modules)): ?>
                        <?php $rowNo = 0; ?>
                        <?php foreach ($modules as $mod): ?>
                          <?php // Module header row - full-width, not part of sorting visual ?>
                          <tr class="module-row" data-module-id="<?= h((string)($mod['id'] ?? '')) ?>">
                            <td colspan="<?= 3 + max(0, $rolesCount) ?>"><?= h( (__('access_modul') ? __('access_modul') . ': ' : '') . ($mod['nama'] ?? 'Module') ) ?></td>
                          </tr>

                          <?php foreach (($mod['menus'] ?? []) as $m): ?>
                            <?php $rowNo++; ?>
                            <tr>
                              <td class="col-bil text-center"><?= $rowNo ?></td>
                              <td class="col-nama">
                                <div class="fw-semibold truncate-1line"><?= h($m['nama'] ?? '') ?></div>
                              </td>
                              <td class="col-path">
                                <div class="text-muted small truncate-1line" style="font-size:0.95rem; white-space:nowrap"><?= h($m['path'] ?? '') ?></div>
                              </td>
                              <?php // Dynamic group columns ?>
                              <?php foreach ($roles as $r): ?>
                                <?php $rid = (int)($r['id'] ?? 0); $has = ($rid ? !empty($m['perms'][$rid]) : false); ?>
                                <td class="text-center">
                                  <?php if ($has): ?>
                                    <span class="access-badge yes"><i class="ri-check-line"></i> <?= h(__('access_ada') ?? 'Has Access') ?></span>
                                  <?php else: ?>
                                    <span class="access-badge no"><i class="ri-close-line"></i> <?= h(__('access_tiada') ?? 'No Access') ?></span>
                                  <?php endif; ?>
                                </td>
                              <?php endforeach; ?>
                            </tr>
                          <?php endforeach; ?>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr><td colspan="<?= 3 + max(0, $rolesCount) ?>" class="text-center text-muted"><?= __('access_no') ?? 'Tiada rekod' ?></td></tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </div><!-- /.content -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
  </div><!-- /.content-page -->
</div><!-- /.wrapper -->

<?php include __DIR__ . '/../includes/script.php'; ?>
<!-- Plain table view: no DataTables initialization. Table retains same markup and heading as kumpulan-pengguna.php -->
<script>
  // No DataTables init for plain table layout.
</script>
</body>
</html>
