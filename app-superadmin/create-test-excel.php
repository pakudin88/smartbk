<?php
/**
 * Script sederhana untuk membuat file Excel test import orang tua
 * Jalankan dari folder app-superadmin agar bisa menggunakan vendor PHPSpreadsheet
 */

require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers
    $headers = [
        'A1' => 'Username',
        'B1' => 'Email',
        'C1' => 'Password',
        'D1' => 'Nama Lengkap',
        'E1' => 'Hubungan Keluarga',
        'F1' => 'Jenis Kelamin (L/P)',
        'G1' => 'Nomor Telepon',
        'H1' => 'Pekerjaan',
        'I1' => 'Pendidikan',
        'J1' => 'Penghasilan',
        'K1' => 'Alamat',
        'L1' => 'Daftar NISN Anak (pisahkan dengan koma)'
    ];

    // Apply headers
    foreach ($headers as $cell => $value) {
        $sheet->setCellValue($cell, $value);
        $sheet->getStyle($cell)->getFont()->setBold(true);
        $sheet->getStyle($cell)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E2E8F0');
    }

    // Set column widths
    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(25);
    $sheet->getColumnDimension('C')->setWidth(12);
    $sheet->getColumnDimension('D')->setWidth(25);
    $sheet->getColumnDimension('E')->setWidth(20);
    $sheet->getColumnDimension('F')->setWidth(15);
    $sheet->getColumnDimension('G')->setWidth(15);
    $sheet->getColumnDimension('H')->setWidth(20);
    $sheet->getColumnDimension('I')->setWidth(20);
    $sheet->getColumnDimension('J')->setWidth(15);
    $sheet->getColumnDimension('K')->setWidth(30);
    $sheet->getColumnDimension('L')->setWidth(40);

    // Data test dengan NISN umum yang mungkin ada
    $testData = [
        ['test_ayah1', 'ayah1@test.com', 'password123', 'Bapak Ahmad', 'Ayah', 'L', '081234567890', 'Pegawai Swasta', 'S1', '2-5 Juta', 'Jl. Merdeka No. 123', '123456,123457'],
        ['test_ibu1', 'ibu1@test.com', 'password123', 'Ibu Sari', 'Ibu', 'P', '081234567891', 'Ibu Rumah Tangga', 'SMA', '< 1 Juta', 'Jl. Sudirman No. 456', '123458'],
        ['test_wali1', 'wali1@test.com', 'password123', 'Pak Budi', 'Wali', 'L', '081234567892', 'Pensiunan', 'S2', '5-10 Juta', 'Jl. Gatot Subroto No. 789', '123459,123460'],
        ['test_ibu2', 'ibu2@test.com', 'password123', 'Ibu Devi', 'Ibu', 'P', '081234567893', 'Guru', 'S1', '2-5 Juta', 'Jl. Diponegoro No. 321', '123461'],
        ['test_ayah2', 'ayah2@test.com', 'password123', 'Bapak Eko', 'Ayah', 'L', '081234567894', 'Wiraswasta', 'SMA', '1-2 Juta', 'Jl. Thamrin No. 654', ''],
        ['test_wali2', 'wali2@test.com', 'password123', 'Nenek Siti', 'Wali', 'P', '081234567895', 'Pensiunan', 'SD', '< 1 Juta', 'Jl. Pahlawan No. 111', '123462,123463,123464']
    ];

    // Insert test data
    $row = 2;
    foreach ($testData as $data) {
        $col = 'A';
        foreach ($data as $value) {
            $sheet->setCellValue($col . $row, $value);
            $col++;
        }
        $row++;
    }

    // Add notes sheet
    $notesSheet = $spreadsheet->createSheet();
    $notesSheet->setTitle('CATATAN');
    $notesSheet->setCellValue('A1', 'CATATAN UNTUK TESTING:');
    $notesSheet->getStyle('A1')->getFont()->setBold(true);
    
    $notes = [
        'A3' => '1. File ini dibuat untuk testing fitur import orang tua dengan hubungan anak',
        'A4' => '2. NISN dalam kolom L mungkin tidak sesuai dengan data murid di database',
        'A5' => '3. Jika NISN tidak ditemukan, akan ada pesan error tapi orang tua tetap diimport',
        'A6' => '4. Untuk testing real, sesuaikan NISN dengan data murid yang ada di database',
        'A7' => '5. Fitur ini akan:',
        'A8' => '   - Import data orang tua ke tabel orang_tua',
        'A9' => '   - Menghubungkan orang tua dengan murid di tabel orang_tua_murid',
        'A10' => '   - Memberikan laporan hasil import termasuk error jika ada',
        'A11' => '',
        'A12' => 'Contoh NISN yang digunakan dalam file ini:',
        'A13' => '123456, 123457, 123458, 123459, 123460, 123461, 123462, 123463, 123464',
        'A14' => '',
        'A15' => 'Untuk melihat NISN yang tersedia, cek tabel murid di database',
    ];
    
    foreach ($notes as $cell => $value) {
        $notesSheet->setCellValue($cell, $value);
    }
    
    $notesSheet->getColumnDimension('A')->setWidth(80);

    // Save file
    $writer = new Xlsx($spreadsheet);
    $filename = '../test_import_orang_tua_dengan_anak.xlsx';
    $writer->save($filename);
    
    echo "File test '{$filename}' berhasil dibuat!\n";
    echo "File ini berisi 6 data orang tua dengan berbagai kondisi hubungan anak:\n\n";
    echo "1. Bapak Ahmad (Ayah) - 2 anak (NISN: 123456, 123457)\n";
    echo "2. Ibu Sari (Ibu) - 1 anak (NISN: 123458)\n";
    echo "3. Pak Budi (Wali) - 2 anak (NISN: 123459, 123460)\n";
    echo "4. Ibu Devi (Ibu) - 1 anak (NISN: 123461)\n";
    echo "5. Bapak Eko (Ayah) - Tanpa anak\n";
    echo "6. Nenek Siti (Wali) - 3 anak (NISN: 123462, 123463, 123464)\n\n";
    echo "LANGKAH SELANJUTNYA:\n";
    echo "1. Buka http://localhost:8080/pengguna-orang-tua\n";
    echo "2. Klik 'Import Excel'\n";
    echo "3. Upload file test_import_orang_tua_dengan_anak.xlsx\n";
    echo "4. Periksa hasil import dan hubungan orang tua-anak\n\n";
    echo "CATATAN: Jika NISN tidak ada di database, akan ada error message\n";
    echo "tapi orang tua tetap akan diimport.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
