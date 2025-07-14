<?= $this->extend('layouts/minimal_layout') ?>

<?= $this->section('content') ?>
<style>
/* Mobile-First Design - Safe Space Style */
.safe-space-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #e8f4f8 0%, #f3e5f5 50%, #fff3e0 100%);
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.mobile-header {
    background: linear-gradient(135deg, #4a90e2 0%, #7b68ee 100%);
    color: white;
    padding: 1rem 0;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.time-display {
    font-size: 2rem;
    font-weight: 300;
    margin-bottom: 0.5rem;
}

.date-display {
    font-size: 0.9rem;
    opacity: 0.9;
}

.app-title {
    background: white;
    padding: 1rem;
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
    color: #4a5568;
    text-align: center;
    border-bottom: 1px solid #e2e8f0;
}

.apps-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    padding: 2rem 1.5rem;
    max-width: 500px;
    margin: 0 auto;
}

.app-card {
    background: white;
    border-radius: 20px;
    padding: 2rem 1.5rem;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    cursor: pointer;
    border: 1px solid rgba(0,0,0,0.05);
}

.app-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.app-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.8rem;
    color: white;
}

.app-icon.konsul { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); }
.app-icon.jadwal { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.app-icon.jurnal { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
.app-icon.informasi { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }

.app-title-text {
    font-size: 1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.app-description {
    font-size: 0.8rem;
    color: #718096;
    line-height: 1.4;
    margin: 0;
}

.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border-radius: 25px 25px 0 0;
    box-shadow: 0 -2px 20px rgba(0,0,0,0.1);
    padding: 1rem 2rem;
    display: flex;
    gap: 2rem;
    align-items: center;
    min-width: 300px;
    justify-content: center;
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: #a0aec0;
    transition: color 0.3s ease;
    padding: 0.5rem;
}

.nav-item.active,
.nav-item:hover {
    color: #4a90e2;
}

.nav-item i {
    font-size: 1.2rem;
    margin-bottom: 0.25rem;
}

.nav-item span {
    font-size: 0.7rem;
    font-weight: 500;
}

/* Journal Modal Styles */
.journal-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    animation: fadeIn 0.3s ease;
}

.journal-content {
    background: white;
    margin: 2rem;
    border-radius: 20px;
    padding: 2rem;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
}

.close-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #a0aec0;
    cursor: pointer;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1.5rem;
    text-align: center;
}

.mood-selector {
    margin-bottom: 2rem;
}

.mood-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 1rem;
    display: block;
}

.mood-options {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.mood-btn {
    font-size: 2.5rem;
    background: none;
    border: 3px solid #e2e8f0;
    border-radius: 50%;
    width: 70px;
    height: 70px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mood-btn:hover,
.mood-btn.selected {
    border-color: #4a90e2;
    background: rgba(74, 144, 226, 0.1);
    transform: scale(1.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #4a90e2;
}

.form-control.textarea {
    min-height: 120px;
    resize: vertical;
    font-family: inherit;
}

.emotion-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.tag-btn {
    padding: 0.5rem 1rem;
    border: 2px solid #e2e8f0;
    background: white;
    border-radius: 20px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #64748b;
}

.tag-btn:hover,
.tag-btn.selected {
    background: #4a90e2;
    border-color: #4a90e2;
    color: white;
}

.save-btn {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #4a90e2 0%, #7b68ee 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.3s ease;
    margin-top: 1rem;
}

.save-btn:hover {
    transform: translateY(-2px);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Responsive adjustments */
@media (max-width: 480px) {
    .apps-grid {
        padding: 1.5rem 1rem;
        gap: 1rem;
    }
    
    .app-card {
        padding: 1.5rem 1rem;
    }
    
    .journal-content {
        margin: 1rem;
        padding: 1.5rem;
    }
    
    .bottom-nav {
        min-width: 100%;
        border-radius: 0;
        padding: 1rem;
    }
}
</style>

<div class="safe-space-container">
    <!-- Mobile Header -->
    <div class="mobile-header">
        <div class="time-display"><?= date('H:i') ?></div>
        <div class="date-display">
            <?= strftime('%A', strtotime('today')) ?>
            <br><?= date('d') ?> <?= strftime('%B %Y') ?>
        </div>
    </div>
    
    <!-- App Title -->
    <div class="app-title">RUANG AMAN</div>
    
    <!-- Apps Grid -->
    <div class="apps-grid">
        <div class="app-card" onclick="openJournalModal()">
            <div class="app-icon jurnal">
                <i class="fas fa-journal-whills"></i>
            </div>
            <div class="app-title-text">Jurnal Digital & Pelacak Emosi</div>
            <p class="app-description">Catat perasaan dan lacak mood setiap hari</p>
        </div>
        
        <div class="app-card" onclick="window.location.href='<?= base_url('safe-space/konsul-cepat') ?>'">
            <div class="app-icon konsul">
                <i class="fas fa-comments"></i>
            </div>
            <div class="app-title-text">Konsul Cepat & Anonim</div>
            <p class="app-description">Chat langsung dengan Guru BK, bisa anonim</p>
        </div>
        
        <div class="app-card" onclick="window.location.href='<?= base_url('safe-space/jadwal-konseling') ?>'">
            <div class="app-icon jadwal">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="app-title-text">Jadwalkan Sesi Konseling</div>
            <p class="app-description">Atur jadwal konseling tatap muka atau online</p>
        </div>
        
        <div class="app-card" onclick="window.location.href='<?= base_url('safe-space/pusat-informasi') ?>'">
            <div class="app-icon informasi">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="app-title-text">Pusat Informasi & Bantuan</div>
            <p class="app-description">Artikel, video, tips untuk kesehatan mental</p>
        </div>
    </div>
</div>

<!-- Bottom Navigation -->
<div class="bottom-nav">
    <a href="<?= base_url('dashboard') ?>" class="nav-item">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="#" class="nav-item" onclick="openJournalModal()">
        <i class="fas fa-comments"></i>
        <span>Chat</span>
    </a>
    <a href="#" class="nav-item active" onclick="openJournalModal()">
        <i class="fas fa-heart"></i>
        <span>Jurnal</span>
    </a>
    <a href="<?= base_url('logout') ?>" class="nav-item">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
</div>

<!-- Journal Modal -->
<div id="journalModal" class="journal-modal">
    <div class="journal-content">
        <button class="close-btn" onclick="closeJournalModal()">&times;</button>
        
        <h3 class="modal-title">Jurnal Digital & Mood Tracker</h3>
        
        <form id="journalForm">
            <div class="mood-selector">
                <label class="mood-label">Bagaimana perasaan Anda hari ini?</label>
                <div class="mood-options">
                    <button type="button" class="mood-btn" data-mood="sangat-senang" title="Sangat Senang">😊</button>
                    <button type="button" class="mood-btn" data-mood="senang" title="Senang">🙂</button>
                    <button type="button" class="mood-btn" data-mood="biasa" title="Biasa">😐</button>
                    <button type="button" class="mood-btn" data-mood="sedih" title="Sedih">😔</button>
                    <button type="button" class="mood-btn" data-mood="sangat-sedih" title="Sangat Sedih">😢</button>
                    <button type="button" class="mood-btn" data-mood="cemas" title="Cemas">😰</button>
                    <button type="button" class="mood-btn" data-mood="marah" title="Marah">😠</button>
                </div>
                <input type="hidden" id="selectedMood">
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
                <label class="form-label">Tag Emosi (Opsional)</label>
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
            
            <button type="submit" class="save-btn">
                <i class="fas fa-save"></i> Simpan Jurnal
            </button>
        </form>
    </div>
</div>

<script>
// Journal Modal Functions
function openJournalModal() {
    document.getElementById('journalModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeJournalModal() {
    document.getElementById('journalModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Initialize when page loads
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
            mood: selectedMoodInput.value,
            title: document.getElementById('journalTitle').value,
            content: document.getElementById('journalContent').value,
            emotionTags: selectedTagsInput.value,
            shareWithBK: document.getElementById('shareWithBK').checked
        };
        
        if (!formData.title || !formData.content || !formData.mood) {
            showAlert('Mohon lengkapi judul, isi jurnal, dan pilih mood Anda!', 'warning');
            return;
        }
        
        // Show loading
        const submitBtn = form.querySelector('.save-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        submitBtn.disabled = true;
        
        // Simulate save
        setTimeout(() => {
            showAlert('Jurnal berhasil disimpan! ' + (formData.shareWithBK ? 'Data akan dibagikan dengan Guru BK.' : ''), 'success');
            
            // Reset form
            form.reset();
            moodButtons.forEach(b => b.classList.remove('selected'));
            tagButtons.forEach(b => b.classList.remove('selected'));
            selectedTags = [];
            selectedMoodInput.value = '';
            selectedTagsInput.value = '';
            
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            
            // Close modal
            setTimeout(() => {
                closeJournalModal();
            }, 1500);
        }, 1500);
    });
    
    // Close modal when clicking outside
    document.getElementById('journalModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeJournalModal();
        }
    });
});

function showAlert(message, type = 'info') {
    const alert = document.createElement('div');
    alert.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : type === 'warning' ? '#f59e0b' : '#3b82f6'};
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 1001;
        max-width: 300px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    `;
    alert.innerHTML = message;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 4000);
}
</script>
<?= $this->endSection() ?>
