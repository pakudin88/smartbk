<?= $this->extend('layouts/modern_layout') ?>

<?= $this->section('content') ?>
<!-- Progress Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Progress & Feedback</h4>
                        <p class="mb-0 opacity-75">Pantau perkembangan dan berikan masukan untuk <?= esc($student_name) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Progress Tracking -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-tasks me-2"></i>Progres Rencana Aksi</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($progress_data)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Rencana Aksi</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Tanggal Update</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($progress_data as $progress): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($progress['action_title']) ?></strong><br>
                                        <small class="text-muted"><?= esc($progress['action_desc']) ?></small>
                                    </td>
                                    <td>
                                        <?php
                                        $statusClass = [
                                            'pending' => 'warning',
                                            'in_progress' => 'info', 
                                            'completed' => 'success',
                                            'review' => 'primary'
                                        ][$progress['status']] ?? 'secondary';
                                        
                                        $statusText = [
                                            'pending' => 'Menunggu',
                                            'in_progress' => 'Berlangsung',
                                            'completed' => 'Selesai', 
                                            'review' => 'Review'
                                        ][$progress['status']] ?? 'Unknown';
                                        ?>
                                        <span class="badge bg-<?= $statusClass ?>"><?= $statusText ?></span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-<?= $statusClass ?>" 
                                                 style="width: <?= $progress['progress_percentage'] ?? 0 ?>%"></div>
                                        </div>
                                        <small class="text-muted"><?= $progress['progress_percentage'] ?? 0 ?>%</small>
                                    </td>
                                    <td>
                                        <small><?= date('d M Y', strtotime($progress['updated_at'])) ?></small>
                                    </td>
                                    <td>
                                        <small><?= esc($progress['notes'] ?? '-') ?></small>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada data progress yang tersedia</h6>
                        <p class="text-muted">Progress akan ditampilkan setelah rencana aksi mulai dijalankan</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Feedback Form -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-comment-alt me-2"></i>Berikan Feedback</h5>
            </div>
            <div class="card-body">
                <form id="feedbackForm">
                    <div class="mb-3">
                        <label for="feedback" class="form-label">Masukan & Saran</label>
                        <textarea class="form-control" id="feedback" name="feedback" rows="4" 
                                  placeholder="Bagikan pengamatan, masukan, atau pertanyaan Anda mengenai perkembangan putra/putri di rumah..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Penilaian Kolaborasi</label>
                        <div class="rating-container d-flex gap-1 mb-2">
                            <input type="radio" class="btn-check" name="rating" id="rating1" value="1">
                            <label class="btn btn-outline-warning" for="rating1">⭐</label>
                            
                            <input type="radio" class="btn-check" name="rating" id="rating2" value="2">
                            <label class="btn btn-outline-warning" for="rating2">⭐⭐</label>
                            
                            <input type="radio" class="btn-check" name="rating" id="rating3" value="3">
                            <label class="btn btn-outline-warning" for="rating3">⭐⭐⭐</label>
                            
                            <input type="radio" class="btn-check" name="rating" id="rating4" value="4">
                            <label class="btn btn-outline-warning" for="rating4">⭐⭐⭐⭐</label>
                            
                            <input type="radio" class="btn-check" name="rating" id="rating5" value="5">
                            <label class="btn btn-outline-warning" for="rating5">⭐⭐⭐⭐⭐</label>
                        </div>
                        <small class="text-muted">1 = Perlu Perbaikan, 5 = Sangat Baik</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Feedback
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('feedbackForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const feedback = document.getElementById('feedback').value;
    const rating = document.querySelector('input[name="rating"]:checked');
    
    if (!feedback.trim()) {
        alert('Silakan isi feedback terlebih dahulu');
        return;
    }
    
    const formData = new FormData();
    formData.append('feedback', feedback);
    formData.append('rating', rating ? rating.value : 0);
    
    fetch('<?= base_url('submit-feedback') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            document.getElementById('feedbackForm').reset();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim feedback');
    });
});
</script>
<?= $this->endSection() ?>
