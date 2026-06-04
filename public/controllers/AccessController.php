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

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/GroupController.php';

/**
 * Controller untuk Access Matrix page
 * - Reuses GroupController to obtain group list and access resolution
 */
class AccessController {
  public string $lang = 'ms';
  public array  $profile = [];

  /** @var GroupController */
  protected GroupController $groupCtrl;

  /** Roles selected for the matrix (array of groups: ['id'=>, 'kod'=>, 'nama'=>]) */
  public array $roles = [];

  /** Matrix rows (menus) */
  public array $rows = [];

  public function __construct()
  {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $this->groupCtrl = new GroupController();
    $this->lang = $this->groupCtrl->lang ?? ($_SESSION['lang'] ?? 'ms');
    $this->profile = $this->groupCtrl->profile ?? [];

    // Use dynamic groups from GroupController — support any number of groups
    $available = $this->groupCtrl->senaraiGroup ?? [];
    $displayRoles = [];
    foreach ($available as $g) {
      $gid = (int)($g['f_groupID'] ?? 0);
      $gname = trim((string)($g['f_groupName'] ?? $g['f_groupNama'] ?? ($g['f_groupKod'] ?? '')));
      $gkod  = (string)($g['f_groupKod'] ?? '');
      $displayRoles[] = ['key'=> 'g'.($gid), 'id'=>$gid, 'kod'=>$gkod, 'nama'=> $gname];
    }
    // Fallback: if no groups found, preserve empty roles to avoid breaking view
    if (!$displayRoles) {
      $displayRoles = [];
    }
    $this->roles = $displayRoles;

    // Build modules+menus matrix using GroupController->getAccessDetail
    $this->buildModules();
  }

  /** Build modules with menus and per-role permissions
   * Output structure stored in $this->rows as modules[] where each module: ['id','nama','menus'=>[['id','nama','path','perms'=>[roleId=>bool]]]]
   */
  protected function buildModules(): void
  {
    $roles = $this->roles;
    if (!$roles) { $this->rows = []; return; }

    $modulesMap = []; // modulId => ['id','nama','menus' => menuId=>['id','nama','path','perms'=>[]]]

    foreach ($roles as $r) {
      $rid = (int)$r['id'];
      $detail = $this->groupCtrl->getAccessDetail($rid);
      $mods = $detail['modules'] ?? [];
      foreach ($mods as $m) {
        $mid = (int)($m['id'] ?? 0);
        $mname = (string)($m['nama'] ?? '');
        if (!isset($modulesMap[$mid])) {
          $modulesMap[$mid] = ['id'=>$mid, 'nama'=>$mname, 'menus'=>[]];
        }
        $menus = $m['menus'] ?? [];
        foreach ($menus as $mm) {
          $menuId = (int)($mm['id'] ?? 0);
          if ($menuId <= 0) continue;
          if (!isset($modulesMap[$mid]['menus'][$menuId])) {
            $modulesMap[$mid]['menus'][$menuId] = ['id'=>$menuId, 'nama'=>(string)($mm['nama'] ?? ''), 'path'=>(string)($mm['path'] ?? ''), 'perms'=>[]];
          }
          $modulesMap[$mid]['menus'][$menuId]['perms'][$rid] = true;
        }
      }
    }

    // Convert menus map to ordered arrays
    ksort($modulesMap, SORT_NUMERIC);
    $modulesOut = [];
    foreach ($modulesMap as $mod) {
      $menus = $mod['menus'];
      ksort($menus, SORT_NUMERIC);
      $menusOut = array_values($menus);
      $modulesOut[] = ['id'=>$mod['id'], 'nama'=>$mod['nama'], 'menus'=>$menusOut];
    }

    $this->rows = $modulesOut;
  }

  /** Return matrix suitable for JSON or view */
  public function getMatrix(): array
  {
    return ['roles'=>$this->roles, 'modules'=>$this->rows];
  }
}
