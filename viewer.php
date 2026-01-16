<?php
$dir = __DIR__ . '/data';
$files = glob($dir . '/locations_*.json');
sort($files, SORT_NATURAL);

// Selected file
$selected = $_GET['file'] ?? basename($files[0] ?? '');
$filePath = $dir . '/' . basename($selected);

// Read data safely
$data = [];
if ($selected && file_exists($filePath)) {
    $data = json_decode(file_get_contents($filePath), true) ?? [];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Location JSON Viewer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        h2 {
            margin-bottom: 10px;
        }

        select {
            padding: 8px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #2563eb;
            color: white;
        }

        tr:hover {
            background: #f8fafc;
        }

        .empty {
            padding: 20px;
            background: white;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>📂 Location JSON Viewer</h2>

        <?php if ($files): ?>
            <form method="get">
                <label>Select File:</label>
                <select name="file" onchange="this.form.submit()">
                    <?php foreach ($files as $file):
                        $name = basename($file); ?>
                        <option value="<?= $name ?>" <?= $name === $selected ? 'selected' : '' ?>>
                            <?= $name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        <?php endif; ?>

        <?php if ($data): ?>
            <table>
                <tr>
                    <th>#</th>
                    <th>IP</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Accuracy</th>
                    <th>Time</th>
                </tr>

                <?php foreach ($data as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($row['ip'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['latitude'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['longitude'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['accuracy'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['time'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <div class="empty">No data found in this file.</div>
        <?php endif; ?>

    </div>

</body>

</html>