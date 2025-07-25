<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_name'];

    public function getAllRoles()
    {
        return $this->findAll();
    }
}
