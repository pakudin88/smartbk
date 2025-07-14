<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Jendela Kemitraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-home me-2"></i>Dashboard - Jendela Kemitraan</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success">
                            <h5><i class="fas fa-user me-2"></i>Selamat Datang, <?= esc($user_name) ?>!</h5>
                            <p class="mb-0">Anda berhasil login ke sistem Jendela Kemitraan Orang Tua.</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-header">
                                        <h6><i class="fas fa-user-circle me-2"></i>Informasi Akun</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Username:</strong></td>
                                                <td><?= session('username') ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td><?= session('email') ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Hubungan:</strong></td>
                                                <td><?= session('hubungan_keluarga') ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Login:</strong></td>
                                                <td><?= date('d M Y, H:i') ?> WIB</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-header">
                                        <h6><i class="fas fa-list me-2"></i>Menu Utama</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <a href="/notifications" class="btn btn-outline-primary">
                                                <i class="fas fa-bell me-2"></i>Notifikasi
                                            </a>
                                            <a href="/profile" class="btn btn-outline-info">
                                                <i class="fas fa-user-graduate me-2"></i>Profil Anak
                                            </a>
                                            <a href="/academic" class="btn btn-outline-success">
                                                <i class="fas fa-chart-line me-2"></i>Laporan Akademik
                                            </a>
                                            <a href="/finance" class="btn btn-outline-warning">
                                                <i class="fas fa-money-bill me-2"></i>Keuangan
                                            </a>
                                            <a href="/logout" class="btn btn-outline-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6><i class="fas fa-info-circle me-2"></i>Status Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <h6>✅ Sistem Login Berhasil</h6>
                                            <p class="mb-0">
                                                <small>
                                                    Database: Connected | User: Authenticated | Session: Active<br>
                                                    Login dengan kredensial: <strong>demo_parent</strong> / <strong>demo123</strong>
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <small>
                            <i class="fas fa-school me-1"></i>Smart BookKeeping - Jendela Kemitraan Orang Tua
                            | <i class="fas fa-clock me-1"></i><?= date('Y') ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
