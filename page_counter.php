<?php
$dir = __DIR__ . '/data';
$file = $dir . '/page_views.json';

// Ensure data directory exists
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

// Read existing counts
$views = [];
if (file_exists($file)) {
    $views = json_decode(file_get_contents($file), true) ?? [];
}

// Get page name
$page = $_GET['page'] ?? 'index';

// Increase count
if (!isset($views[$page])) {
    $views[$page] = 0;
}
$views[$page]++;

// Save back
file_put_contents($file, json_encode($views, JSON_PRETTY_PRINT), LOCK_EX);

// Optional response
echo json_encode([
    "page" => $page,
    "count" => $views[$page]
]);
