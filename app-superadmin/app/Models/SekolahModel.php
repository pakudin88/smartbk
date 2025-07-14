<?php

namespace App\Models;

use CodeIgniter\Model;

class SekolahModel extends Model
{
    protected $table = 'sekolah';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_sekolah', 'alamat', 'telepon', 'email', 'kepala_sekolah', 'npsn', 'status', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_sekolah' => 'required|min_length[3]|max_length[100]',
        'alamat' => 'required|min_length[10]|max_length[255]',
        'telepon' => 'required|min_length[10]|max_length[15]',
        'email' => 'required|valid_email',
        'kepala_sekolah' => 'required|min_length[3]|max_length[100]',
        'npsn' => 'required|min_length[8]|max_length[8]',
        'status' => 'required|in_list[aktif,nonaktif]'
    ];

    protected $validationMessages = [
        'nama_sekolah' => [
            'required' => 'Nama sekolah harus diisi',
            'min_length' => 'Nama sekolah minimal 3 karakter',
            'max_length' => 'Nama sekolah maksimal 100 karakter'
        ],
        'alamat' => [
            'required' => 'Alamat harus diisi',
            'min_length' => 'Alamat minimal 10 karakter',
            'max_length' => 'Alamat maksimal 255 karakter'
        ],
        'telepon' => [
            'required' => 'Telepon harus diisi',
            'min_length' => 'Telepon minimal 10 karakter',
            'max_length' => 'Telepon maksimal 15 karakter'
        ],
        'email' => [
            'required' => 'Email harus diisi',
            'valid_email' => 'Format email tidak valid'
        ],
        'kepala_sekolah' => [
            'required' => 'Nama kepala sekolah harus diisi',
            'min_length' => 'Nama kepala sekolah minimal 3 karakter',
            'max_length' => 'Nama kepala sekolah maksimal 100 karakter'
        ],
        'npsn' => [
            'required' => 'NPSN harus diisi',
            'min_length' => 'NPSN harus 8 karakter',
            'max_length' => 'NPSN harus 8 karakter'
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list' => 'Status harus aktif atau nonaktif'
        ]
    ];

    public function getActiveSchools()
    {
        return $this->where('status', 'aktif')->findAll();
    }

    public function getSchoolById($id)
    {
        return $this->find($id);
    }

    public function getSchoolByNpsn($npsn)
    {
        return $this->where('npsn', $npsn)->first();
    }

    public function getSchoolStats()
    {
        $stats = [
            'total' => $this->countAll(),
            'aktif' => $this->where('status', 'aktif')->countAllResults(),
            'nonaktif' => $this->where('status', 'nonaktif')->countAllResults()
        ];

        return $stats;
    }
}
