<?php

$dir = __DIR__ . '/data';
$maxEntries = 10;

// Create folder if not exists
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

// Get all existing files
$files = glob($dir . '/locations_*.json');

// Decide current file number
if (empty($files)) {
    $fileNumber = 1;
} else {
    sort($files, SORT_NATURAL);
    $lastFile = end($files);
    preg_match('/locations_(\d+)\.json/', $lastFile, $match);
    $fileNumber = (int) $match[1];
}

// Current file path
$currentFile = "$dir/locations_$fileNumber.json";

// Read existing data
$data = [];
if (file_exists($currentFile)) {
    $data = json_decode(file_get_contents($currentFile), true) ?? [];
}

// If file has 10 entries → create new file
if (count($data) >= $maxEntries) {
    $fileNumber++;
    $currentFile = "$dir/locations_$fileNumber.json";
    $data = [];
}

// Read browser GPS data
$input = json_decode(file_get_contents("php://input"), true);

// Create entry
$entry = [
    "ip" => $_SERVER['REMOTE_ADDR'],
    "latitude" => $input['latitude'] ?? null,
    "longitude" => $input['longitude'] ?? null,
    "accuracy" => $input['accuracy'] ?? null,
    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
    "time" => date("Y-m-d H:i:s")
];

// Append & save
$data[] = $entry;
file_put_contents($currentFile, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);

echo json_encode([
    "status" => "saved",
    "file" => basename($currentFile),
    "entries_in_file" => count($data)
]);
