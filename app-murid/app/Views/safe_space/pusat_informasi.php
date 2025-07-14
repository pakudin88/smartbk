<?= $this->extend('layouts/minimal_layout') ?>

<?= $this->section('title') ?>
<?= $title ?? 'Pusat Informasi & Bantuan' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style> html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Pusat Informasi & Bantuan' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e8f5e8 0%, #e3f2fd 25%, #f3e5f5 50%, #fff3e0 75%, #e1f5fe 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 900px;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(156, 39, 176, 0.1);
            margin: 2rem 0;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background: linear-gradient(135deg, #9c27b0 0%, #ba68c8 100%);
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
        
        .info-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #9c27b0;
            transition: all 0.3s ease;
        }
        
        .info-card:hover {
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 8px 25px rgba(156, 39, 176, 0.15);
        }
        
        .category-btn {
            background: rgba(156, 39, 176, 0.1);
            border: 2px solid rgba(156, 39, 176, 0.2);
            color: #9c27b0;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            margin: 0.25rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .category-btn:hover,
        .category-btn.active {
            background: linear-gradient(135deg, #9c27b0 0%, #ba68c8 100%);
            color: white;
            border-color: #9c27b0;
        }
        
        .search-box {
            border-radius: 25px;
            border: 2px solid rgba(156, 39, 176, 0.2);
            padding: 0.75rem 1.5rem;
            margin-bottom: 2rem;
        }
        
        .search-box:focus {
            border-color: #9c27b0;
            box-shadow: 0 0 0 0.2rem rgba(156, 39, 176, 0.25);
        }
        
        .emergency-card {
            background: linear-gradient(135deg, #f44336 0%, #ef5350 100%);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .emergency-card .btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            margin: 0.5rem;
        }
        
        .emergency-card .btn:hover {
            background: white;
            color: #f44336;
        }
        
        .resource-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .resource-item {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid rgba(156, 39, 176, 0.1);
        }
        
        .resource-item:hover {
            background: rgba(255, 255, 255, 1);
            border-color: #9c27b0;
            transform: translateY(-3px);
        }
        
        .resource-icon {
            font-size: 2.5rem;
            color: #9c27b0;
            margin-bottom: 1rem;
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
        <!-- Header -->
        <div class="card">
            <div class="card-header">
                <div class="feature-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h2 class="mb-0">Pusat Informasi & Bantuan</h2>
                <p class="mb-0 mt-2">Artikel, video, tips untuk kesehatan mental</p>
            </div>
        </div>
        
        <!-- Emergency Help -->
        <div class="emergency-card">
            <h4><i class="fas fa-exclamation-triangle me-2"></i>Butuh Bantuan Darurat?</h4>
            <p class="mb-3">Jika kamu merasa dalam bahaya atau memiliki pikiran untuk menyakiti diri sendiri, segera hubungi:</p>
            <div>
                <button class="btn" onclick="window.open('tel:119', '_blank')">
                    <i class="fas fa-phone me-2"></i>119 - Emergency
                </button>
                <button class="btn" onclick="window.open('https://pijar.kemkes.go.id/', '_blank')">
                    <i class="fas fa-comments me-2"></i>Sehat Jiwa
                </button>
                <button class="btn" onclick="window.open('https://www.halodoc.com/', '_blank')">
                    <i class="fas fa-user-md me-2"></i>Konsultasi Online
                </button>
            </div>
        </div>
        
        <!-- Search -->
        <div class="mb-4">
            <input type="text" class="form-control search-box" placeholder="🔍 Cari artikel, tips, atau informasi..." id="searchBox">
        </div>
        
        <!-- Categories -->
        <div class="text-center mb-4">
            <button class="category-btn active" data-category="all" onclick="filterContent('all')">Semua</button>
            <button class="category-btn" data-category="stress" onclick="filterContent('stress')">Stres & Kecemasan</button>
            <button class="category-btn" data-category="social" onclick="filterContent('social')">Hubungan Sosial</button>
            <button class="category-btn" data-category="academic" onclick="filterContent('academic')">Akademik</button>
            <button class="category-btn" data-category="selfcare" onclick="filterContent('selfcare')">Self-Care</button>
            <button class="category-btn" data-category="bullying" onclick="filterContent('bullying')">Bullying</button>
        </div>
        
        <!-- Content Grid -->
        <div class="resource-grid" id="contentGrid">
            <!-- Will be populated by JavaScript -->
        </div>
        
        <!-- Quick Resources -->
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);">
                <h5 class="mb-0">
                    <i class="fas fa-heart me-2"></i>
                    Sumber Bantuan Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="resource-grid">
                    <div class="resource-item">
                        <div class="resource-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h6>Hotline Kesehatan Mental</h6>
                        <p>500-454: Halo Kemkes (24 jam)</p>
                        <p>119: Emergency</p>
                    </div>
                    <div class="resource-item">
                        <div class="resource-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h6>Website Kesehatan Mental</h6>
                        <p>SehatJiwa.kemkes.go.id</p>
                        <p>IntoTheLight.id</p>
                    </div>
                    <div class="resource-item">
                        <div class="resource-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h6>Aplikasi Mobile</h6>
                        <p>Riliv - Konseling Online</p>
                        <p>Calm - Meditasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        // Sample content data
        const contentData = [
            {
                id: 1,
                title: "5 Cara Mengatasi Stres Saat Ujian",
                category: "stress",
                type: "article",
                description: "Tips praktis untuk mengelola stres dan kecemasan menjelang ujian",
                icon: "fas fa-graduation-cap",
                readTime: "5 menit"
            },
            {
                id: 2,
                title: "Mengenali Tanda-tanda Bullying",
                category: "bullying",
                type: "article",
                description: "Cara mengidentifikasi dan menghadapi bullying di sekolah",
                icon: "fas fa-shield-alt",
                readTime: "8 menit"
            },
            {
                id: 3,
                title: "Teknik Pernapasan untuk Menenangkan Diri",
                category: "selfcare",
                type: "video",
                description: "Video panduan teknik pernapasan yang bisa dilakukan kapan saja",
                icon: "fas fa-play-circle",
                readTime: "10 menit"
            },
            {
                id: 4,
                title: "Membangun Kepercayaan Diri",
                category: "social",
                type: "article",
                description: "Langkah-langkah praktis untuk meningkatkan rasa percaya diri",
                icon: "fas fa-heart",
                readTime: "6 menit"
            },
            {
                id: 5,
                title: "Cara Belajar Efektif Tanpa Stres",
                category: "academic",
                type: "article",
                description: "Metode belajar yang efisien dan tidak menimbulkan stres berlebihan",
                icon: "fas fa-book",
                readTime: "7 menit"
            },
            {
                id: 6,
                title: "Mindfulness untuk Remaja",
                category: "selfcare",
                type: "video",
                description: "Pengenalan mindfulness dan meditasi sederhana untuk remaja",
                icon: "fas fa-om",
                readTime: "15 menit"
            },
            {
                id: 7,
                title: "Mengatasi Konflik dengan Teman",
                category: "social",
                type: "article",
                description: "Tips komunikasi yang baik untuk menyelesaikan konflik pertemanan",
                icon: "fas fa-handshake",
                readTime: "5 menit"
            },
            {
                id: 8,
                title: "Tanda-tanda Kamu Perlu Istirahat",
                category: "stress",
                type: "article",
                description: "Mengenali kapan tubuh dan pikiran membutuhkan istirahat",
                icon: "fas fa-bed",
                readTime: "4 menit"
            }
        ];
        
        let currentFilter = 'all';
        
        function renderContent(filter = 'all') {
            const grid = document.getElementById('contentGrid');
            let filteredContent = contentData;
            
            if (filter !== 'all') {
                filteredContent = contentData.filter(item => item.category === filter);
            }
            
            grid.innerHTML = filteredContent.map(item => `
                <div class="info-card" data-category="${item.category}">
                    <div class="d-flex align-items-start mb-3">
                        <div class="resource-icon me-3">
                            <i class="${item.icon}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-2">${item.title}</h5>
                            <p class="text-muted mb-2">${item.description}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">${getCategoryName(item.category)}</span>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>${item.readTime}
                                </small>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-primary btn-sm w-100" onclick="openContent(${item.id})">
                        <i class="fas fa-${item.type === 'video' ? 'play' : 'book-open'} me-2"></i>
                        ${item.type === 'video' ? 'Tonton Video' : 'Baca Artikel'}
                    </button>
                </div>
            `).join('');
        }
        
        function getCategoryName(category) {
            const categories = {
                'stress': 'Stres & Kecemasan',
                'social': 'Hubungan Sosial', 
                'academic': 'Akademik',
                'selfcare': 'Self-Care',
                'bullying': 'Bullying'
            };
            return categories[category] || category;
        }
        
        function filterContent(category) {
            currentFilter = category;
            
            // Update active button
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`[data-category="${category}"]`).classList.add('active');
            
            // Render filtered content
            renderContent(category);
        }
        
        function openContent(contentId) {
            const content = contentData.find(item => item.id === contentId);
            if (content) {
                // Simulate opening content
                alert(`Membuka: ${content.title}\n\nDalam implementasi nyata, ini akan membuka halaman detail dengan konten lengkap.`);
            }
        }
        
        // Search functionality
        document.getElementById('searchBox').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.info-card');
            
            cards.forEach(card => {
                const title = card.querySelector('h5').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Initialize content
        document.addEventListener('DOMContentLoaded', function() {
            renderContent();
            
            // Fix URLs
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
