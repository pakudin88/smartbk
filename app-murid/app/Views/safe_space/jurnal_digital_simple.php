<?= $this->extend('layouts/simple_layout') ?>

<?= $this->section('title') ?>
Jurnal Digital - Safe Space
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Jurnal Digital & Pelacak Emosi</h1>
        <p class="page-subtitle">Catat perasaan dan pengalaman harian Anda untuk membantu proses konseling</p>
    </div>
    
    <!-- Main Content -->
    <div class="content-layout">
        <!-- Journal Form -->
        <div class="journal-form-card">
            <h2 class="form-title">
                <i class="fas fa-journal-whills"></i>
                Jurnal Harian & Mood Tracker
            </h2>
            
            <form id="journalForm">
                <div class="form-group">
                    <label for="journalDate" class="form-label">Tanggal</label>
                    <input type="date" id="journalDate" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                
                <div class="form-group">
                    <label for="journalMood" class="form-label">Bagaimana perasaan Anda hari ini?</label>
                    <div class="mood-selector">
                        <div class="mood-options">
                            <button type="button" class="mood-btn" data-mood="sangat-senang" title="Sangat Senang">😊</button>
                            <button type="button" class="mood-btn" data-mood="senang" title="Senang">🙂</button>
                            <button type="button" class="mood-btn" data-mood="biasa" title="Biasa">😐</button>
                            <button type="button" class="mood-btn" data-mood="sedih" title="Sedih">😔</button>
                            <button type="button" class="mood-btn" data-mood="sangat-sedih" title="Sangat Sedih">😭</button>
                            <button type="button" class="mood-btn" data-mood="cemas" title="Cemas">😰</button>
                            <button type="button" class="mood-btn" data-mood="marah" title="Marah">😠</button>
                        </div>
                        <input type="hidden" id="selectedMood">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="journalTitle" class="form-label">Judul Jurnal</label>
                    <input type="text" id="journalTitle" class="form-control" placeholder="Beri judul untuk hari ini...">
                </div>
                
                <div class="form-group">
                    <label for="journalContent" class="form-label">Ceritakan hari Anda</label>
                    <textarea id="journalContent" class="form-control textarea" placeholder="Apa yang terjadi hari ini? Bagaimana perasaan Anda? Ceritakan di sini..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="emotionTags" class="form-label">Tag Emosi (Opsional)</label>
                    <div class="emotion-tags">
                        <button type="button" class="tag-btn" data-tag="bahagia">Bahagia</button>
                        <button type="button" class="tag-btn" data-tag="sedih">Sedih</button>
                        <button type="button" class="tag-btn" data-tag="cemas">Cemas</button>
                        <button type="button" class="tag-btn" data-tag="stres">Stres</button>
                        <button type="button" class="tag-btn" data-tag="optimis">Optimis</button>
                        <button type="button" class="tag-btn" data-tag="lelah">Lelah</button>
                        <button type="button" class="tag-btn" data-tag="bersemangat">Bersemangat</button>
                        <button type="button" class="tag-btn" data-tag="bingung">Bingung</button>
                    </div>
                    <input type="hidden" id="selectedTags">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" id="shareWithBK" style="margin-right: 8px;">
                        Bagikan dengan Guru BK (untuk membantu sesi konseling)
                    </label>
                </div>
                
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Jurnal
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="showPreview()">
                        <i class="fas fa-eye"></i>
                        Preview
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Basic styles */
.page-container {
    background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%);
    min-height: 100vh;
    padding: 2rem 1rem;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #ff9800;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    font-weight: 400;
}

.content-layout {
    max-width: 800px;
    margin: 0 auto;
}

.journal-form-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(100, 116, 139, 0.1);
    border: 1px solid rgba(203, 213, 225, 0.6);
}

.form-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-title i {
    color: #ff9800;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #ffffff;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #ff9800;
    box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
}

.form-control.textarea {
    min-height: 120px;
    resize: vertical;
    font-family: inherit;
}

.mood-options {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    justify-content: center;
    margin-bottom: 1rem;
}

.mood-btn {
    font-size: 2.5rem;
    background: none;
    border: 3px solid transparent;
    border-radius: 50%;
    padding: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mood-btn:hover {
    border-color: #ff9800;
    transform: scale(1.1);
    background: rgba(255, 152, 0, 0.1);
}

.mood-btn.selected {
    border-color: #ff9800;
    background: rgba(255, 152, 0, 0.2);
    transform: scale(1.1);
}

.emotion-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.tag-btn {
    padding: 0.5rem 1rem;
    border: 2px solid #e2e8f0;
    background: #ffffff;
    border-radius: 20px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #64748b;
}

.tag-btn:hover {
    border-color: #ff9800;
    color: #ff9800;
}

.tag-btn.selected {
    background: #ff9800;
    border-color: #ff9800;
    color: #ffffff;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #ff9800 0%, #ff6f00 100%);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 152, 0, 0.4);
}

.btn-secondary {
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #cbd5e1;
}

.btn-secondary:hover {
    background: #e2e8f0;
    color: #475569;
}

.btn-group {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .page-container {
        padding: 1.5rem 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .journal-form-card {
        padding: 1.5rem;
    }
    
    .btn-group {
        flex-direction: column;
    }
}
</style>
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
            moodButtons.forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
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
            
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedTags = selectedTags.filter(t => t !== tag);
            } else {
                this.classList.add('selected');
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
            alert('Jurnal berhasil disimpan! ' + (formData.shareWithBK ? 'Data akan dibagikan dengan Guru BK untuk membantu sesi konseling.' : ''));
            
            form.reset();
            document.getElementById('journalDate').value = new Date().toISOString().split('T')[0];
            
            moodButtons.forEach(b => b.classList.remove('selected'));
            tagButtons.forEach(b => b.classList.remove('selected'));
            selectedTags = [];
            selectedMoodInput.value = '';
            selectedTagsInput.value = '';
            
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
