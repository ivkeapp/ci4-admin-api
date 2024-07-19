<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table            = 'messages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sender_user_id', 
        'receiver_user_id', 
        'status', 
        'content', 
        'timestamp', 
        'status_timestamp'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
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

    public function getAllMessages($userId)
    {
        return $this->where('receiver_user_id', $userId)
                    ->orderBy('FIELD(status, "unread", "read", "replied") DESC, timestamp DESC')
                    ->findAll();
    }

    public function getLimitedUnreadMessages($userId, $limit = 5)
    {
        return $this->select('messages.*, users.first_name, users.last_name')
            ->join('users', 'users.id = messages.sender_user_id')
            ->where('messages.receiver_user_id', $userId)
            ->orderBy('FIELD(messages.status, "unread", "read", "replied") ASC, messages.timestamp DESC')
            ->orderBy('messages.timestamp', 'DESC')
            ->findAll($limit);
    }

    public function getUserMessages($userId)
    {
        return $this->where('receiver_user_id', $userId)
                    ->orderBy('timestamp', 'DESC')
                    ->findAll();
    }
    
}
