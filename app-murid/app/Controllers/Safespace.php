<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Safespace extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function dashboard()
    {
        // Redirect ke konsul-cepat karena dashboard dihapus
        return redirect()->to(base_url('safe-space/konsul-cepat'));
    }

    public function konsulCepat()
    {
        $data = $this->getViewData();
        $data['currentUrl'] = $this->getCurrentUrl();
        return view('safe_space/konsul_cepat', $data);
    }

    public function jadwalKonseling()
    {
        $data = $this->getViewData();
        return view('safe_space/jadwal_konseling', $data);
    }

    public function jurnalDigital()
    {
        $data = $this->getViewData();
        return view('safe_space/jurnal_digital', $data);
    }

    public function pusatInformasi()
    {
        $data = $this->getViewData();
        return view('safe_space/pusat_informasi', $data);
    }

    public function testUrl()
    {
        $data = $this->getViewData();
        $data['currentUrl'] = $this->getCurrentUrl();
        return view('test_url', $data);
    }

    public function allNotificationsDemo()
    {
        $data = $this->getViewData();
        $data['title'] = 'Demo Notifikasi - Safe Space';
        return view('safe_space/all_notifications_demo', $data);
    }

    public function notificationOverview()
    {
        $data = $this->getViewData();
        $data['title'] = 'Overview Notifikasi - Safe Space';
        return view('safe_space/notification_overview', $data);
    }

    // API Methods
    public function sendMessage()
    {
        $input = $this->request->getJSON(true);
        $message = $input['message'] ?? '';
        $anonymous = $input['anonymous'] ?? false;
        
        $response = [
            'status' => 'success',
            'data' => [
                'id' => uniqid(),
                'message' => $message,
                'sender' => $anonymous ? 'Anonim' : ($this->session->get('nama') ?? 'User'),
                'timestamp' => date('H:i'),
                'bot_response' => $this->generateBotResponse($message)
            ]
        ];
        
        return $this->response->setJSON($response);
    }

    public function saveMood()
    {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Mood disimpan']);
    }

    public function saveJournalEntry()
    {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Jurnal disimpan']);
    }

    public function requestCounseling()
    {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Permintaan konseling dikirim']);
    }

    public function getMoodHistory()
    {
        return $this->response->setJSON(['status' => 'success', 'data' => []]);
    }

    public function getJournalEntries()
    {
        return $this->response->setJSON(['status' => 'success', 'data' => []]);
    }

    public function getAvailableSlots()
    {
        return $this->response->setJSON(['status' => 'success', 'data' => []]);
    }

    public function getCounselingHistory()
    {
        return $this->response->setJSON(['status' => 'success', 'data' => []]);
    }

    public function getInfoContent()
    {
        return $this->response->setJSON(['status' => 'success', 'data' => []]);
    }

    public function searchContent()
    {
        return $this->response->setJSON(['status' => 'success', 'data' => []]);
    }

    public function deleteJournal($id)
    {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Jurnal dihapus']);
    }

    public function updateJournal($id)
    {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Jurnal diperbarui']);
    }

    public function favoriteContent()
    {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Konten difavoritkan']);
    }

    // Helper Methods
    private function getViewData()
    {
        return [
            'title' => 'Safe Space',
            'currentUrl' => $this->getCurrentUrl(),
            'isLoggedIn' => $this->session->get('isLoggedIn') ?? false,
            'nama' => $this->session->get('nama') ?? 'Guest',
            'role' => $this->session->get('role') ?? 'guest'
        ];
    }

    private function getCurrentUrl()
    {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $port = $_SERVER['SERVER_PORT'] ?? '80';
        
        // Get hostname without port
        $host = $_SERVER['SERVER_NAME'] ?? 'localhost';
        if (isset($_SERVER['HTTP_HOST'])) {
            $hostParts = explode(':', $_SERVER['HTTP_HOST']);
            $host = $hostParts[0];
        }
        
        // Dynamic URL based on server configuration
        if ($port == '8080') {
            return $protocol . '://' . $host . ':8080';
        } elseif ($port == '80' && $protocol == 'http') {
            return $protocol . '://' . $host . '/simaklah-main/app-murid/public';
        } elseif ($port == '443' && $protocol == 'https') {
            return $protocol . '://' . $host . '/simaklah-main/app-murid/public';
        } else {
            return $protocol . '://' . $host . ':' . $port . '/simaklah-main/app-murid/public';
        }
    }

    private function generateBotResponse($message)
    {
        $responses = [
            'Terima kasih sudah berbagi. Bagaimana perasaan Anda sekarang?',
            'Saya mendengarkan Anda. Ceritakan lebih detail jika Anda mau.',
            'Itu terdengar sulit. Apa yang bisa membantu Anda merasa lebih baik?',
            'Anda tidak sendirian. Kami di sini untuk mendukung Anda.',
            'Bagaimana jika kita coba mencari solusi bersama-sama?'
        ];
        
        return $responses[array_rand($responses)];
    }
}
