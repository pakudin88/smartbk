<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Pengguna Murid - Simple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-4">
        <h2><i class="fas fa-graduation-cap"></i> Test Pengguna Murid - Simple View</h2>
        
        <div class="card">
            <div class="card-header">
                <h5>Debug Information</h5>
            </div>
            <div class="card-body">
                <h6>Title:</h6>
                <p><?= $title ?? 'No title' ?></p>
                
                <h6>Active School Year ID:</h6>
                <p><?= $active_school_year_id ?? 'No active school year' ?></p>
                
                <h6>Statistics:</h6>
                <ul>
                    <li>Total: <?= $stats['total'] ?? 0 ?></li>
                    <li>Laki-laki: <?= $stats['laki_laki'] ?? 0 ?></li>
                    <li>Perempuan: <?= $stats['perempuan'] ?? 0 ?></li>
                    <li>Sudah Kelas: <?= $stats['sudah_kelas'] ?? 0 ?></li>
                    <li>Belum Kelas: <?= $stats['belum_kelas'] ?? 0 ?></li>
                </ul>
                
                <h6>Kelas Data:</h6>
                <p>Count: <?= is_array($kelas) ? count($kelas) : 0 ?></p>
                
                <h6>Tahun Ajaran Data:</h6>
                <p>Count: <?= is_array($tahun_ajaran) ? count($tahun_ajaran) : 0 ?></p>
                
                <div class="alert alert-success">
                    ✅ View is working! Controller passed data successfully.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
