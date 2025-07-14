-- Database Backup
-- Generated on: 2025-07-10 08:30:31
-- Database: u809035070_simaklah

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `target_audience` enum('Semua','Guru','Siswa','Orangtua') NOT NULL DEFAULT 'Semua',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcements_author_id_foreign` (`author_id`),
  CONSTRAINT `announcements_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `announcements` VALUES 
('1', '1', 'Selamat Datang di Sistem Informasi Sekolah', 'Sistem informasi sekolah telah berhasil diimplementasikan. Semua pengguna dapat mengakses fitur sesuai dengan peran masing-masing.', 'Semua', '1', '2025-07-04 05:23:38', '2025-07-04 05:23:38', '2025-07-04 05:23:38'),
('2', '2', 'Jadwal Ulangan Harian Matematika', 'Ulangan harian matematika akan dilaksanakan pada hari Jumat, 15 Januari 2025. Materi yang diujikan adalah Fungsi Kuadrat.', 'Siswa', '1', '2025-07-04 05:23:38', '2025-07-04 05:23:38', '2025-07-04 05:23:38');

DROP TABLE IF EXISTS `assignments`;
CREATE TABLE `assignments` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `class_subject_id` int(5) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `max_score` decimal(5,2) NOT NULL DEFAULT 100.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assignments_class_subject_id_foreign` (`class_subject_id`),
  CONSTRAINT `assignments_class_subject_id_foreign` FOREIGN KEY (`class_subject_id`) REFERENCES `class_subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siswa_profile_id` int(11) unsigned NOT NULL,
  `teacher_assignment_id` int(11) unsigned NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('Hadir','Izin','Sakit','Alpha') NOT NULL DEFAULT 'Hadir',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siswa_profile_id_teacher_assignment_id_attendance_date` (`siswa_profile_id`,`teacher_assignment_id`,`attendance_date`),
  KEY `attendance_teacher_assignment_id_foreign` (`teacher_assignment_id`),
  CONSTRAINT `attendance_siswa_profile_id_foreign` FOREIGN KEY (`siswa_profile_id`) REFERENCES `siswa_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `attendance_teacher_assignment_id_foreign` FOREIGN KEY (`teacher_assignment_id`) REFERENCES `teacher_assignments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

DROP TABLE IF EXISTS `class_members`;
CREATE TABLE `class_members` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siswa_profile_id` int(11) unsigned NOT NULL,
  `class_id` int(11) unsigned NOT NULL,
  `school_year_id` int(11) unsigned NOT NULL,
  `enrollment_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siswa_profile_id_class_id_school_year_id` (`siswa_profile_id`,`class_id`,`school_year_id`),
  KEY `class_members_class_id_foreign` (`class_id`),
  KEY `class_members_school_year_id_foreign` (`school_year_id`),
  CONSTRAINT `class_members_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_members_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_members_siswa_profile_id_foreign` FOREIGN KEY (`siswa_profile_id`) REFERENCES `siswa_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

DROP TABLE IF EXISTS `class_subjects`;
CREATE TABLE `class_subjects` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(5) unsigned NOT NULL,
  `subject_id` int(5) unsigned NOT NULL,
  `guru_id` int(5) unsigned DEFAULT NULL,
  `schedule_day` varchar(20) DEFAULT NULL,
  `schedule_time_start` time DEFAULT NULL,
  `schedule_time_end` time DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_subjects_class_id_foreign` (`class_id`),
  KEY `class_subjects_subject_id_foreign` (`subject_id`),
  KEY `class_subjects_guru_id_foreign` (`guru_id`),
  CONSTRAINT `class_subjects_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_subjects_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru_profiles` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  CONSTRAINT `class_subjects_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

DROP TABLE IF EXISTS `classes`;
CREATE TABLE `classes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(100) NOT NULL COMMENT 'Contoh: X-IPA-1',
  `level` int(2) NOT NULL COMMENT 'Tingkat: 10, 11, 12',
  `homeroom_teacher_id` int(11) unsigned DEFAULT NULL COMMENT 'Wali kelas',
  `max_students` int(3) NOT NULL DEFAULT 36,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_homeroom_teacher_id_foreign` (`homeroom_teacher_id`),
  CONSTRAINT `classes_homeroom_teacher_id_foreign` FOREIGN KEY (`homeroom_teacher_id`) REFERENCES `guru_profiles` (`id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `classes` VALUES 
('1', 'X-IPA-1', '10', '2', '36', '2025-07-04 05:23:38', '2025-07-04 05:23:38'),
('2', 'X-IPA-2', '10', NULL, '36', '2025-07-04 05:23:38', '2025-07-04 05:23:38'),
('3', 'X-IPS-1', '10', NULL, '36', '2025-07-04 05:23:38', '2025-07-04 05:23:38');

DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siswa_profile_id` int(11) unsigned NOT NULL,
  `teacher_assignment_id` int(11) unsigned NOT NULL,
  `grade_type` enum('Tugas','Kuis','UTS','UAS','Praktikum') NOT NULL,
  `grade_value` decimal(5,2) DEFAULT NULL,
  `max_grade` decimal(5,2) NOT NULL DEFAULT 100.00,
  `description` text DEFAULT NULL,
  `grade_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grades_siswa_profile_id_foreign` (`siswa_profile_id`),
  KEY `grades_teacher_assignment_id_foreign` (`teacher_assignment_id`),
  CONSTRAINT `grades_siswa_profile_id_foreign` FOREIGN KEY (`siswa_profile_id`) REFERENCES `siswa_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `grades_teacher_assignment_id_foreign` FOREIGN KEY (`teacher_assignment_id`) REFERENCES `teacher_assignments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

DROP TABLE IF EXISTS `guru_mata_pelajaran`;
CREATE TABLE `guru_mata_pelajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `mata_pelajaran_id` int(11) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(10) unsigned DEFAULT NULL,
  `tahun_ajaran` varchar(20) DEFAULT '2024/2025',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_teacher_subject_class` (`user_id`,`mata_pelajaran_id`,`kelas_id`),
  KEY `mata_pelajaran_id` (`mata_pelajaran_id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  CONSTRAINT `guru_mata_pelajaran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `guru_mata_pelajaran_ibfk_2` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `guru_mata_pelajaran_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `guru_mata_pelajaran_ibfk_4` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `guru_mata_pelajaran` VALUES 
('1', '17', '1', '3', '16', '2024/2025', '1', '2025-07-05 19:18:06', '2025-07-06 07:20:14'),
('2', '17', '2', NULL, '16', '2024/2025', '1', '2025-07-05 19:18:06', '2025-07-06 07:20:14'),
('3', '18', '2', '3', '16', '2024/2025', '1', '2025-07-05 19:18:06', '2025-07-06 07:20:14'),
('4', '18', '3', NULL, '16', '2024/2025', '1', '2025-07-05 19:18:06', '2025-07-06 07:20:14'),
('5', '19', '4', '3', '16', '2024/2025', '1', '2025-07-05 19:18:06', '2025-07-06 07:20:14'),
('6', '19', '5', NULL, '16', '2024/2025', '1', '2025-07-05 19:18:06', '2025-07-06 07:20:14'),
('7', '19', '6', NULL, '16', '2024/2025', '1', '2025-07-05 19:18:06', '2025-07-06 07:20:14');

DROP TABLE IF EXISTS `guru_profiles`;
CREATE TABLE `guru_profiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `nip` varchar(50) NOT NULL COMMENT 'Nomor Induk Pegawai',
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL COMMENT 'Bidang keahlian',
  `hire_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `nip` (`nip`),
  CONSTRAINT `guru_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `guru_profiles` VALUES 
('1', '2', '19850515200801001', '081234567890', 'Jl. Pendidikan No. 123, Jakarta', '1985-05-15', 'Laki-laki', 'Matematika', '2008-01-01', '2025-07-04 05:23:38', '2025-07-04 05:23:38'),
('2', '3', '19820310200803002', '081234567891', 'Jl. Guru No. 456, Jakarta', '1982-03-10', 'Perempuan', 'Bahasa Indonesia', '2008-03-01', '2025-07-04 05:23:38', '2025-07-04 05:23:38'),
('3', '17', '196501011990031001', '081234567890', NULL, NULL, NULL, 'Matematika', '2025-07-06', '2025-07-06 02:18:06', '2025-07-06 02:18:06'),
('4', '18', '196802151991032001', '081234567891', NULL, NULL, NULL, 'Bahasa Indonesia', '2025-07-06', '2025-07-06 02:18:06', '2025-07-06 02:18:06'),
('5', '19', '197003201992031002', '081234567892', NULL, NULL, NULL, 'IPA', '2025-07-06', '2025-07-06 02:18:06', '2025-07-06 02:18:06');

DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(100) NOT NULL COMMENT 'Nama jabatan seperti Guru IPA, Kepala Sekolah, dll',
  `kode_jabatan` varchar(10) NOT NULL COMMENT 'Kode singkat jabatan',
  `kategori` enum('guru_mapel','kepala_sekolah','wakil_kepala_sekolah','guru_bk','admin','staff') NOT NULL COMMENT 'Kategori jabatan',
  `departemen` enum('akademik','administrasi','bimbingan_konseling','kepala_sekolah') NOT NULL COMMENT 'Departemen jabatan',
  `level` enum('pimpinan','koordinator','pelaksana') NOT NULL COMMENT 'Level jabatan',
  `deskripsi` text DEFAULT NULL COMMENT 'Deskripsi tugas dan tanggung jawab',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `tahun_ajaran_id` int(11) DEFAULT NULL COMMENT 'Tahun ajaran saat jabatan ini dibuat',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_jabatan` (`kode_jabatan`),
  KEY `idx_kategori` (`kategori`),
  KEY `idx_departemen` (`departemen`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel untuk menyimpan data jabatan petugas sekolah';

INSERT INTO `jabatan` VALUES 
('1', 'Kepala Sekolah', 'KS', 'kepala_sekolah', 'kepala_sekolah', 'pimpinan', 'Kepala Sekolah', 'aktif', NULL, '2025-07-10 04:23:24', '2025-07-10 04:23:24'),
('2', 'Wakil Kepala Sekolah Bidang Kurikulum', 'WKSKUR', 'wakil_kepala_sekolah', 'akademik', 'koordinator', 'Wakil Kepala Sekolah Bidang Kurikulum', 'aktif', NULL, '2025-07-10 04:23:24', '2025-07-10 04:23:24'),
('3', 'Wakil Kepala Sekolah Bidang Kesiswaan', 'WKSSISWA', 'wakil_kepala_sekolah', 'akademik', 'koordinator', 'Wakil Kepala Sekolah Bidang Kesiswaan', 'aktif', NULL, '2025-07-10 04:23:24', '2025-07-10 04:23:24'),
('4', 'Guru Matematika', 'GMT', 'guru_mapel', 'akademik', 'pelaksana', 'Guru Mata Pelajaran Matematika', 'aktif', NULL, '2025-07-10 04:23:25', '2025-07-10 04:23:25'),
('5', 'Guru Bahasa Indonesia', 'GBI', 'guru_mapel', 'akademik', 'pelaksana', 'Guru Mata Pelajaran Bahasa Indonesia', 'aktif', NULL, '2025-07-10 04:23:25', '2025-07-10 04:23:25'),
('6', 'Guru Bimbingan Konseling', 'GBK', 'guru_bk', 'bimbingan_konseling', 'pelaksana', 'Guru Bimbingan Konseling', 'aktif', NULL, '2025-07-10 04:23:25', '2025-07-10 04:23:25'),
('7', 'Staff Administrasi', 'ADM', 'admin', 'administrasi', 'pelaksana', 'Staff Administrasi', 'aktif', NULL, '2025-07-10 04:23:25', '2025-07-10 04:23:25'),
('8', 'Staff Perpustakaan', 'PERPUS', 'staff', 'administrasi', 'pelaksana', 'Staff Perpustakaan', 'aktif', NULL, '2025-07-10 04:23:25', '2025-07-10 04:23:25');

DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) NOT NULL,
  `sekolah_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(10) unsigned DEFAULT NULL,
  `tingkat` tinyint(2) NOT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `kapasitas` int(11) NOT NULL DEFAULT 30,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_sekolah` (`sekolah_id`),
  KEY `idx_tingkat` (`tingkat`),
  KEY `idx_status` (`status`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kelas_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kelas` VALUES 
('1', '1A', '1', '15', '1', NULL, '25', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('2', '1B', '1', '15', '1', NULL, '25', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('3', '2A', '1', '15', '2', NULL, '25', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('4', '7A', '2', '15', '7', NULL, '30', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('5', '7B', '2', '15', '7', NULL, '30', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('6', '8A', '2', '15', '8', NULL, '28', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('7', '10 IPA 1', '3', '15', '10', 'IPA', '32', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('8', '10 IPA 2', '3', '15', '10', 'IPA', '32', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('9', '10 IPS 1', '3', '15', '10', 'IPS', '30', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('10', '11 IPA 1', '3', '15', '11', 'IPA', '30', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('11', '11 IPS 1', '3', '15', '11', 'IPS', '28', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('12', '12 IPA 1', '3', '15', '12', 'IPA', '28', 'aktif', '2025-07-05 18:32:13', '2025-07-06 17:07:12'),
('13', 'X IPA 1', '1', '17', '0', NULL, '30', 'aktif', '2025-07-06 14:42:29', '2025-07-06 14:42:29'),
('14', 'X IPA 2', '1', '17', '0', NULL, '30', 'aktif', '2025-07-06 14:42:29', '2025-07-06 14:42:29'),
('15', 'XI IPA 1', '1', '17', '0', NULL, '30', 'aktif', '2025-07-06 14:42:29', '2025-07-06 14:42:29'),
('16', 'XI IPA 2', '1', '17', '0', NULL, '30', 'aktif', '2025-07-06 14:42:29', '2025-07-06 14:42:29'),
('17', 'XII IPA 1', '1', '17', '0', NULL, '30', 'aktif', '2025-07-06 14:42:29', '2025-07-06 14:42:29'),
('18', 'XII IPA 2', '1', '17', '0', NULL, '30', 'aktif', '2025-07-06 14:42:29', '2025-07-06 14:42:29'),
('19', 'X IPS 1', '1', '17', '0', NULL, '30', 'aktif', '2025-07-06 14:42:29', '2025-07-06 14:42:29'),
('20', 'XI IPS 1', '1', '17', '0', NULL, '30', 'aktif', '2025-07-06 14:42:29', '2025-07-06 14:42:29'),
('21', 'XII IPS 1', '1', '17', '0', NULL, '30', 'aktif', '2025-07-06 14:42:29', '2025-07-06 14:42:29');

DROP TABLE IF EXISTS `mata_pelajaran`;
CREATE TABLE `mata_pelajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(100) NOT NULL,
  `kode_mapel` varchar(10) NOT NULL,
  `kategori` enum('wajib','pilihan','muatan_lokal') NOT NULL,
  `tingkat` enum('SD','SMP','SMA','SMK') NOT NULL,
  `jam_pelajaran` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `tahun_ajaran_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_mapel` (`kode_mapel`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mata_pelajaran` VALUES 
('1', 'Matematika', 'MAT', 'wajib', 'SMA', '4', 'Mata pelajaran matematika untuk SMA', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('2', 'Bahasa Indonesia', 'BIN', 'wajib', 'SMA', '4', 'Mata pelajaran bahasa Indonesia', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('3', 'Bahasa Inggris', 'ENG', 'wajib', 'SMA', '3', 'Mata pelajaran bahasa Inggris', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('4', 'Fisika', 'FIS', 'wajib', 'SMA', '3', 'Mata pelajaran fisika', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('5', 'Kimia', 'KIM', 'wajib', 'SMA', '3', 'Mata pelajaran kimia', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('6', 'Biologi', 'BIO', 'wajib', 'SMA', '3', 'Mata pelajaran biologi', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('7', 'Sejarah', 'SEJ', 'wajib', 'SMA', '2', 'Mata pelajaran sejarah', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('8', 'Geografi', 'GEO', 'pilihan', 'SMA', '2', 'Mata pelajaran geografi', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('9', 'Ekonomi', 'EKO', 'pilihan', 'SMA', '2', 'Mata pelajaran ekonomi', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('10', 'Sosiologi', 'SOS', 'pilihan', 'SMA', '2', 'Mata pelajaran sosiologi', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('11', 'Pendidikan Agama', 'PAI', 'wajib', 'SMA', '2', 'Mata pelajaran pendidikan agama Islam', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('12', 'Pendidikan Kewarganegaraan', 'PKN', 'wajib', 'SMA', '2', 'Mata pelajaran pendidikan kewarganegaraan', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('13', 'Seni Budaya', 'SBK', 'wajib', 'SMA', '2', 'Mata pelajaran seni budaya', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('14', 'Penjaskes', 'PJS', 'wajib', 'SMA', '2', 'Mata pelajaran pendidikan jasmani dan kesehatan', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('15', 'Bahasa Jawa', 'BJW', 'muatan_lokal', 'SMA', '2', 'Mata pelajaran bahasa Jawa sebagai muatan lokal', 'aktif', '15', '2025-07-05 19:08:24', '2025-07-06 17:07:12'),
('44', 'Matematika', 'MAT_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('45', 'Bahasa Indonesia', 'BIN_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('46', 'Bahasa Inggris', 'ENG_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('47', 'Fisika', 'FIS_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('48', 'Kimia', 'KIM_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('49', 'Biologi', 'BIO_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('50', 'Sejarah', 'SEJ_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('51', 'Geografi', 'GEO_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('52', 'Ekonomi', 'EKO_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('53', 'Sosiologi', 'SOS_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('54', 'Pendidikan Agama', 'PAI_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('55', 'Pendidikan Kewarganegaraan', 'PKN_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('56', 'Seni Budaya', 'SBK_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('57', 'Penjaskes', 'PJS_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00'),
('58', 'Bahasa Jawa', 'BJW_2025', 'wajib', 'SMA', '2', 'Disalin dari tahun ajaran sebelumnya', 'aktif', '17', '2025-07-06 11:27:00', '2025-07-06 11:27:00');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `migrations` VALUES 
('1', '2025_01_04_120000', 'App\\Database\\Migrations\\CreateSekolahSystemTables', 'default', 'App', '1751606406', '1');

DROP TABLE IF EXISTS `murid`;
CREATE TABLE `murid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nisn` varchar(20) NOT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `wali_kelas` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nisn` (`nisn`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `nis` (`nis`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `murid` VALUES 
('1', 'TEMP_4', NULL, 'siswa_001', 'ahmad.rizki@email.com', '$2y$10$6iNUxCzkMIn8hy9tTMkneeJhd3MgUa2kId6LzGWbm91BSNzeILyZm', 'Ahmad Rizki Pratama 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '15', '2025-07-03 22:23:37', '2025-07-10 02:59:33'),
('2', 'TEMP_12', NULL, 'siswa001', 'siswa001@example.com', '$2y$10$t4a8wuOwaW2QK8Jowds/Lu1EVt5Otqgl1R/7lPuZWNnk5nwubpHRq', 'Ahmad Rizki', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '15', '2025-07-05 18:37:32', '2025-07-05 18:37:32'),
('3', 'TEMP_13', NULL, 'siswa002', 'siswa002@example.com', '$2y$10$I72vdwtXqtfpc1lMke47y.IxOGRuciBb.iF6yW4YJP0ieylKfsmDO', 'Siti Fatimah', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '15', '2025-07-05 18:37:32', '2025-07-05 18:37:32'),
('4', 'TEMP_14', NULL, 'siswa003', 'siswa003@example.com', '$2y$10$v741LvzUmvm4V5ZVj7KSPugZyUXOj06P6TmRbNsSNtbkfYQcR9SMO', 'Budi Santoso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '17', '2025-07-05 18:37:32', '2025-07-08 14:05:22'),
('5', 'TEMP_15', NULL, 'siswa004', 'siswa004@example.com', '$2y$10$1b1pebCUJoROeh6h8BLdDO5C3o3Lo6aNGfTfDR5J/A3GY9IqvJZ/2', 'Dewi Sartika', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '15', '2025-07-05 18:37:32', '2025-07-05 18:37:32'),
('6', 'TEMP_16', NULL, 'siswa005', 'siswa005@example.com', '$2y$10$s1FZGmv7QNxNY1BNan2YpuGtGKnDpSt1csxeObEUUl7T7JAPR1kPO', 'Agus Prasetyo', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '15', '2025-07-05 18:37:32', '2025-07-05 18:37:32'),
('7', 'TEMP_20', NULL, 'ahmad_budi', 'ahmad.budi@student.sch.id', '$2y$10$PNFNk0hlL/Kx.7UAPIu.HuA.BfrBbIYZByV1i.jyUOHkO/wrv3afq', 'Ahmad Budi', '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '17', '2025-07-06 14:46:08', '2025-07-06 10:47:35'),
('8', 'TEMP_21', NULL, 'siti_nurhaliza', 'siti.nurhaliza@student.sch.id', '$2y$10$4xNACzCnGLtfRzXhaEbNPust2rek9V/fM9XF7PVVBheOCbTLw.cVS', 'Siti Nurhaliza', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '17', '2025-07-06 14:46:08', '2025-07-06 14:46:08'),
('9', 'TEMP_22', NULL, 'dimas_prakoso', 'dimas.prakoso@student.sch.id', '$2y$10$jCE.bk8ruQ20AAOmlFpzZ.Sa3/HNePb.DUr/VZ5FQkyqPnurLWPd2', 'Dimas Prakoso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '17', '2025-07-06 14:46:08', '2025-07-06 14:46:08'),
('10', 'TEMP_23', NULL, 'lestari_indah', 'lestari.indah@student.sch.id', '$2y$10$z4b6WxD6ND8GHey3bJj1yu6GY584vthrjQNfzh3qoU0wLRspPPUz2', 'Lestari Indah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '17', '2025-07-06 14:46:09', '2025-07-06 14:46:09'),
('11', 'TEMP_24', NULL, 'rizky_ferdiansyah', 'rizky.ferdiansyah@student.sch.id', '$2y$10$e8nnW1gNE9irwNTIMciRR.VqYXpVHKomq7EygaRXMDVYnYjZ5PSIa', 'Rizky Ferdiansyah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '17', '2025-07-06 14:46:09', '2025-07-06 14:46:09');

DROP TABLE IF EXISTS `murid_kelas`;
CREATE TABLE `murid_kelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `murid_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `status` enum('aktif','pindah','lulus','dropout') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_murid` (`murid_id`),
  KEY `idx_kelas` (`kelas_id`),
  KEY `idx_tahun` (`tahun_ajaran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `orang_tua`;
CREATE TABLE `orang_tua` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `pendidikan` varchar(50) DEFAULT NULL,
  `penghasilan` varchar(50) DEFAULT NULL,
  `hubungan_keluarga` enum('Ayah','Ibu','Wali') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orang_tua` VALUES 
('1', 'orangtua_001', 'hadi.pratama@email.com', '$2y$10$TIz7LR9JbaLiFQ8AyOt.H.6fTAGfO8s2WP/XV6IVbrQolVmOEr7Ei', 'Hadi Pratama', NULL, NULL, NULL, NULL, NULL, 'Wali', NULL, '1', NULL, '15', '2025-07-03 22:23:38', '2025-07-03 22:23:38');

DROP TABLE IF EXISTS `orang_tua_murid`;
CREATE TABLE `orang_tua_murid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orang_tua_id` int(11) NOT NULL,
  `murid_id` int(11) NOT NULL,
  `hubungan` enum('Ayah','Ibu','Wali') NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_parent_child` (`orang_tua_id`,`murid_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `orangtua_profiles`;
CREATE TABLE `orangtua_profiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL COMMENT 'Pekerjaan',
  `address` text DEFAULT NULL,
  `emergency_contact` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `orangtua_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `orangtua_profiles` VALUES 
('1', '5', '081234567893', 'Pegawai Swasta', 'Jl. Siswa No. 789, Jakarta', '081234567894', '2025-07-04 05:23:38', '2025-07-04 05:23:38');

DROP TABLE IF EXISTS `petugas`;
CREATE TABLE `petugas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `departemen` varchar(50) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `petugas` VALUES 
('1', NULL, 'guru_matematika', 'guru.matematika@sekolah.com', '$2y$10$e5QO0/YtThiV.ofJmhjyb.IIbzkAQ56qCBT5/rpxtCzeRCXw1Qgdu', 'Budi Santoso, S.Pd', '16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '15', '2025-07-05 19:18:05', '2025-07-05 19:18:05'),
('2', NULL, 'guru_bahasa', 'guru.bahasa@sekolah.com', '$2y$10$YYKdq8psXvD616wiQ4O3aentaQUcjErdyw52U05W8KnbRpPCx6htS', 'Siti Aminah, S.Pd', '16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '15', '2025-07-05 19:18:06', '2025-07-05 19:18:06'),
('3', NULL, 'guru_ipa', 'guru.ipa@sekolah.com', '$2y$10$A8TRhbDUpXN32ULGS9W9YOeTR1WsVLqUifdE3Kr7f4KbwdYeVCkkS', 'Ahmad Fauzi, S.Si', '16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '15', '2025-07-05 19:18:06', '2025-07-05 19:18:06'),
('4', NULL, 'hermawan_guru', 'hermawan@teacher.sch.id', '$2y$10$jF3uuXH6u9VwELXMpQBOOOdi5kMMo2CQE9OHwKTFenfEBSSZS1T0u', 'Prof. Dr. Hermawan', '16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '17', '2025-07-06 14:46:09', '2025-07-06 14:46:09'),
('5', NULL, 'sari_rahayu', 'sari.rahayu@teacher.sch.id', '$2y$10$8f63d9pLEkiVBKTS7TfcMOhX4MMUqDEv3GzHNVxlVEPurKQ184tpO', 'Dr. Sari Rahayu', '16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '17', '2025-07-06 14:46:09', '2025-07-06 14:46:09'),
('6', NULL, 'budi_santoso', 'budi.santoso@teacher.sch.id', '$2y$10$0dIywmGvI/1At4AKChu0A.sC8byHwStgaKQ7WVfCfKrZdDGmG/yzK', 'Ir. Budi Santoso', '16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '17', '2025-07-06 14:46:09', '2025-07-06 14:46:09'),
('7', NULL, 'guru_mtk', 'budi.santoso@sekolah.com', '$2y$10$lFLX2DoXMVss5UqueyIKv.qN59L4K3.797clZhuE.FPn4F3Bsk00.', 'Budi Santoso, S.Pd', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '15', '2025-07-03 22:23:36', '2025-07-03 22:23:36'),
('8', NULL, 'superadmin', 'superadmin@sekolah.com', '$2y$10$RG6rUXfhKK.1UKJFQ9twGeX0ZsTPOcp7gHN8lh9.zCni05/txdBWG', 'Super Administrator 23', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'profile_1_1751732094.png', '1', '2025-07-06 07:16:27', '15', '2025-07-03 22:23:36', '2025-07-06 00:16:27'),
('9', NULL, 'wali_kelas_10a', 'siti.rahayu@sekolah.com', '$2y$10$WM5paENC0iYp8FbGzlrVOeM5tg.Ynzjj39NM0hU87BAUOZh/M26PS', 'Siti Rahayu, S.Pd', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, '15', '2025-07-03 22:23:37', '2025-07-03 22:23:37'),
('17', '002', 'kepala_sekolah', 'kepala@sekolah.com', '$2y$10$WxSyIRvJOI8Ora28H/wRE.LMhQGY2TslaKJckZMmq0foYihCCOaHK', 'Dr. Ahmad Wijaya', '7', 'Kepala Sekolah', 'Manajemen', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, '2025-07-07 03:01:00', '2025-07-07 03:01:00'),
('19', '004', 'wali_kelas_1a', 'wali1a@sekolah.com', '$2y$10$ntJ7wsSsu0Y5gIQ0Nj5lzu9Sqt.fX2xtMLiGRIdLJIgYNTAKOTdcC', 'Budi Santoso S.Pd', '3', 'Wali Kelas 1A', 'Pendidikan', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, '2025-07-07 03:01:00', '2025-07-07 03:01:00'),
('20', '005', 'staff_admin', 'staff@sekolah.com', '$2y$10$TEIn8Ag7s9qjwsPyS4AoQ.qEKQrjLFohY.rYrOUqVS2Ybvf642nbu', 'Maya Sari', '6', 'Staff Administrasi', 'Administrasi', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, '2025-07-07 03:01:00', '2025-07-07 03:01:00'),
('21', '19900101774', 'testuser7721', 'test8253@example.com', '$2y$10$AmLOVsZ81O7KOdjA2xeFgOiSFSZv92YC/t/pISvi4rFSpqIzE3ZaG', 'Test User 6500', '6', 'Staff Testing', 'IT', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, '2025-07-06 20:56:05', '2025-07-06 20:56:05');

DROP TABLE IF EXISTS `petugas_jabatan`;
CREATE TABLE `petugas_jabatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `petugas_id` int(11) NOT NULL COMMENT 'ID petugas',
  `jabatan_id` int(11) NOT NULL COMMENT 'ID jabatan',
  `tahun_ajaran_id` int(11) DEFAULT NULL COMMENT 'Tahun ajaran penugasan',
  `tanggal_mulai` date NOT NULL COMMENT 'Tanggal mulai bertugas',
  `tanggal_selesai` date DEFAULT NULL COMMENT 'Tanggal selesai bertugas (NULL jika masih aktif)',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_petugas_id` (`petugas_id`),
  KEY `idx_jabatan_id` (`jabatan_id`),
  KEY `idx_tahun_ajaran_id` (`tahun_ajaran_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel relasi many-to-many antara petugas dan jabatan';

DROP TABLE IF EXISTS `relasi_orangtua_siswa`;
CREATE TABLE `relasi_orangtua_siswa` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orangtua_profile_id` int(11) unsigned NOT NULL,
  `siswa_profile_id` int(11) unsigned NOT NULL,
  `relationship_status` enum('Ayah','Ibu','Wali') NOT NULL COMMENT 'Status hubungan dengan siswa',
  `is_emergency_contact` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `relasi_orangtua_siswa_orangtua_profile_id_foreign` (`orangtua_profile_id`),
  KEY `relasi_orangtua_siswa_siswa_profile_id_foreign` (`siswa_profile_id`),
  CONSTRAINT `relasi_orangtua_siswa_orangtua_profile_id_foreign` FOREIGN KEY (`orangtua_profile_id`) REFERENCES `orangtua_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `relasi_orangtua_siswa_siswa_profile_id_foreign` FOREIGN KEY (`siswa_profile_id`) REFERENCES `siswa_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `relasi_orangtua_siswa` VALUES 
('1', '1', '1', 'Ayah', '1', '2025-07-04 05:23:38', '2025-07-04 05:23:38');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `roles` VALUES 
('1', 'Super Admin', 'Administrator utama yang memiliki akses penuh ke seluruh sistem termasuk manajemen pengguna, pengaturan sistem, dan semua fitur administrasi.', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('2', 'Guru Mapel', 'Guru mata pelajaran yang bertanggung jawab mengajar mata pelajaran tertentu, mengelola nilai siswa, absensi, dan tugas-tugas dalam kelas yang diampu.', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('3', 'Wali Kelas', 'Guru yang ditunjuk sebagai wali kelas dengan tanggung jawab tambahan untuk mengelola administrasi kelas dan koordinasi dengan orang tua siswa.', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('4', 'Siswa', 'Peserta didik yang terdaftar di sekolah. Memiliki akses untuk melihat jadwal pelajaran, tugas, nilai, dan absensi mereka sendiri.', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('5', 'Orangtua', 'Orang tua atau wali siswa yang memiliki akses untuk memantau perkembangan akademik anak mereka termasuk nilai, absensi, dan pengumuman sekolah.', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('6', 'Staff Administrasi', 'Staf administrasi sekolah yang bertanggung jawab untuk mengelola data siswa, guru, dan administrasi umum sekolah.', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('7', 'Kepala Sekolah', 'Pimpinan sekolah yang memiliki akses untuk melihat laporan, statistik, dan mengawasi keseluruhan operasional sekolah.', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('16', 'Guru', 'Guru/Teacher role', NULL, NULL),
('24', 'Wali Murid', 'Wali Murid/Orang Tua', NULL, NULL);

DROP TABLE IF EXISTS `school_years`;
CREATE TABLE `school_years` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_tahun_ajaran` varchar(20) DEFAULT NULL,
  `tahun_mulai` year(4) DEFAULT NULL,
  `tahun_selesai` year(4) DEFAULT NULL,
  `year` varchar(20) NOT NULL COMMENT 'Contoh: 2024/2025',
  `semester` enum('Ganjil','Genap') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `school_years` VALUES 
('15', '2023/2024', '2023', '2024', '2023/2024', 'Genap', '0', '2023-07-01', '2024-06-30', '2025-07-06 14:20:14', '2025-07-06 17:59:08'),
('16', '2024/2025', '2024', '2025', '2024/2025', 'Ganjil', '0', '2024-07-01', '2025-06-30', '2025-07-06 14:20:14', '2025-07-06 17:59:23'),
('17', '2025/2026', '2025', '2026', '2025/2026', 'Ganjil', '1', '2025-07-01', '2026-06-30', '2025-07-06 14:20:14', '2025-07-06 17:59:23');

DROP TABLE IF EXISTS `sekolah`;
CREATE TABLE `sekolah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sekolah` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kepala_sekolah` varchar(100) NOT NULL,
  `npsn` varchar(8) NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `npsn` (`npsn`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sekolah` VALUES 
('1', 'SDN 001 Jakarta', 'Jl. Merdeka No. 123, Jakarta Pusat', '021-12345678', 'sdn001@jakarta.sch.id', 'Drs. Ahmad Subandi', '12345001', 'aktif', '2025-07-05 18:22:36', '2025-07-05 18:22:36'),
('2', 'SMP Negeri 1 Bandung', 'Jl. Sudirman No. 456, Bandung', '022-87654321', 'smpn1@bandung.sch.id', 'Dra. Siti Nurhasanah', '12345002', 'aktif', '2025-07-05 18:22:36', '2025-07-05 18:22:36'),
('3', 'SMA Negeri 3 Surabaya', 'Jl. Pemuda No. 789, Surabaya', '031-11223344', 'sman3@surabaya.sch.id', 'Dr. Bambang Sutrisno', '12345003', 'aktif', '2025-07-05 18:22:36', '2025-07-05 18:22:36');

DROP TABLE IF EXISTS `siswa_profiles`;
CREATE TABLE `siswa_profiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `nis` varchar(20) NOT NULL COMMENT 'Nomor Induk Siswa',
  `nisn` varchar(20) NOT NULL COMMENT 'Nomor Induk Siswa Nasional',
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_place` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `entry_date` date DEFAULT NULL COMMENT 'Tanggal masuk sekolah',
  `graduation_date` date DEFAULT NULL COMMENT 'Tanggal lulus',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `nis` (`nis`),
  UNIQUE KEY `nisn` (`nisn`),
  CONSTRAINT `siswa_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `siswa_profiles` VALUES 
('1', '4', '2024001', '1234567890', 'Laki-laki', '2008-05-20', 'Jakarta', 'Jl. Siswa No. 789, Jakarta', '081234567892', 'Islam', 'A', '2024-07-15', NULL, '1', '2025-07-04 05:23:38', '2025-07-04 05:23:38');

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(20) NOT NULL COMMENT 'Contoh: MTK-01',
  `subject_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subject_code` (`subject_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `subjects` VALUES 
('1', 'MTK-10', 'Matematika', 'Mata pelajaran Matematika untuk tingkat SMA', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('2', 'BIN-10', 'Bahasa Indonesia', 'Mata pelajaran Bahasa Indonesia untuk tingkat SMA', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('3', 'BING-10', 'Bahasa Inggris', 'Mata pelajaran Bahasa Inggris untuk tingkat SMA', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('4', 'FIS-10', 'Fisika', 'Mata pelajaran Fisika untuk tingkat SMA IPA', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('5', 'KIM-10', 'Kimia', 'Mata pelajaran Kimia untuk tingkat SMA IPA', '2025-07-04 05:23:35', '2025-07-04 05:23:35'),
('6', 'BIO-10', 'Biologi', 'Mata pelajaran Biologi untuk tingkat SMA IPA', '2025-07-04 05:23:35', '2025-07-04 05:23:35');

DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `system_settings` VALUES 
('1', 'active_school_year_id', '17', 'ID of currently active school year', '2025-07-06 04:54:05', '2025-07-06 10:59:23');

DROP TABLE IF EXISTS `teacher_assignments`;
CREATE TABLE `teacher_assignments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guru_profile_id` int(11) unsigned NOT NULL,
  `subject_id` int(11) unsigned NOT NULL,
  `class_id` int(11) unsigned NOT NULL,
  `school_year_id` int(11) unsigned NOT NULL,
  `day_of_week` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teacher_assignments_guru_profile_id_foreign` (`guru_profile_id`),
  KEY `teacher_assignments_subject_id_foreign` (`subject_id`),
  KEY `teacher_assignments_class_id_foreign` (`class_id`),
  KEY `teacher_assignments_school_year_id_foreign` (`school_year_id`),
  CONSTRAINT `teacher_assignments_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `teacher_assignments_guru_profile_id_foreign` FOREIGN KEY (`guru_profile_id`) REFERENCES `guru_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `teacher_assignments_school_year_id_foreign` FOREIGN KEY (`school_year_id`) REFERENCES `school_years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `teacher_assignments_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) unsigned NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(10) unsigned DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `fk_users_kelas` (`kelas_id`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  CONSTRAINT `fk_users_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `school_years` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `users` VALUES 
('1', '1', NULL, '15', 'superadmin', '$2y$10$RG6rUXfhKK.1UKJFQ9twGeX0ZsTPOcp7gHN8lh9.zCni05/txdBWG', 'Super Administrator 23', 'superadmin@sekolah.com', 'profile_1_1751732094.png', '1', '2025-07-10 08:08:41', '2025-07-04 05:23:36', '2025-07-10 08:08:41'),
('2', '2', NULL, '15', 'guru_mtk', '$2y$10$lFLX2DoXMVss5UqueyIKv.qN59L4K3.797clZhuE.FPn4F3Bsk00.', 'Budi Santoso, S.Pd', 'budi.santoso@sekolah.com', NULL, '1', NULL, '2025-07-04 05:23:36', '2025-07-04 05:23:36'),
('3', '3', NULL, '15', 'wali_kelas_10a', '$2y$10$WM5paENC0iYp8FbGzlrVOeM5tg.Ynzjj39NM0hU87BAUOZh/M26PS', 'Siti Rahayu, S.Pd', 'siti.rahayu@sekolah.com', NULL, '1', NULL, '2025-07-04 05:23:37', '2025-07-04 05:23:37'),
('4', '4', NULL, '15', 'siswa_001', '$2y$10$6iNUxCzkMIn8hy9tTMkneeJhd3MgUa2kId6LzGWbm91BSNzeILyZm', 'Ahmad Rizki Pratama 1', 'ahmad.rizki@email.com', NULL, '1', NULL, '2025-07-04 05:23:37', '2025-07-08 21:05:22'),
('5', '5', NULL, '15', 'orangtua_001', '$2y$10$TIz7LR9JbaLiFQ8AyOt.H.6fTAGfO8s2WP/XV6IVbrQolVmOEr7Ei', 'Hadi Pratama', 'hadi.pratama@email.com', NULL, '1', NULL, '2025-07-04 05:23:38', '2025-07-04 05:23:38'),
('12', '4', '1', '15', 'siswa001', '$2y$10$t4a8wuOwaW2QK8Jowds/Lu1EVt5Otqgl1R/7lPuZWNnk5nwubpHRq', 'Ahmad Rizki', 'siswa001@example.com', NULL, '1', NULL, '2025-07-06 01:37:32', '2025-07-06 01:37:32'),
('13', '4', '1', '15', 'siswa002', '$2y$10$I72vdwtXqtfpc1lMke47y.IxOGRuciBb.iF6yW4YJP0ieylKfsmDO', 'Siti Fatimah', 'siswa002@example.com', NULL, '1', NULL, '2025-07-06 01:37:32', '2025-07-06 01:37:32'),
('14', '4', '2', '15', 'siswa003', '$2y$10$v741LvzUmvm4V5ZVj7KSPugZyUXOj06P6TmRbNsSNtbkfYQcR9SMO', 'Budi Santoso', 'siswa003@example.com', NULL, '1', NULL, '2025-07-06 01:37:32', '2025-07-06 01:37:32'),
('15', '4', '2', '15', 'siswa004', '$2y$10$1b1pebCUJoROeh6h8BLdDO5C3o3Lo6aNGfTfDR5J/A3GY9IqvJZ/2', 'Dewi Sartika', 'siswa004@example.com', NULL, '1', NULL, '2025-07-06 01:37:32', '2025-07-06 01:37:32'),
('16', '4', '3', '15', 'siswa005', '$2y$10$s1FZGmv7QNxNY1BNan2YpuGtGKnDpSt1csxeObEUUl7T7JAPR1kPO', 'Agus Prasetyo', 'siswa005@example.com', NULL, '1', NULL, '2025-07-06 01:37:32', '2025-07-06 01:37:32'),
('17', '16', NULL, '15', 'guru_matematika', '$2y$10$e5QO0/YtThiV.ofJmhjyb.IIbzkAQ56qCBT5/rpxtCzeRCXw1Qgdu', 'Budi Santoso, S.Pd', 'guru.matematika@sekolah.com', NULL, '1', NULL, '2025-07-06 02:18:05', '2025-07-06 02:18:05'),
('18', '16', NULL, '15', 'guru_bahasa', '$2y$10$YYKdq8psXvD616wiQ4O3aentaQUcjErdyw52U05W8KnbRpPCx6htS', 'Siti Aminah, S.Pd', 'guru.bahasa@sekolah.com', NULL, '1', NULL, '2025-07-06 02:18:06', '2025-07-06 02:18:06'),
('19', '16', NULL, '15', 'guru_ipa', '$2y$10$A8TRhbDUpXN32ULGS9W9YOeTR1WsVLqUifdE3Kr7f4KbwdYeVCkkS', 'Ahmad Fauzi, S.Si', 'guru.ipa@sekolah.com', NULL, '1', NULL, '2025-07-06 02:18:06', '2025-07-06 02:18:06'),
('20', '4', '12', '17', 'ahmad_budi', '$2y$10$PNFNk0hlL/Kx.7UAPIu.HuA.BfrBbIYZByV1i.jyUOHkO/wrv3afq', 'Ahmad Budi', 'ahmad.budi@student.sch.id', NULL, '1', NULL, '2025-07-06 21:46:08', '2025-07-06 17:47:35'),
('21', '4', '21', '17', 'siti_nurhaliza', '$2y$10$4xNACzCnGLtfRzXhaEbNPust2rek9V/fM9XF7PVVBheOCbTLw.cVS', 'Siti Nurhaliza', 'siti.nurhaliza@student.sch.id', NULL, '1', NULL, '2025-07-06 21:46:08', '2025-07-08 20:55:34'),
('22', '4', '21', '17', 'dimas_prakoso', '$2y$10$jCE.bk8ruQ20AAOmlFpzZ.Sa3/HNePb.DUr/VZ5FQkyqPnurLWPd2', 'Dimas Prakoso', 'dimas.prakoso@student.sch.id', NULL, '1', NULL, '2025-07-06 21:46:08', '2025-07-08 21:01:42'),
('23', '4', '21', '17', 'lestari_indah', '$2y$10$z4b6WxD6ND8GHey3bJj1yu6GY584vthrjQNfzh3qoU0wLRspPPUz2', 'Lestari Indah', 'lestari.indah@student.sch.id', NULL, '1', NULL, '2025-07-06 21:46:09', '2025-07-08 20:55:25'),
('24', '4', '21', '17', 'rizky_ferdiansyah', '$2y$10$e8nnW1gNE9irwNTIMciRR.VqYXpVHKomq7EygaRXMDVYnYjZ5PSIa', 'Rizky Ferdiansyah', 'rizky.ferdiansyah@student.sch.id', NULL, '1', NULL, '2025-07-06 21:46:09', '2025-07-08 20:37:06'),
('25', '16', NULL, '17', 'hermawan_guru', '$2y$10$jF3uuXH6u9VwELXMpQBOOOdi5kMMo2CQE9OHwKTFenfEBSSZS1T0u', 'Prof. Dr. Hermawan', 'hermawan@teacher.sch.id', NULL, '1', NULL, '2025-07-06 21:46:09', '2025-07-06 21:46:09'),
('26', '16', NULL, '17', 'sari_rahayu', '$2y$10$8f63d9pLEkiVBKTS7TfcMOhX4MMUqDEv3GzHNVxlVEPurKQ184tpO', 'Dr. Sari Rahayu', 'sari.rahayu@teacher.sch.id', NULL, '1', NULL, '2025-07-06 21:46:09', '2025-07-06 21:46:09'),
('27', '16', NULL, '17', 'budi_santoso', '$2y$10$0dIywmGvI/1At4AKChu0A.sC8byHwStgaKQ7WVfCfKrZdDGmG/yzK', 'Ir. Budi Santoso', 'budi.santoso@teacher.sch.id', NULL, '1', NULL, '2025-07-06 21:46:09', '2025-07-06 21:46:09');

DROP TABLE IF EXISTS `users_backup`;
CREATE TABLE `users_backup` (
  `id` int(11) unsigned NOT NULL DEFAULT 0,
  `role_id` int(11) unsigned NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(10) unsigned DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users_backup` VALUES 
('1', '1', NULL, '15', 'superadmin', '$2y$10$RG6rUXfhKK.1UKJFQ9twGeX0ZsTPOcp7gHN8lh9.zCni05/txdBWG', 'Super Administrator 23', 'superadmin@sekolah.com', 'profile_1_1751732094.png', '1', '2025-07-06 07:16:27', '2025-07-04 05:23:36', '2025-07-06 07:16:27'),
('2', '2', NULL, '15', 'guru_mtk', '$2y$10$lFLX2DoXMVss5UqueyIKv.qN59L4K3.797clZhuE.FPn4F3Bsk00.', 'Budi Santoso, S.Pd', 'budi.santoso@sekolah.com', NULL, '1', NULL, '2025-07-04 05:23:36', '2025-07-04 05:23:36'),
('3', '3', NULL, '15', 'wali_kelas_10a', '$2y$10$WM5paENC0iYp8FbGzlrVOeM5tg.Ynzjj39NM0hU87BAUOZh/M26PS', 'Siti Rahayu, S.Pd', 'siti.rahayu@sekolah.com', NULL, '1', NULL, '2025-07-04 05:23:37', '2025-07-04 05:23:37'),
('4', '4', NULL, '15', 'siswa_001', '$2y$10$6iNUxCzkMIn8hy9tTMkneeJhd3MgUa2kId6LzGWbm91BSNzeILyZm', 'Ahmad Rizki Pratama', 'ahmad.rizki@email.com', NULL, '1', NULL, '2025-07-04 05:23:37', '2025-07-04 05:23:37'),
('5', '5', NULL, '15', 'orangtua_001', '$2y$10$TIz7LR9JbaLiFQ8AyOt.H.6fTAGfO8s2WP/XV6IVbrQolVmOEr7Ei', 'Hadi Pratama', 'hadi.pratama@email.com', NULL, '1', NULL, '2025-07-04 05:23:38', '2025-07-04 05:23:38'),
('12', '4', '1', '15', 'siswa001', '$2y$10$t4a8wuOwaW2QK8Jowds/Lu1EVt5Otqgl1R/7lPuZWNnk5nwubpHRq', 'Ahmad Rizki', 'siswa001@example.com', NULL, '1', NULL, '2025-07-06 01:37:32', '2025-07-06 01:37:32'),
('13', '4', '1', '15', 'siswa002', '$2y$10$I72vdwtXqtfpc1lMke47y.IxOGRuciBb.iF6yW4YJP0ieylKfsmDO', 'Siti Fatimah', 'siswa002@example.com', NULL, '1', NULL, '2025-07-06 01:37:32', '2025-07-06 01:37:32'),
('14', '4', '2', '15', 'siswa003', '$2y$10$v741LvzUmvm4V5ZVj7KSPugZyUXOj06P6TmRbNsSNtbkfYQcR9SMO', 'Budi Santoso', 'siswa003@example.com', NULL, '1', NULL, '2025-07-06 01:37:32', '2025-07-06 01:37:32'),
('15', '4', '2', '15', 'siswa004', '$2y$10$1b1pebCUJoROeh6h8BLdDO5C3o3Lo6aNGfTfDR5J/A3GY9IqvJZ/2', 'Dewi Sartika', 'siswa004@example.com', NULL, '1', NULL, '2025-07-06 01:37:32', '2025-07-06 01:37:32'),
('16', '4', '3', '15', 'siswa005', '$2y$10$s1FZGmv7QNxNY1BNan2YpuGtGKnDpSt1csxeObEUUl7T7JAPR1kPO', 'Agus Prasetyo', 'siswa005@example.com', NULL, '1', NULL, '2025-07-06 01:37:32', '2025-07-06 01:37:32'),
('17', '16', NULL, '15', 'guru_matematika', '$2y$10$e5QO0/YtThiV.ofJmhjyb.IIbzkAQ56qCBT5/rpxtCzeRCXw1Qgdu', 'Budi Santoso, S.Pd', 'guru.matematika@sekolah.com', NULL, '1', NULL, '2025-07-06 02:18:05', '2025-07-06 02:18:05'),
('18', '16', NULL, '15', 'guru_bahasa', '$2y$10$YYKdq8psXvD616wiQ4O3aentaQUcjErdyw52U05W8KnbRpPCx6htS', 'Siti Aminah, S.Pd', 'guru.bahasa@sekolah.com', NULL, '1', NULL, '2025-07-06 02:18:06', '2025-07-06 02:18:06'),
('19', '16', NULL, '15', 'guru_ipa', '$2y$10$A8TRhbDUpXN32ULGS9W9YOeTR1WsVLqUifdE3Kr7f4KbwdYeVCkkS', 'Ahmad Fauzi, S.Si', 'guru.ipa@sekolah.com', NULL, '1', NULL, '2025-07-06 02:18:06', '2025-07-06 02:18:06'),
('20', '4', '12', '17', 'ahmad_budi', '$2y$10$PNFNk0hlL/Kx.7UAPIu.HuA.BfrBbIYZByV1i.jyUOHkO/wrv3afq', 'Ahmad Budi', 'ahmad.budi@student.sch.id', NULL, '1', NULL, '2025-07-06 21:46:08', '2025-07-06 17:47:35'),
('21', '4', NULL, '17', 'siti_nurhaliza', '$2y$10$4xNACzCnGLtfRzXhaEbNPust2rek9V/fM9XF7PVVBheOCbTLw.cVS', 'Siti Nurhaliza', 'siti.nurhaliza@student.sch.id', NULL, '1', NULL, '2025-07-06 21:46:08', '2025-07-06 21:46:08'),
('22', '4', NULL, '17', 'dimas_prakoso', '$2y$10$jCE.bk8ruQ20AAOmlFpzZ.Sa3/HNePb.DUr/VZ5FQkyqPnurLWPd2', 'Dimas Prakoso', 'dimas.prakoso@student.sch.id', NULL, '1', NULL, '2025-07-06 21:46:08', '2025-07-06 21:46:08'),
('23', '4', NULL, '17', 'lestari_indah', '$2y$10$z4b6WxD6ND8GHey3bJj1yu6GY584vthrjQNfzh3qoU0wLRspPPUz2', 'Lestari Indah', 'lestari.indah@student.sch.id', NULL, '1', NULL, '2025-07-06 21:46:09', '2025-07-06 21:46:09'),
('24', '4', NULL, '17', 'rizky_ferdiansyah', '$2y$10$e8nnW1gNE9irwNTIMciRR.VqYXpVHKomq7EygaRXMDVYnYjZ5PSIa', 'Rizky Ferdiansyah', 'rizky.ferdiansyah@student.sch.id', NULL, '1', NULL, '2025-07-06 21:46:09', '2025-07-06 21:46:09'),
('25', '16', NULL, '17', 'hermawan_guru', '$2y$10$jF3uuXH6u9VwELXMpQBOOOdi5kMMo2CQE9OHwKTFenfEBSSZS1T0u', 'Prof. Dr. Hermawan', 'hermawan@teacher.sch.id', NULL, '1', NULL, '2025-07-06 21:46:09', '2025-07-06 21:46:09'),
('26', '16', NULL, '17', 'sari_rahayu', '$2y$10$8f63d9pLEkiVBKTS7TfcMOhX4MMUqDEv3GzHNVxlVEPurKQ184tpO', 'Dr. Sari Rahayu', 'sari.rahayu@teacher.sch.id', NULL, '1', NULL, '2025-07-06 21:46:09', '2025-07-06 21:46:09'),
('27', '16', NULL, '17', 'budi_santoso', '$2y$10$0dIywmGvI/1At4AKChu0A.sC8byHwStgaKQ7WVfCfKrZdDGmG/yzK', 'Ir. Budi Santoso', 'budi.santoso@teacher.sch.id', NULL, '1', NULL, '2025-07-06 21:46:09', '2025-07-06 21:46:09');

SET FOREIGN_KEY_CHECKS=1;
