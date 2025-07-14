<?= $this->extend('layouts/minimal_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">
                    <h2><i class="fas fa-journal-whills"></i> Jurnal Digital & Pelacak Emosi</h2>
                </div>
                <div class="card-body">
                    <p class="lead">Catat perasaan dan pengalaman harian Anda untuk membantu proses konseling</p>
                    
                    <form id="journalForm" class="mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="journalDate" class="form-label">Tanggal</label>
                                    <input type="date" id="journalDate" class="form-control" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Bagaimana perasaan Anda hari ini?</label>
                            <div class="d-flex gap-2 flex-wrap justify-content-center my-3 p-3 bg-light rounded">
                                <button type="button" class="btn btn-outline-warning mood-btn" data-mood="sangat-senang" title="Sangat Senang" style="font-size: 2rem;">😊</button>
                                <button type="button" class="btn btn-outline-warning mood-btn" data-mood="senang" title="Senang" style="font-size: 2rem;">🙂</button>
                                <button type="button" class="btn btn-outline-warning mood-btn" data-mood="biasa" title="Biasa" style="font-size: 2rem;">😐</button>
                                <button type="button" class="btn btn-outline-warning mood-btn" data-mood="sedih" title="Sedih" style="font-size: 2rem;">😔</button>
                                <button type="button" class="btn btn-outline-warning mood-btn" data-mood="sangat-sedih" title="Sangat Sedih" style="font-size: 2rem;">😭</button>
                                <button type="button" class="btn btn-outline-warning mood-btn" data-mood="cemas" title="Cemas" style="font-size: 2rem;">😰</button>
                                <button type="button" class="btn btn-outline-warning mood-btn" data-mood="marah" title="Marah" style="font-size: 2rem;">😠</button>
                            </div>
                            <input type="hidden" id="selectedMood">
                        </div>
                        
                        <div class="mb-3">
                            <label for="journalTitle" class="form-label">Judul Jurnal</label>
                            <input type="text" id="journalTitle" class="form-control" placeholder="Beri judul untuk hari ini...">
                        </div>
                        
                        <div class="mb-3">
                            <label for="journalContent" class="form-label">Ceritakan hari Anda</label>
                            <textarea id="journalContent" class="form-control" rows="6" placeholder="Apa yang terjadi hari ini? Bagaimana perasaan Anda? Ceritakan di sini..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tag Emosi (Opsional)</label>
                            <div class="d-flex gap-1 flex-wrap">
                                <button type="button" class="btn btn-sm btn-outline-secondary tag-btn" data-tag="bahagia">Bahagia</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary tag-btn" data-tag="sedih">Sedih</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary tag-btn" data-tag="cemas">Cemas</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary tag-btn" data-tag="stres">Stres</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary tag-btn" data-tag="optimis">Optimis</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary tag-btn" data-tag="lelah">Lelah</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary tag-btn" data-tag="bersemangat">Bersemangat</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary tag-btn" data-tag="bingung">Bingung</button>
                            </div>
                            <input type="hidden" id="selectedTags">
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="shareWithBK">
                                <label class="form-check-label" for="shareWithBK">
                                    <strong>Bagikan dengan Guru BK</strong> (untuk membantu sesi konseling)
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-save"></i> Simpan Jurnal
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="showPreview()">
                                <i class="fas fa-eye"></i> Preview
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- BK Support Cards -->
    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-comments fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Konsultasi Cepat</h5>
                    <p class="card-text">Chat langsung dengan Guru BK untuk dukungan segera</p>
                    <a href="<?= base_url('safe-space/konsul-cepat') ?>" class="btn btn-warning">Chat dengan BK</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Jadwal Konseling</h5>
                    <p class="card-text">Atur sesi konseling pribadi dengan Guru BK</p>
                    <a href="<?= base_url('safe-space/jadwal-konseling') ?>" class="btn btn-warning">Jadwalkan Sesi</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-info-circle fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Pusat Informasi</h5>
                    <p class="card-text">Informasi dan bantuan untuk kesehatan mental</p>
                    <a href="<?= base_url('safe-space/pusat-informasi') ?>" class="btn btn-warning">Lihat Info</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('journalForm');
    
    // Mood selector functionality
    const moodButtons = document.querySelectorAll('.mood-btn');
    const selectedMoodInput = document.getElementById('selectedMood');
    
    moodButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            moodButtons.forEach(b => {
                b.classList.remove('btn-warning');
                b.classList.add('btn-outline-warning');
            });
            this.classList.remove('btn-outline-warning');
            this.classList.add('btn-warning');
            selectedMoodInput.value = this.dataset.mood;
        });
    });
    
    // Emotion tags functionality
    const tagButtons = document.querySelectorAll('.tag-btn');
    const selectedTagsInput = document.getElementById('selectedTags');
    let selectedTags = [];
    
    tagButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const tag = this.dataset.tag;
            
            if (this.classList.contains('btn-secondary')) {
                this.classList.remove('btn-secondary');
                this.classList.add('btn-outline-secondary');
                selectedTags = selectedTags.filter(t => t !== tag);
            } else {
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-secondary');
                selectedTags.push(tag);
            }
            
            selectedTagsInput.value = selectedTags.join(',');
        });
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            date: document.getElementById('journalDate').value,
            mood: selectedMoodInput.value,
            title: document.getElementById('journalTitle').value,
            content: document.getElementById('journalContent').value,
            emotionTags: selectedTagsInput.value,
            shareWithBK: document.getElementById('shareWithBK').checked
        };
        
        if (!formData.title || !formData.content || !formData.mood) {
            alert('Mohon lengkapi judul, isi jurnal, dan pilih mood Anda!');
            return;
        }
        
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        submitBtn.disabled = true;
        
        setTimeout(() => {
            alert('Jurnal berhasil disimpan!' + (formData.shareWithBK ? ' Data akan dibagikan dengan Guru BK untuk membantu sesi konseling.' : ''));
            
            // Reset form
            form.reset();
            document.getElementById('journalDate').value = new Date().toISOString().split('T')[0];
            
            // Reset mood and tags
            moodButtons.forEach(b => {
                b.classList.remove('btn-warning');
                b.classList.add('btn-outline-warning');
            });
            tagButtons.forEach(b => {
                b.classList.remove('btn-secondary');
                b.classList.add('btn-outline-secondary');
            });
            selectedTags = [];
            selectedMoodInput.value = '';
            selectedTagsInput.value = '';
            
            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 1500);
    });
});

function showPreview() {
    const title = document.getElementById('journalTitle').value;
    const content = document.getElementById('journalContent').value;
    const mood = document.getElementById('selectedMood').value;
    const tags = document.getElementById('selectedTags').value;
    
    if (!title || !content) {
        alert('Mohon isi judul dan konten jurnal untuk preview');
        return;
    }
    
    const preview = `
        <h3>${title}</h3>
        <p><strong>Mood:</strong> ${mood || 'Belum dipilih'}</p>
        <p><strong>Tags:</strong> ${tags || 'Tidak ada'}</p>
        <div style="margin-top: 15px;">${content.replace(/\n/g, '<br>')}</div>
    `;
    
    const newWindow = window.open('', '_blank', 'width=600,height=400');
    newWindow.document.write(`
        <html>
            <head><title>Preview Jurnal</title></head>
            <body style="font-family: Arial, sans-serif; padding: 20px;">
                ${preview}
            </body>
        </html>
    `);
}
</script>
<?= $this->endSection() ?>
