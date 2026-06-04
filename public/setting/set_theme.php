<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['theme_type'] ?? '';
    $value = $_POST['theme_value'] ?? '';

    // Pastikan hanya type yang dibenarkan
    $allowed = ['data-bs-theme', 'data-topbar-color', 'data-menu-color'];

    if (in_array($type, $allowed)) {
        // Simpan dalam session, key dalam format yang sesuai
        if ($type === 'data-bs-theme') $_SESSION['theme.layout'] = $value;
        if ($type === 'data-topbar-color') $_SESSION['theme.topbar'] = $value;
        if ($type === 'data-menu-color') $_SESSION['theme.menu'] = $value;
    }
}
