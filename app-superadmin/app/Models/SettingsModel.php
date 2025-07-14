<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'system_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'setting_key', 'setting_value', 'description'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get a setting value by key
     */
    public function getSetting($key, $default = null)
    {
        $setting = $this->where('setting_key', $key)->first();
        return $setting ? $setting['setting_value'] : $default;
    }

    /**
     * Update or create a setting
     */
    public function updateSetting($key, $value, $description = null)
    {
        $existing = $this->where('setting_key', $key)->first();

        if ($existing) {
            return $this->update($existing['id'], [
                'setting_value' => $value,
                'description' => $description ?? $existing['description']
            ]);
        } else {
            return $this->insert([
                'setting_key' => $key,
                'setting_value' => $value,
                'description' => $description
            ]);
        }
    }

    /**
     * Get active school year ID
     */
    public function getActiveSchoolYearId()
    {
        return $this->getSetting('active_school_year_id', 2);
    }

    /**
     * Get active school year info
     */
    public function getActiveSchoolYear()
    {
        $activeId = $this->getActiveSchoolYearId();
        $schoolYearModel = new \App\Models\TahunAjaranModel();
        return $schoolYearModel->find($activeId);
    }
}
