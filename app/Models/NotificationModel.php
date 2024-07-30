<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'tb_notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'message', 'status', 'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;

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

    public function getUnreadNotificationsWithUserDetails($userId)
    {
        return $this->select('tb_notifications.*, sender.first_name as sender_first_name, sender.last_name as sender_last_name, receiver.first_name as receiver_first_name, receiver.last_name as receiver_last_name')
            ->join('users as sender', 'sender.id = tb_notifications.id')
            ->join('users as receiver', 'receiver.id = tb_notifications.user_id')
            ->where('tb_notifications.user_id', $userId)
            ->where('tb_notifications.status', 'unread')
            ->orderBy('tb_notifications.updated_at', 'DESC')
            ->findAll();
    }

    public function getUnreadNotificationsCount($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('status', 'unread')
                    ->countAllResults();
    }
}
