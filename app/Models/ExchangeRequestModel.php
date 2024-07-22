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
        'sender_completed',
        'receiver_completed',
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
        return $this->select('exchange_requests.*, users.first_name, users.last_name')
            ->join('users', 'users.id = exchange_requests.sender_id')
            ->where('exchange_requests.receiver_id', $userId)
            ->where('exchange_requests.status =', 'pending')
            ->orderBy('exchange_requests.updated_at', 'DESC')
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
        return $this->select('exchange_requests.*, users.first_name, users.last_name')
        ->join('users', 'users.id = exchange_requests.sender_id')
        ->where('exchange_requests.receiver_id', $userId)
        ->where('exchange_requests.status !=', 'deleted')
        ->findAll();
    }
    public function getAllSentExchangeRequests($userId) {
        return $this->select('exchange_requests.*, users.first_name, users.last_name')
        ->join('users', 'users.id = exchange_requests.receiver_id')
        ->where('exchange_requests.sender_id', $userId)
        ->where('exchange_requests.status !=', 'deleted')
        ->findAll();
    }
    public function markAsCompleted($requestId, $userId)
    {
        // Retrieve the request to check if the user is the sender or the receiver
        $request = $this->find($requestId);
        if (!$request) {
            return false; // Request not found
        }
        log_message('debug', 'USER_ID: ' . print_r($userId, true));
        log_message('debug', 'REQUEST_ID: ' . print_r($requestId, true));
        log_message('debug', 'REQUEST: ' . print_r($request, true));
        $updateData = [];
        if ($request['sender_id'] == $userId && !$request['sender_completed']) {
            $updateData['sender_completed'] = 1; // Use 1 for true
        } elseif ($request['receiver_id'] == $userId && !$request['receiver_completed']) {
            $updateData['receiver_completed'] = 1; // Use 1 for true
        }

        log_message('debug', 'Update Data: ' . print_r($updateData, true));
        if (!empty($updateData)) {
            $this->update($requestId, $updateData);
        } else {
            log_message('error', 'Attempted to update with empty data.');
            return false; // No update needed
        }

        // Re-fetch the request to check if both have marked it as completed
        $request = $this->find($requestId);
        if ($request['sender_completed'] && $request['receiver_completed']) {
            $this->update($requestId, ['status' => 'completed', 'completed' => 1]); // Ensure 'completed' is also set correctly if needed
        }

        return true;
    }
    public function isRequestCompletedByUser($requestId, $userId)
    {
        $request = $this->find($requestId);
        if (!$request) {
            return false; // Request not found
        }
    
        if ($request['sender_id'] == $userId) {
            return $request['sender_completed'];
        } elseif ($request['receiver_id'] == $userId) {
            return $request['receiver_completed'];
        }
    
        return false; // User is neither sender nor receiver
    }
    public function isRequestFullyCompleted($requestId)
    {
        $request = $this->find($requestId);
        if (!$request) {
            return false; // Request not found
        }
    
        return $request['sender_completed'] && $request['receiver_completed'];
    }
}
