<?php

namespace App\Libraries;

class MenuConfig
{
    /**
     * Get menu configuration based on user role
     */
    public static function getMenuByRole($role)
    {
        switch ($role) {
            case 'guru_bk':
                return self::getMenuGuruBK();
            case 'guru_kelas':
                return self::getMenuGuruKelas();
            case 'wali_kelas':
                return self::getMenuWaliKelas();
            case 'kepala_sekolah':
                return self::getMenuKepalaSekolah();
            default:
                return [];
        }
    }

    /**
     * Menu untuk Guru BK (Bimbingan Konseling)
     */
    private static function getMenuGuruBK()
    {
        return [
            [
                'title' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'url' => '/dashboard',
                'active' => true
            ],
            [
                'title' => 'Layanan Konseling',
                'icon' => 'fas fa-user-friends',
                'submenu' => [
                    [
                        'title' => 'Konseling Individual',
                        'icon' => 'fas fa-user',
                        'url' => '/konseling/individual'
                    ],
                    [
                        'title' => 'Konseling Kelompok',
                        'icon' => 'fas fa-users',
                        'url' => '/konseling/kelompok'
                    ],
                    [
                        'title' => 'Bimbingan Karir',
                        'icon' => 'fas fa-briefcase',
                        'url' => '/bimbingan-karir'
                    ],
                    [
                        'title' => 'Layanan Informasi',
                        'icon' => 'fas fa-info-circle',
                        'url' => '/layanan-informasi'
                    ]
                ]
            ],
            [
                'title' => 'Asesmen & Evaluasi',
                'icon' => 'fas fa-clipboard-list',
                'submenu' => [
                    [
                        'title' => 'Asesmen Siswa',
                        'icon' => 'fas fa-user-check',
                        'url' => '/asesmen/siswa'
                    ],
                    [
                        'title' => 'Test Psikologi',
                        'icon' => 'fas fa-brain',
                        'url' => '/asesmen/psikologi'
                    ],
                    [
                        'title' => 'Evaluasi Program',
                        'icon' => 'fas fa-chart-line',
                        'url' => '/evaluasi'
                    ]
                ]
            ],
            [
                'title' => 'Manajemen Kasus',
                'icon' => 'fas fa-folder-open',
                'submenu' => [
                    [
                        'title' => 'Kasus Aktif',
                        'icon' => 'fas fa-exclamation-triangle',
                        'url' => '/kasus/aktif'
                    ],
                    [
                        'title' => 'Kasus Selesai',
                        'icon' => 'fas fa-check-circle',
                        'url' => '/kasus/selesai'
                    ],
                    [
                        'title' => 'Follow Up',
                        'icon' => 'fas fa-redo',
                        'url' => '/kasus/follow-up'
                    ]
                ]
            ],
            [
                'title' => 'Data Siswa',
                'icon' => 'fas fa-database',
                'submenu' => [
                    [
                        'title' => 'Profil Siswa',
                        'icon' => 'fas fa-id-card',
                        'url' => '/siswa/profil'
                    ],
                    [
                        'title' => 'Riwayat Konseling',
                        'icon' => 'fas fa-history',
                        'url' => '/siswa/riwayat'
                    ],
                    [
                        'title' => 'Data Orang Tua',
                        'icon' => 'fas fa-user-friends',
                        'url' => '/siswa/orangtua'
                    ]
                ]
            ],
            [
                'title' => 'Laporan',
                'icon' => 'fas fa-file-alt',
                'submenu' => [
                    [
                        'title' => 'Laporan Bulanan',
                        'icon' => 'fas fa-calendar',
                        'url' => '/laporan/bulanan'
                    ],
                    [
                        'title' => 'Laporan Semester',
                        'icon' => 'fas fa-chart-bar',
                        'url' => '/laporan/semester'
                    ],
                    [
                        'title' => 'Export Data',
                        'icon' => 'fas fa-download',
                        'url' => '/laporan/export'
                    ]
                ]
            ]
        ];
    }

    /**
     * Menu untuk Guru Kelas
     */
    private static function getMenuGuruKelas()
    {
        return [
            [
                'title' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'url' => '/dashboard',
                'active' => true
            ],
            [
                'title' => 'Pembelajaran',
                'icon' => 'fas fa-chalkboard-teacher',
                'submenu' => [
                    [
                        'title' => 'Jadwal Mengajar',
                        'icon' => 'fas fa-calendar-alt',
                        'url' => '/pembelajaran/jadwal'
                    ],
                    [
                        'title' => 'Materi Pelajaran',
                        'icon' => 'fas fa-book',
                        'url' => '/pembelajaran/materi'
                    ],
                    [
                        'title' => 'Rencana Pembelajaran',
                        'icon' => 'fas fa-clipboard-list',
                        'url' => '/pembelajaran/rpp'
                    ]
                ]
            ],
            [
                'title' => 'Penilaian',
                'icon' => 'fas fa-edit',
                'submenu' => [
                    [
                        'title' => 'Input Nilai',
                        'icon' => 'fas fa-keyboard',
                        'url' => '/penilaian/input'
                    ],
                    [
                        'title' => 'Rekap Nilai',
                        'icon' => 'fas fa-table',
                        'url' => '/penilaian/rekap'
                    ],
                    [
                        'title' => 'Analisis Nilai',
                        'icon' => 'fas fa-chart-line',
                        'url' => '/penilaian/analisis'
                    ]
                ]
            ],
            [
                'title' => 'Tugas & Ujian',
                'icon' => 'fas fa-tasks',
                'submenu' => [
                    [
                        'title' => 'Buat Tugas',
                        'icon' => 'fas fa-plus',
                        'url' => '/tugas/buat'
                    ],
                    [
                        'title' => 'Kelola Tugas',
                        'icon' => 'fas fa-cog',
                        'url' => '/tugas/kelola'
                    ],
                    [
                        'title' => 'Bank Soal',
                        'icon' => 'fas fa-question-circle',
                        'url' => '/soal'
                    ]
                ]
            ],
            [
                'title' => 'Absensi',
                'icon' => 'fas fa-user-check',
                'submenu' => [
                    [
                        'title' => 'Absensi Harian',
                        'icon' => 'fas fa-calendar-day',
                        'url' => '/absensi/harian'
                    ],
                    [
                        'title' => 'Rekap Absensi',
                        'icon' => 'fas fa-chart-pie',
                        'url' => '/absensi/rekap'
                    ]
                ]
            ],
            [
                'title' => 'Data Kelas',
                'icon' => 'fas fa-school',
                'submenu' => [
                    [
                        'title' => 'Daftar Siswa',
                        'icon' => 'fas fa-list',
                        'url' => '/kelas/siswa'
                    ],
                    [
                        'title' => 'Profil Kelas',
                        'icon' => 'fas fa-info',
                        'url' => '/kelas/profil'
                    ]
                ]
            ],
            [
                'title' => 'Laporan',
                'icon' => 'fas fa-file-alt',
                'submenu' => [
                    [
                        'title' => 'Laporan Pembelajaran',
                        'icon' => 'fas fa-chart-bar',
                        'url' => '/laporan/pembelajaran'
                    ],
                    [
                        'title' => 'Laporan Nilai',
                        'icon' => 'fas fa-graduation-cap',
                        'url' => '/laporan/nilai'
                    ]
                ]
            ]
        ];
    }

    /**
     * Menu untuk Wali Kelas
     */
    private static function getMenuWaliKelas()
    {
        return [
            [
                'title' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'url' => '/dashboard',
                'active' => true
            ],
            [
                'title' => 'Data Siswa',
                'icon' => 'fas fa-users',
                'submenu' => [
                    [
                        'title' => 'Profil Siswa',
                        'icon' => 'fas fa-id-card',
                        'url' => '/siswa/profil'
                    ],
                    [
                        'title' => 'Data Pribadi',
                        'icon' => 'fas fa-user',
                        'url' => '/siswa/pribadi'
                    ],
                    [
                        'title' => 'Data Orang Tua',
                        'icon' => 'fas fa-user-friends',
                        'url' => '/siswa/orangtua'
                    ]
                ]
            ],
            [
                'title' => 'Monitoring Siswa',
                'icon' => 'fas fa-eye',
                'submenu' => [
                    [
                        'title' => 'Kehadiran Siswa',
                        'icon' => 'fas fa-calendar-check',
                        'url' => '/monitoring/kehadiran'
                    ],
                    [
                        'title' => 'Prestasi Akademik',
                        'icon' => 'fas fa-chart-line',
                        'url' => '/monitoring/prestasi'
                    ],
                    [
                        'title' => 'Perilaku Siswa',
                        'icon' => 'fas fa-user-check',
                        'url' => '/monitoring/perilaku'
                    ],
                    [
                        'title' => 'Siswa Bermasalah',
                        'icon' => 'fas fa-exclamation-triangle',
                        'url' => '/monitoring/bermasalah'
                    ]
                ]
            ],
            [
                'title' => 'Komunikasi',
                'icon' => 'fas fa-comments',
                'submenu' => [
                    [
                        'title' => 'Kontak Orang Tua',
                        'icon' => 'fas fa-phone',
                        'url' => '/komunikasi/orangtua'
                    ],
                    [
                        'title' => 'Rapat Orang Tua',
                        'icon' => 'fas fa-users',
                        'url' => '/komunikasi/rapat'
                    ],
                    [
                        'title' => 'Surat Menyurat',
                        'icon' => 'fas fa-envelope',
                        'url' => '/komunikasi/surat'
                    ]
                ]
            ],
            [
                'title' => 'Administrasi',
                'icon' => 'fas fa-folder',
                'submenu' => [
                    [
                        'title' => 'Buku Induk',
                        'icon' => 'fas fa-book',
                        'url' => '/administrasi/buku-induk'
                    ],
                    [
                        'title' => 'Catatan Khusus',
                        'icon' => 'fas fa-sticky-note',
                        'url' => '/administrasi/catatan'
                    ],
                    [
                        'title' => 'Dokumen Siswa',
                        'icon' => 'fas fa-file-alt',
                        'url' => '/administrasi/dokumen'
                    ]
                ]
            ],
            [
                'title' => 'Kegiatan Kelas',
                'icon' => 'fas fa-calendar-alt',
                'submenu' => [
                    [
                        'title' => 'Jadwal Kegiatan',
                        'icon' => 'fas fa-calendar',
                        'url' => '/kegiatan/jadwal'
                    ],
                    [
                        'title' => 'Ekstrakurikuler',
                        'icon' => 'fas fa-futbol',
                        'url' => '/kegiatan/ekskul'
                    ],
                    [
                        'title' => 'Event Kelas',
                        'icon' => 'fas fa-star',
                        'url' => '/kegiatan/event'
                    ]
                ]
            ],
            [
                'title' => 'Laporan',
                'icon' => 'fas fa-file-alt',
                'submenu' => [
                    [
                        'title' => 'Laporan Wali Kelas',
                        'icon' => 'fas fa-chart-bar',
                        'url' => '/laporan/wali-kelas'
                    ],
                    [
                        'title' => 'Laporan Kehadiran',
                        'icon' => 'fas fa-user-check',
                        'url' => '/laporan/kehadiran'
                    ],
                    [
                        'title' => 'Laporan Orang Tua',
                        'icon' => 'fas fa-family',
                        'url' => '/laporan/orangtua'
                    ]
                ]
            ]
        ];
    }

    /**
     * Menu untuk Kepala Sekolah
     */
    private static function getMenuKepalaSekolah()
    {
        return [
            [
                'title' => 'Dashboard Executive',
                'icon' => 'fas fa-tachometer-alt',
                'url' => '/dashboard',
                'active' => true
            ],
            [
                'title' => 'Manajemen Sekolah',
                'icon' => 'fas fa-school',
                'submenu' => [
                    [
                        'title' => 'Profil Sekolah',
                        'icon' => 'fas fa-building',
                        'url' => '/sekolah/profil'
                    ],
                    [
                        'title' => 'Visi & Misi',
                        'icon' => 'fas fa-bullseye',
                        'url' => '/sekolah/visi-misi'
                    ],
                    [
                        'title' => 'Struktur Organisasi',
                        'icon' => 'fas fa-sitemap',
                        'url' => '/sekolah/struktur'
                    ]
                ]
            ],
            [
                'title' => 'Manajemen SDM',
                'icon' => 'fas fa-users-cog',
                'submenu' => [
                    [
                        'title' => 'Data Guru',
                        'icon' => 'fas fa-chalkboard-teacher',
                        'url' => '/sdm/guru'
                    ],
                    [
                        'title' => 'Data Staff',
                        'icon' => 'fas fa-user-tie',
                        'url' => '/sdm/staff'
                    ],
                    [
                        'title' => 'Penilaian Kinerja',
                        'icon' => 'fas fa-star',
                        'url' => '/sdm/kinerja'
                    ],
                    [
                        'title' => 'Pengembangan SDM',
                        'icon' => 'fas fa-graduation-cap',
                        'url' => '/sdm/pengembangan'
                    ]
                ]
            ],
            [
                'title' => 'Akademik',
                'icon' => 'fas fa-graduation-cap',
                'submenu' => [
                    [
                        'title' => 'Kurikulum',
                        'icon' => 'fas fa-book-open',
                        'url' => '/akademik/kurikulum'
                    ],
                    [
                        'title' => 'Jadwal Pembelajaran',
                        'icon' => 'fas fa-calendar',
                        'url' => '/akademik/jadwal'
                    ],
                    [
                        'title' => 'Evaluasi Pembelajaran',
                        'icon' => 'fas fa-chart-line',
                        'url' => '/akademik/evaluasi'
                    ]
                ]
            ],
            [
                'title' => 'Kesiswaan',
                'icon' => 'fas fa-user-graduate',
                'submenu' => [
                    [
                        'title' => 'Data Siswa',
                        'icon' => 'fas fa-users',
                        'url' => '/kesiswaan/data'
                    ],
                    [
                        'title' => 'Prestasi Siswa',
                        'icon' => 'fas fa-trophy',
                        'url' => '/kesiswaan/prestasi'
                    ],
                    [
                        'title' => 'Disiplin Siswa',
                        'icon' => 'fas fa-gavel',
                        'url' => '/kesiswaan/disiplin'
                    ]
                ]
            ],
            [
                'title' => 'Keuangan',
                'icon' => 'fas fa-dollar-sign',
                'submenu' => [
                    [
                        'title' => 'Anggaran Sekolah',
                        'icon' => 'fas fa-wallet',
                        'url' => '/keuangan/anggaran'
                    ],
                    [
                        'title' => 'Laporan Keuangan',
                        'icon' => 'fas fa-chart-pie',
                        'url' => '/keuangan/laporan'
                    ],
                    [
                        'title' => 'SPP & Pembayaran',
                        'icon' => 'fas fa-credit-card',
                        'url' => '/keuangan/spp'
                    ]
                ]
            ],
            [
                'title' => 'Sarana & Prasarana',
                'icon' => 'fas fa-tools',
                'submenu' => [
                    [
                        'title' => 'Inventaris',
                        'icon' => 'fas fa-boxes',
                        'url' => '/sarpras/inventaris'
                    ],
                    [
                        'title' => 'Pemeliharaan',
                        'icon' => 'fas fa-wrench',
                        'url' => '/sarpras/pemeliharaan'
                    ],
                    [
                        'title' => 'Pengadaan',
                        'icon' => 'fas fa-shopping-cart',
                        'url' => '/sarpras/pengadaan'
                    ]
                ]
            ],
            [
                'title' => 'Laporan & Analytics',
                'icon' => 'fas fa-chart-bar',
                'submenu' => [
                    [
                        'title' => 'Dashboard Analytics',
                        'icon' => 'fas fa-chart-line',
                        'url' => '/analytics/dashboard'
                    ],
                    [
                        'title' => 'Laporan Bulanan',
                        'icon' => 'fas fa-calendar-alt',
                        'url' => '/laporan/bulanan'
                    ],
                    [
                        'title' => 'Laporan Tahunan',
                        'icon' => 'fas fa-calendar',
                        'url' => '/laporan/tahunan'
                    ],
                    [
                        'title' => 'Export Data',
                        'icon' => 'fas fa-download',
                        'url' => '/laporan/export'
                    ]
                ]
            ]
        ];
    }

    /**
     * Get user role color theme
     */
    public static function getRoleTheme($role)
    {
        $themes = [
            'guru_bk' => [
                'primary_color' => '#007bff',
                'sidebar_bg' => '#343a40',
                'accent_color' => '#17a2b8'
            ],
            'guru_kelas' => [
                'primary_color' => '#28a745',
                'sidebar_bg' => '#2d3436',
                'accent_color' => '#20c997'
            ],
            'wali_kelas' => [
                'primary_color' => '#6f42c1',
                'sidebar_bg' => '#2d3436',
                'accent_color' => '#e83e8c'
            ],
            'kepala_sekolah' => [
                'primary_color' => '#e74c3c',
                'sidebar_bg' => '#2c3e50',
                'accent_color' => '#fd79a8'
            ]
        ];

        return $themes[$role] ?? $themes['guru_bk'];
    }

    /**
     * Get role display name
     */
    public static function getRoleDisplayName($role)
    {
        $names = [
            'guru_bk' => 'Guru BK',
            'guru_kelas' => 'Guru Kelas', 
            'wali_kelas' => 'Wali Kelas',
            'kepala_sekolah' => 'Kepala Sekolah'
        ];

        return $names[$role] ?? 'User';
    }
}
