<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MuridModel;

class Profile extends BaseController
{
    protected $session;
    protected $muridModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->muridModel = new MuridModel();

        // Check if user is logged in
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'murid') {
            header('Location: ' . base_url('/login'));
            exit();
        }
    }

    /**
     * Display profile page
     */
    public function index()
    {
        $userId = $this->session->get('user_id');
        $muridData = $this->muridModel->getMuridWithDetails($userId);

        $data = [
            'title' => 'Profil Saya - Aplikasi Murid',
            'current_url' => $this->getCurrentUrlForView(),
            'murid' => $muridData,
            'user' => [
                'username' => $this->session->get('username'),
                'email' => $this->session->get('email'),
                'name' => $this->session->get('nama_lengkap') ?? $this->session->get('name')
            ]
        ];

        return view('profile/index', $data);
    }

    /**
     * Update profile data
     */
    public function update()
    {
        $userId = $this->session->get('user_id');

        // Get form data
        $data = [
            'alamat' => $this->request->getPost('alamat'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'email' => $this->request->getPost('email')
        ];

        // Remove empty values
        $data = array_filter($data, function($value) {
            return !empty($value);
        });

        if (!empty($data)) {
            $result = $this->muridModel->updateProfile($userId, $data);

            if ($result) {
                // Update session email if changed
                if (isset($data['email'])) {
                    $this->session->set('email', $data['email']);
                }

                return redirect()->back()->with('success', 'Profil berhasil diperbarui');
            } else {
                return redirect()->back()->with('error', 'Gagal memperbarui profil');
            }
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang diperbarui');
        }
    }

    /**
     * Upload profile photo
     */
    public function uploadPhoto()
    {
        $userId = $this->session->get('user_id');
        $file = $this->request->getFile('foto');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate file type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = $file->getClientExtension();

            if (!in_array(strtolower($fileExtension), $allowedTypes)) {
                return redirect()->back()->with('error', 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF');
            }

            // Validate file size (max 2MB)
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimal 2MB');
            }

            // Generate unique filename
            $fileName = 'murid_' . $userId . '_' . time() . '.' . $fileExtension;

            // Create upload directory if not exists
            $uploadPath = FCPATH . 'uploads/photos/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Move file
            if ($file->move($uploadPath, $fileName)) {
                // Update database
                $result = $this->muridModel->updateProfile($userId, ['foto' => $fileName]);

                if ($result) {
                    // Update session
                    $this->session->set('foto', $fileName);
                    return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
                } else {
                    // Delete uploaded file if database update fails
                    unlink($uploadPath . $fileName);
                    return redirect()->back()->with('error', 'Gagal menyimpan foto ke database');
                }
            } else {
                return redirect()->back()->with('error', 'Gagal mengupload foto');
            }
        } else {
            return redirect()->back()->with('error', 'File tidak valid');
        }
    }
}
