<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['user_id', 'action_type', 'description', 'metadata', 'created_at'];

    protected bool $allowEmptyInserts = false;

    const ACTIVITY_LOGIN = 'login';
    const ACTIVITY_LOGOUT = 'logout';
    const ACTIVITY_PAGE_VISITED = 'page_visited';
    const ACTIVITY_USER_ADDED = 'user_added';
    const ACTIVITY_PAGE_ADDED = 'page_added';

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Log a new activity in the database.
     *
     * @param int|null $userId The ID of the user performing the action.
     * @param string $actionType The type of action being logged.
     * @param string $description A description of the action.
     * @param array|null $metadata Optional metadata about the action.
     * @return bool True on success, false on failure.
    */
    public function logActivity($userId, $actionType, $description, $metadata = null)
    {
        $data = [
            'user_id' => $userId,
            'action_type' => $actionType,
            'description' => $description,
            'metadata' => $metadata ? json_encode($metadata) : null, // Encode metadata as JSON
        ];

        return $this->insert($data);
    }
}
