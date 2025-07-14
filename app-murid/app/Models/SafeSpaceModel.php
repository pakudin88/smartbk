<?php

namespace App\Models;

use CodeIgniter\Model;

class SafeSpaceModel extends Model
{
    protected $table = 'safe_space_messages';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'student_id', 'teacher_id', 'message', 'is_anonymous', 
        'is_read', 'reply_message', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function __construct()
    {
        parent::__construct();
        
        // Ensure database connection is established
        $this->db = \Config\Database::connect();
    }

    // Get messages for specific student
    public function getMessagesByStudent($studentId, $limit = 50)
    {
        return $this->where('student_id', $studentId)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    // Get unread messages count
    public function getUnreadCount($studentId)
    {
        return $this->where('student_id', $studentId)
                   ->where('is_read', 0)
                   ->where('reply_message IS NOT NULL')
                   ->countAllResults();
    }

    // Mark message as read
    public function markAsRead($messageId)
    {
        return $this->update($messageId, ['is_read' => 1]);
    }

    // Send anonymous message
    public function sendAnonymousMessage($studentId, $message)
    {
        return $this->insert([
            'student_id' => $studentId,
            'message' => $message,
            'is_anonymous' => 1,
            'is_read' => 0
        ]);
    }

    // Send regular message
    public function sendMessage($studentId, $message)
    {
        return $this->insert([
            'student_id' => $studentId,
            'message' => $message,
            'is_anonymous' => 0,
            'is_read' => 0
        ]);
    }
}

class MoodTrackerModel extends Model
{
    protected $table = 'mood_tracker';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'student_id', 'mood', 'mood_level', 'note', 'date', 'created_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    // Get mood history for student
    public function getMoodHistory($studentId, $days = 30)
    {
        return $this->where('student_id', $studentId)
                   ->where('date >=', date('Y-m-d', strtotime("-{$days} days")))
                   ->orderBy('date', 'DESC')
                   ->findAll();
    }

    // Save daily mood
    public function saveDailyMood($studentId, $mood, $moodLevel, $note = '')
    {
        $today = date('Y-m-d');
        
        // Check if mood already exists for today
        $existing = $this->where('student_id', $studentId)
                        ->where('date', $today)
                        ->first();
        
        $data = [
            'student_id' => $studentId,
            'mood' => $mood,
            'mood_level' => $moodLevel,
            'note' => $note,
            'date' => $today
        ];

        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            return $this->insert($data);
        }
    }

    // Get mood statistics
    public function getMoodStats($studentId, $days = 7)
    {
        $moods = $this->where('student_id', $studentId)
                     ->where('date >=', date('Y-m-d', strtotime("-{$days} days")))
                     ->findAll();

        $stats = [
            'total_entries' => count($moods),
            'average_level' => 0,
            'most_common_mood' => '',
            'mood_distribution' => []
        ];

        if (count($moods) > 0) {
            $totalLevel = array_sum(array_column($moods, 'mood_level'));
            $stats['average_level'] = round($totalLevel / count($moods), 1);

            $moodCounts = array_count_values(array_column($moods, 'mood'));
            arsort($moodCounts);
            $stats['most_common_mood'] = key($moodCounts);
            $stats['mood_distribution'] = $moodCounts;
        }

        return $stats;
    }
}

class JournalModel extends Model
{
    protected $table = 'digital_journal';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'student_id', 'title', 'content', 'is_private', 'shared_with_bk', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get journal entries for student
    public function getJournalEntries($studentId, $limit = 20)
    {
        return $this->where('student_id', $studentId)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    // Save journal entry
    public function saveEntry($studentId, $title, $content, $isPrivate = true)
    {
        return $this->insert([
            'student_id' => $studentId,
            'title' => $title,
            'content' => $content,
            'is_private' => $isPrivate ? 1 : 0,
            'shared_with_bk' => 0
        ]);
    }

    // Share entry with BK teacher
    public function shareWithBK($entryId)
    {
        return $this->update($entryId, ['shared_with_bk' => 1]);
    }

    // Get entries shared with BK
    public function getSharedEntries($studentId)
    {
        return $this->where('student_id', $studentId)
                   ->where('shared_with_bk', 1)
                   ->orderBy('updated_at', 'DESC')
                   ->findAll();
    }
}

class CounselingRequestModel extends Model
{
    protected $table = 'counseling_requests';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'student_id', 'teacher_id', 'request_date', 'request_time', 
        'session_type', 'topic', 'status', 'notes', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get counseling requests for student
    public function getRequestsByStudent($studentId)
    {
        return $this->where('student_id', $studentId)
                   ->orderBy('request_date', 'DESC')
                   ->findAll();
    }

    // Create new counseling request
    public function createRequest($studentId, $date, $time, $type, $topic)
    {
        return $this->insert([
            'student_id' => $studentId,
            'request_date' => $date,
            'request_time' => $time,
            'session_type' => $type,
            'topic' => $topic,
            'status' => 'pending'
        ]);
    }

    // Get available time slots (mock data for now)
    public function getAvailableSlots($date)
    {
        $slots = [
            '08:00', '09:00', '10:00', '11:00', 
            '13:00', '14:00', '15:00', '16:00'
        ];

        // Get booked slots for the date
        $bookedSlots = $this->where('request_date', $date)
                           ->where('status !=', 'cancelled')
                           ->findColumn('request_time');

        return array_diff($slots, $bookedSlots);
    }

    // Update request status
    public function updateStatus($requestId, $status, $notes = '')
    {
        return $this->update($requestId, [
            'status' => $status,
            'notes' => $notes
        ]);
    }
}
