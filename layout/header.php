<?php
require_once __DIR__ . '/../config/auth.php';
dkp_require_login();

require_once __DIR__ . '/../config/koneksi.php';

$asset_prefix = file_exists('design/app-modern.css') ? '' : '../';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris ATK DKP3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= $asset_prefix ?>design/app-modern.css">
</head>
<body>
<div class="d-flex" id="wrapper">
