<?= $this->extend('layouts/simple_layout') ?>

<?= $this->section('title') ?>
Test Page
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1>Test Page</h1>
    <p>This is a simple test to verify the layout is working.</p>
    <div class="alert alert-success">
        <i class="fas fa-check"></i> Layout is working correctly!
    </div>
</div>
<?= $this->endSection() ?>
