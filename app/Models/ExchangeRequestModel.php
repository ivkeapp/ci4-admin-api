<?php

namespace App\Models;

use CodeIgniter\Model;

class ExchangeRequestModel extends Model
{
    protected $table            = 'exchange_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'sender_id',
        'receiver_id',
        'album_id',
        'cards_offered',
        'cards_requested',
        'status',
        'updated_at',
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

    public function getLimitedPendingExchangeRequests($userId, $limit = 5)
    {
        return $this->where('receiver_id', $userId)
            ->where('status =', 'pending')
            ->orderBy('updated_at', 'DESC')
            ->findAll($limit);
    }
    public function getExchangeRequests($userId)
    {
        return $this->where('receiver_id', $userId)
            ->where('status !=', 'deleted')
            ->orderBy('FIELD(status, "pending", "accepted", "desclined") ASC')
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    }
    public function getPendingExchangeRequestCount($userId)
    {
        return $this->where('receiver_id', $userId)
            ->where('status', 'pending')
            ->countAllResults();
    }
    public function getAllExchangeRequests($userId) {
        return $this->where('receiver_id', $userId)
                    ->where('status !=', 'deleted')
                    ->findAll();
    }
}
