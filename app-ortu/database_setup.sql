-- Tabel untuk undangan orang tua
CREATE TABLE IF NOT EXISTS `parent_invitations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `parent_email` varchar(255) DEFAULT NULL,
  `parent_phone` varchar(20) DEFAULT NULL,
  `invitation_token` varchar(64) NOT NULL,
  `invited_by` int(11) NOT NULL COMMENT 'User ID Guru BK yang mengundang',
  `is_active` tinyint(1) DEFAULT 1,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `last_accessed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_token` (`invitation_token`),
  KEY `student_id` (`student_id`),
  KEY `invited_by` (`invited_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel untuk ringkasan yang dikurasi
CREATE TABLE IF NOT EXISTS `parent_summaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary_content` text NOT NULL,
  `positive_aspects` text DEFAULT NULL,
  `development_areas` text DEFAULT NULL,
  `teacher_notes` text DEFAULT NULL,
  `created_by` int(11) NOT NULL COMMENT 'User ID Guru BK',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel untuk rencana aksi
CREATE TABLE IF NOT EXISTS `action_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` enum('home','school','both') NOT NULL DEFAULT 'both',
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `status` enum('planned','in_progress','completed','paused') DEFAULT 'planned',
  `target_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel untuk progress rencana aksi
CREATE TABLE IF NOT EXISTS `action_progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_plan_id` int(11) NOT NULL,
  `progress_note` text NOT NULL,
  `progress_percentage` int(3) DEFAULT 0,
  `updated_by` int(11) NOT NULL,
  `update_source` enum('teacher','parent','system') DEFAULT 'teacher',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `action_plan_id` (`action_plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel untuk feedback orang tua
CREATE TABLE IF NOT EXISTS `parent_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invitation_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `feedback_text` text NOT NULL,
  `rating` int(1) DEFAULT NULL COMMENT '1-5 rating',
  `feedback_type` enum('general','action_plan','summary','system') DEFAULT 'general',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `invitation_id` (`invitation_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data untuk testing
INSERT INTO `parent_invitations` (`student_id`, `parent_name`, `parent_email`, `parent_phone`, `invitation_token`, `invited_by`, `expires_at`) VALUES
(1, 'Bapak Ahmad Wijaya', 'ahmad.wijaya@gmail.com', '081234567890', 'abc123def456ghi789jkl012mno345pqr678stu901vwx234yz567', 1, DATE_ADD(NOW(), INTERVAL 30 DAY)),
(2, 'Ibu Sari Handayani', 'sari.handayani@gmail.com', '081234567891', 'def456ghi789jkl012mno345pqr678stu901vwx234yz567abc123', 1, DATE_ADD(NOW(), INTERVAL 30 DAY));

INSERT INTO `parent_summaries` (`student_id`, `title`, `summary_content`, `positive_aspects`, `development_areas`, `teacher_notes`, `created_by`) VALUES
(1, 'Laporan Perkembangan Bulan Januari 2025', 'Siswa menunjukkan perkembangan yang sangat positif dalam aspek sosial dan akademik.', 'Antusias dalam diskusi, empati tinggi, konsisten tugas', 'Percaya diri presentasi, manajemen waktu', 'Potensi kepemimpinan yang baik, perlu dukungan keluarga', 1),
(2, 'Evaluasi Semester Ganjil', 'Progress pembelajaran menunjukkan tren positif dengan beberapa area yang perlu pengembangan.', 'Kreativitas tinggi, kerja sama baik, inisiatif positif', 'Fokus belajar, komunikasi verbal', 'Bakat seni yang menonjol, dapat dikembangkan lebih lanjut', 1);

INSERT INTO `action_plans` (`student_id`, `title`, `description`, `location`, `priority`, `status`, `created_by`) VALUES
(1, 'Peningkatan Kepercayaan Diri', 'Program untuk meningkatkan kepercayaan diri saat berbicara di depan umum', 'home', 'high', 'in_progress', 1),
(1, 'Pelatihan Public Speaking', 'Sesi latihan berbicara di depan kelas dengan metode bertahap', 'school', 'high', 'in_progress', 1),
(1, 'Manajemen Waktu Belajar', 'Membuat jadwal belajar yang terstruktur dan konsisten', 'home', 'medium', 'planned', 1),
(2, 'Pengembangan Fokus Belajar', 'Teknik meditasi sederhana dan lingkungan belajar kondusif', 'home', 'medium', 'in_progress', 1),
(2, 'Program Mentoring Seni', 'Bimbingan khusus untuk mengembangkan bakat seni visual', 'school', 'low', 'planned', 1);

INSERT INTO `action_progress` (`action_plan_id`, `progress_note`, `progress_percentage`, `updated_by`, `update_source`) VALUES
(1, 'Minggu pertama: Anak mulai berani bercerita saat makan malam. Antusiasme meningkat.', 60, 1, 'parent'),
(2, 'Sesi pertama public speaking berjalan baik. Siswa menunjukkan progress positif.', 40, 1, 'teacher'),
(4, 'Sudah mulai mencoba teknik pernapasan sebelum belajar. Hasil cukup positif.', 30, 1, 'parent');
