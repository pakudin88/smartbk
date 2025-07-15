<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-laptop-code text-primary"></i> Tes Bakat Minat Online</h2>
                    <p class="text-muted">Kelola dan monitor tes bakat minat secara online</p>
                </div>
                <div>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalSesiTes">
                        <i class="fas fa-play"></i> Mulai Sesi Tes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Sesi Tes -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-broadcast-tower"></i> Status Sesi Tes Aktif
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="alert alert-success text-center">
                                <h5><i class="fas fa-users"></i> 15</h5>
                                <small>Siswa Online</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning text-center">
                                <h5><i class="fas fa-clock"></i> 45:23</h5>
                                <small>Waktu Tersisa</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-info text-center">
                                <h5><i class="fas fa-check-circle"></i> 8</h5>
                                <small>Sudah Selesai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jenis Tes Tersedia -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list"></i> Jenis Tes Tersedia
                    </h6>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahJenisTes">
                        <i class="fas fa-plus"></i> Tambah Jenis Tes
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Tes Holland -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-left-primary">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="fas fa-compass"></i> Tes Minat Holland (RIASEC)
                                    </h5>
                                    <p class="card-text">Mengidentifikasi minat berdasarkan 6 tipe kepribadian Holland: Realistic, Investigative, Artistic, Social, Enterprising, Conventional.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge badge-success">Aktif</span>
                                        <div>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editTes('holland')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success" onclick="mulaiTes('holland')">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tes Gardner -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-left-success">
                                <div class="card-body">
                                    <h5 class="card-title text-success">
                                        <i class="fas fa-brain"></i> Tes Kecerdasan Majemuk Gardner
                                    </h5>
                                    <p class="card-text">Mengukur 8 jenis kecerdasan: Linguistik, Logis-Matematis, Visual-Spasial, Musikal, Kinestetik, Interpersonal, Intrapersonal, Naturalistik.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge badge-success">Aktif</span>
                                        <div>
                                            <button class="btn btn-sm btn-outline-success" onclick="editTes('gardner')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success" onclick="mulaiTes('gardner')">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tes MBTI -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-left-info">
                                <div class="card-body">
                                    <h5 class="card-title text-info">
                                        <i class="fas fa-user-friends"></i> Tes Kepribadian MBTI
                                    </h5>
                                    <p class="card-text">Mengidentifikasi 16 tipe kepribadian berdasarkan preferensi: Extraversion-Introversion, Sensing-Intuition, Thinking-Feeling, Judging-Perceiving.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge badge-warning">Draft</span>
                                        <div>
                                            <button class="btn btn-sm btn-outline-info" onclick="editTes('mbti')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-pause"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monitor Siswa -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-monitor"></i> Monitor Siswa Real-time
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jenis Tes</th>
                                    <th>Progress</th>
                                    <th>Waktu Mulai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ahmad Fadli</td>
                                    <td>XII IPA 1</td>
                                    <td>Holland RIASEC</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: 85%">85%</div>
                                        </div>
                                    </td>
                                    <td>10:30</td>
                                    <td><span class="badge badge-warning">Berlangsung</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" title="Monitor">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" title="Kirim Pesan">
                                            <i class="fas fa-comment"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Siti Nurhaliza</td>
                                    <td>XII IPS 2</td>
                                    <td>Gardner Multiple Intelligence</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: 100%">100%</div>
                                        </div>
                                    </td>
                                    <td>10:15</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" title="Lihat Hasil">
                                            <i class="fas fa-chart-bar"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary" title="Download">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Budi Santoso</td>
                                    <td>XII TKJ 1</td>
                                    <td>Holland RIASEC</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: 45%">45%</div>
                                        </div>
                                    </td>
                                    <td>10:45</td>
                                    <td><span class="badge badge-warning">Berlangsung</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" title="Monitor">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" title="Kirim Pesan">
                                            <i class="fas fa-comment"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sesi Tes -->
<div class="modal fade" id="modalSesiTes" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-play"></i> Mulai Sesi Tes Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Tes</label>
                            <select class="form-select" required>
                                <option value="">Pilih jenis tes...</option>
                                <option value="holland">Holland RIASEC</option>
                                <option value="gardner">Gardner Multiple Intelligence</option>
                                <option value="mbti">MBTI Personality</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kelas/Grup</label>
                            <select class="form-select" required>
                                <option value="">Pilih kelas...</option>
                                <option value="xii-ipa-1">XII IPA 1</option>
                                <option value="xii-ipa-2">XII IPA 2</option>
                                <option value="xii-ips-1">XII IPS 1</option>
                                <option value="xii-ips-2">XII IPS 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Durasi (menit)</label>
                            <input type="number" class="form-control" value="60" min="15" max="180">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batas Waktu</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instruksi Khusus</label>
                        <textarea class="form-control" rows="3" placeholder="Instruksi tambahan untuk siswa..."></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="allowRetake">
                        <label class="form-check-label" for="allowRetake">
                            Izinkan mengulang tes
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success">
                    <i class="fas fa-play"></i> Mulai Sesi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Jenis Tes -->
<div class="modal fade" id="modalTambahJenisTes" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus"></i> Tambah Jenis Tes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Nama Tes</label>
                        <input type="text" class="form-control" placeholder="Contoh: Tes Gaya Belajar VAK">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select">
                            <option>Pilih kategori...</option>
                            <option>Tes Bakat</option>
                            <option>Tes Minat</option>
                            <option>Tes Kepribadian</option>
                            <option>Tes Gaya Belajar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durasi Default (menit)</label>
                        <input type="number" class="form-control" value="45">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
function editTes(jenis) {
    alert('Edit tes ' + jenis);
}

function mulaiTes(jenis) {
    if(confirm('Mulai sesi tes ' + jenis + ' untuk siswa?')) {
        alert('Sesi tes ' + jenis + ' dimulai!');
    }
}

// Auto refresh status setiap 30 detik
setInterval(function() {
    // Simulasi update status real-time
    console.log('Refresh status siswa...');
}, 30000);
</script>
