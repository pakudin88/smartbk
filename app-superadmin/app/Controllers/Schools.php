<?php

namespace App\Controllers;

use App\Models\SekolahModel;
use App\Controllers\BaseController;

class Schools extends BaseController
{
    protected $sekolahModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
    }

    public function index()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Data Sekolah',
            'schools' => $this->sekolahModel->findAll(),
            'user' => $this->getUserDataForView()
        ];

        return view('schools/index', $data);
    }

    public function create()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Tambah Sekolah',
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('schools/create', $data);
    }

    public function store()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $rules = [
            'nama_sekolah' => 'required|min_length[3]|max_length[100]',
            'alamat' => 'required|min_length[10]|max_length[255]',
            'telepon' => 'required|min_length[10]|max_length[15]',
            'email' => 'required|valid_email',
            'kepala_sekolah' => 'required|min_length[3]|max_length[100]',
            'npsn' => 'required|min_length[8]|max_length[8]|is_unique[sekolah.npsn]',
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'kepala_sekolah' => $this->request->getPost('kepala_sekolah'),
            'npsn' => $this->request->getPost('npsn'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->sekolahModel->insert($data)) {
            return redirect()->to('/schools')->with('success', 'Data sekolah berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data sekolah!');
        }
    }

    public function edit($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $school = $this->sekolahModel->find($id);

        if (!$school) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data sekolah tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Sekolah',
            'school' => $school,
            'validation' => \Config\Services::validation(),
            'user' => $this->getUserDataForView()
        ];

        return view('schools/edit', $data);
    }

    public function update($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $school = $this->sekolahModel->find($id);

        if (!$school) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data sekolah tidak ditemukan');
        }

        $rules = [
            'nama_sekolah' => 'required|min_length[3]|max_length[100]',
            'alamat' => 'required|min_length[10]|max_length[255]',
            'telepon' => 'required|min_length[10]|max_length[15]',
            'email' => 'required|valid_email',
            'kepala_sekolah' => 'required|min_length[3]|max_length[100]',
            'npsn' => "required|min_length[8]|max_length[8]|is_unique[sekolah.npsn,id,{$id}]",
            'status' => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'kepala_sekolah' => $this->request->getPost('kepala_sekolah'),
            'npsn' => $this->request->getPost('npsn'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->sekolahModel->update($id, $data)) {
            return redirect()->to('/schools')->with('success', 'Data sekolah berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data sekolah!');
        }
    }

    public function delete($id)
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $school = $this->sekolahModel->find($id);

        if (!$school) {
            return redirect()->to('/schools')->with('error', 'Data sekolah tidak ditemukan!');
        }

        if ($this->sekolahModel->delete($id)) {
            return redirect()->to('/schools')->with('success', 'Data sekolah berhasil dihapus!');
        } else {
            return redirect()->to('/schools')->with('error', 'Gagal menghapus data sekolah!');
        }
    }
}
