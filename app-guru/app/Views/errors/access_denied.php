<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-lock fa-4x text-warning"></i>
                    </div>
                    <h2 class="text-warning mb-3">Akses Terbatas</h2>
                    <p class="lead text-muted mb-4">
                        Fitur <strong>Asesmen Bakat Minat</strong> khusus untuk Guru BK (Bimbingan Konseling).
                    </p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Asesmen bakat minat merupakan layanan khusus yang diberikan oleh Guru BK untuk membantu siswa dalam menentukan pilihan jurusan dan karir sesuai dengan bakat dan minat mereka.
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <i class="fas fa-brain fa-2x text-primary mb-2"></i>
                                    <h6>Tes Bakat Minat</h6>
                                    <small class="text-muted">Holland, Gardner, MBTI</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <i class="fas fa-chart-pie fa-2x text-success mb-2"></i>
                                    <h6>Analisis Hasil</h6>
                                    <small class="text-muted">Interpretasi & Grafik</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <i class="fas fa-lightbulb fa-2x text-warning mb-2"></i>
                                    <h6>Rekomendasi</h6>
                                    <small class="text-muted">Jurusan & Karir</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-muted">
                            Jika Anda memerlukan hasil asesmen bakat minat siswa, silakan hubungi Guru BK atau akses melalui menu yang sesuai dengan role Anda.
                        </p>
                        <a href="<?= base_url('/dashboard') ?>" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
}
.bg-light {
    background-color: #f8f9fa !important;
}
</style>
