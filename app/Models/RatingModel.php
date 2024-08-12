<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $table            = 'tb_user_ratings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'exchange_request_id', 
        'rater_id', 
        'rated_user_id', 
        'rating', 
        'rating_description', 
        'created_at', 
        'updated_at'
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

      /**
     * Get average rating for a user
     *
     * @param int $userId
     * @return float
     */
    public function getAverageUserRating(int $userId): float
    {
        return $this->where('rated_user_id', $userId)
                    ->selectAvg('rating')
                    ->get()
                    ->getRow()
                    ->rating;
    }

    /**
     * Rate a user
     *
     * @param array $data
     * @return bool
     */
    public function rateUser(array $data): bool
    {
        return $this->insert($data);
    }

    /**
     * Get last five ratings in the system
     *
     * @return array
     */
    public function getLastFiveRatings(): array
    {
        return $this->orderBy('created_at', 'DESC')
                    ->findAll(5);
    }

    /**
     * Delete a rating
     *
     * @param int $ratingId
     * @return bool
     */
    public function deleteRating(int $ratingId): bool
    {
        return $this->delete($ratingId);
    }

    /**
     * Update a rating
     *
     * @param int $ratingId
     * @param array $data
     * @return bool
     */
    public function updateRating(int $ratingId, array $data): bool
    {
        return $this->update($ratingId, $data);
    }
    /**
     * Is rated
     * Implement the logic to check if the user has already rated the request
     * Return true if rated, false otherwise
     * 
     * @param int $ratingId
     * @param array $data
     * @return bool
     */
    public function isRated($userId, $requestId) {
        $query = $this->db->table('tb_user_ratings')
                          ->where('rater_id', $userId)
                          ->where('exchange_request_id', $requestId)
                          ->countAllResults();
        return $query > 0;
    }
}
