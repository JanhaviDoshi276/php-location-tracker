<?php
$file = __DIR__ . '/data/page_views.json';
$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
?>

<h3>📊 Page View Counts</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>Page</th>
        <th>Views</th>
    </tr>
    <?php foreach ($data as $page => $count): ?>
        <tr>
            <td>
                <?= htmlspecialchars($page) ?>
            </td>
            <td>
                <?= $count ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>