<?= $this->extend('layouts/simple_layout') ?>

<?= $this->section('title') ?>
<?= $title ?? 'Jadwalkan Sesi Konseling' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
        body {
            background: linear-gradient(135deg, #e8f5e8 0%, #e3f2fd 25%, #f3e5f5 50%, #fff3e0 75%, #e1f5fe 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 800px;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(25, 118, 210, 0.1);
            margin: 2rem 0;
        }
        
        .card-header {
            background: linear-gradient(135deg, #2196f3 0%, #42a5f5 100%);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 2rem;
            text-align: center;
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: white;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2196f3 0%, #42a5f5 100%);
            border: none;
            border-radius: 15px;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }
        
        .form-control {
            border-radius: 15px;
            border: 2px solid rgba(33, 150, 243, 0.1);
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Back Button -->
    <a href="<?= base_url('dashboard') ?>" class="btn-back">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Dashboard
    </a>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="feature-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h2 class="mb-0">Jadwalkan Sesi Konseling</h2>
                <p class="mb-0 mt-2">Atur jadwal konseling tatap muka atau online dengan Guru BK</p>
            </div>
            <div class="card-body p-4">
                <form id="schedulingForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="counselingType" class="form-label fw-bold">Jenis Konseling</label>
                            <select class="form-control" id="counselingType" required>
                                <option value="">Pilih jenis konseling</option>
                                <option value="individual">Konseling Individual</option>
                                <option value="group">Konseling Kelompok</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sessionMode" class="form-label fw-bold">Mode Sesi</label>
                            <select class="form-control" id="sessionMode" required>
                                <option value="">Pilih mode sesi</option>
                                <option value="online">Online (Video Call)</option>
                                <option value="offline">Tatap Muka</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="preferredDate" class="form-label fw-bold">Tanggal Preferensi</label>
                            <input type="date" class="form-control" id="preferredDate" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="preferredTime" class="form-label fw-bold">Waktu Preferensi</label>
                            <select class="form-control" id="preferredTime" required>
                                <option value="">Pilih waktu</option>
                                <option value="08:00">08:00 - 09:00</option>
                                <option value="09:00">09:00 - 10:00</option>
                                <option value="10:00">10:00 - 11:00</option>
                                <option value="11:00">11:00 - 12:00</option>
                                <option value="13:00">13:00 - 14:00</option>
                                <option value="14:00">14:00 - 15:00</option>
                                <option value="15:00">15:00 - 16:00</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="topic" class="form-label fw-bold">Topik/Keluhan</label>
                        <textarea class="form-control" id="topic" rows="4" placeholder="Jelaskan secara singkat topik atau masalah yang ingin dibahas..." required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="urgencyLevel" class="form-label fw-bold">Tingkat Urgensi</label>
                        <select class="form-control" id="urgencyLevel" required>
                            <option value="">Pilih tingkat urgensi</option>
                            <option value="low">Rendah - Dapat menunggu</option>
                            <option value="medium">Sedang - Dalam beberapa hari</option>
                            <option value="high">Tinggi - Sesegera mungkin</option>
                        </select>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-plus me-2"></i>
                            Ajukan Jadwal Konseling
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Available Slots Info -->
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Jadwal Tersedia Minggu Ini
                </h5>
            </div>
            <div class="card-body">
                <div class="row" id="availableSlots">
                    <div class="col-md-4 mb-3">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <h6 class="text-success">Senin, 15 Juli</h6>
                                <p class="mb-1">09:00 - 10:00</p>
                                <p class="mb-1">14:00 - 15:00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-warning">
                            <div class="card-body text-center">
                                <h6 class="text-warning">Rabu, 17 Juli</h6>
                                <p class="mb-1">10:00 - 11:00</p>
                                <p class="mb-1">15:00 - 16:00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-info">
                            <div class="card-body text-center">
                                <h6 class="text-info">Jumat, 19 Juli</h6>
                                <p class="mb-1">08:00 - 09:00</p>
                                <p class="mb-1">13:00 - 14:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set minimum date to today
        document.getElementById('preferredDate').min = new Date().toISOString().split('T')[0];
        
        // Handle form submission
        document.getElementById('schedulingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Add form data to object
            data.counselingType = document.getElementById('counselingType').value;
            data.sessionMode = document.getElementById('sessionMode').value;
            data.preferredDate = document.getElementById('preferredDate').value;
            data.preferredTime = document.getElementById('preferredTime').value;
            data.topic = document.getElementById('topic').value;
            data.urgencyLevel = document.getElementById('urgencyLevel').value;
            
            // Simulate API call
            submitScheduleRequest(data);
        });
        
        function submitScheduleRequest(data) {
            // Show loading state
            const btn = document.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
            
            // Simulate API delay
            setTimeout(() => {
                // Success response
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check me-2"></i>Berhasil Dikirim!';
                btn.className = 'btn btn-success btn-lg';
                
                // Show success message
                alert('Jadwal konseling berhasil diajukan! Guru BK akan menghubungi Anda dalam 1x24 jam untuk konfirmasi.');
                
                // Reset form after 3 seconds
                setTimeout(() => {
                    document.getElementById('schedulingForm').reset();
                    btn.innerHTML = originalText;
                    btn.className = 'btn btn-primary btn-lg';
                }, 3000);
                
            }, 2000);
        }
        
        // Add URL fixing for navigation
        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = '<?= $current_url ?? '' ?>';
            if (currentUrl) {
                const links = document.querySelectorAll('a[href^="/"]');
                links.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href.startsWith('/')) {
                        link.setAttribute('href', currentUrl + href);
                    }
                });
            }
        });
    </script>
<?= $this->endSection() ?>
