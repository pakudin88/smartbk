<?php
/**
 * View: Data Orang Tua Murid
 *
 * @var int $murid_id
 * @var string $title
 */
?>

<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>
<?= esc($title) ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2><?= esc($title) ?></h2>
    <div class="alert alert-info">Halaman detail orang tua murid untuk ID murid: <strong><?= esc($murid_id) ?></strong></div>
    <p>Silakan lengkapi implementasi detail data orang tua murid di sini.</p>
</div>
<?= $this->endSection() ?>
