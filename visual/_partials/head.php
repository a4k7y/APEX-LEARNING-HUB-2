<?php
/**
 * visual/_partials/head.php
 * Reusable header & sub-bar for all visual pages in APEX Learning Hub
 * @var string $pageTitle
 * @var string $activePage (home | announcement | policies | contact | about)
 */
$pageTitle = $pageTitle ?? 'APEX Learning Hub';
$activePage = $activePage ?? '';
$visualBase = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/visual.css?v=202610301240">
</head>

<body<?= !empty($bodyClass) ? ' class="' . htmlspecialchars($bodyClass) . '"' : '' ?>>

    <?php include __DIR__ . '/navigation.php'; ?>