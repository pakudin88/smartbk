<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Notification extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    // Get all notifications for current user
    public function getNotifications()
    {
        // Simulate notifications - in real app, this would come from database
        $notifications = [
            [
                'id' => 1,
                'type' => 'chat',
                'title' => 'Pesan Baru dari Konselor',
                'message' => 'Anda memiliki balasan baru dari konselor di Safe Space',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-2 minutes')),
                'read' => false,
                'icon' => 'fas fa-comments',
                'color' => 'primary',
                'url' => '/safe-space/konsul-cepat'
            ],
            [
                'id' => 2,
                'type' => 'approval',
                'title' => 'Jadwal Konseling Disetujui',
                'message' => 'Jadwal konseling Anda untuk tanggal 15 Juli 2025 telah disetujui',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-10 minutes')),
                'read' => false,
                'icon' => 'fas fa-calendar-check',
                'color' => 'success',
                'url' => '/safe-space/jadwal-konseling'
            ],
            [
                'id' => 3,
                'type' => 'activity',
                'title' => 'Kegiatan Baru Tersedia',
                'message' => 'Workshop "Mengelola Stress" telah dibuka untuk pendaftaran',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
                'read' => true,
                'icon' => 'fas fa-calendar-plus',
                'color' => 'info',
                'url' => '/safe-space/pusat-informasi'
            ],
            [
                'id' => 4,
                'type' => 'journal',
                'title' => 'Reminder Jurnal Harian',
                'message' => 'Jangan lupa untuk mengisi jurnal digital Anda hari ini',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                'read' => true,
                'icon' => 'fas fa-book',
                'color' => 'warning',
                'url' => '/safe-space/jurnal-digital'
            ]
        ];

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $notifications,
            'unread_count' => count(array_filter($notifications, function($n) { return !$n['read']; }))
        ]);
    }

    // Mark notification as read
    public function markAsRead()
    {
        $input = $this->request->getJSON(true);
        $notificationId = $input['id'] ?? null;
        
        // In real app, update database
        // UPDATE notifications SET read = 1 WHERE id = $notificationId AND user_id = $currentUserId
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Notifikasi ditandai sebagai sudah dibaca'
        ]);
    }

    // Mark all notifications as read
    public function markAllAsRead()
    {
        // In real app, update all unread notifications for current user
        // UPDATE notifications SET read = 1 WHERE user_id = $currentUserId AND read = 0
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Semua notifikasi ditandai sebagai sudah dibaca'
        ]);
    }

    // Get real-time updates (for SSE or polling)
    public function getUpdates()
    {
        // This would typically check for new notifications since last check
        $lastCheck = $this->request->getGet('since') ?? date('Y-m-d H:i:s', strtotime('-1 minute'));
        
        // Simulate new notifications
        $newNotifications = [];
        
        // Random chance of new notification (for demo)
        if (rand(1, 10) > 7) {
            $newNotifications[] = [
                'id' => rand(100, 999),
                'type' => 'chat',
                'title' => 'Pesan Baru Masuk',
                'message' => 'Konselor telah membalas pesan Anda',
                'timestamp' => date('Y-m-d H:i:s'),
                'read' => false,
                'icon' => 'fas fa-comments',
                'color' => 'primary',
                'url' => '/safe-space/konsul-cepat'
            ];
        }
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $newNotifications,
            'has_new' => !empty($newNotifications)
        ]);
    }

    // Send test notification (for testing purposes)
    public function sendTestNotification()
    {
        $types = ['chat', 'approval', 'activity', 'journal'];
        $type = $types[array_rand($types)];
        
        $messages = [
            'chat' => ['title' => 'Pesan Chat Baru', 'message' => 'Anda memiliki pesan baru dari konselor'],
            'approval' => ['title' => 'Kegiatan Disetujui', 'message' => 'Permintaan konseling Anda telah disetujui'],
            'activity' => ['title' => 'Kegiatan Baru', 'message' => 'Ada kegiatan baru yang mungkin Anda minati'],
            'journal' => ['title' => 'Reminder Jurnal', 'message' => 'Waktunya mengisi jurnal harian Anda']
        ];
        
        $notification = [
            'id' => rand(1000, 9999),
            'type' => $type,
            'title' => $messages[$type]['title'],
            'message' => $messages[$type]['message'],
            'timestamp' => date('Y-m-d H:i:s'),
            'read' => false,
            'icon' => 'fas fa-bell',
            'color' => 'primary',
            'url' => '/safe-space/dashboard'
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $notification,
            'message' => 'Test notification sent'
        ]);
    }
}
