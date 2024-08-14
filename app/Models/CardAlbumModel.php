<?php

namespace App\Models;

use CodeIgniter\Model;

class CardAlbumModel extends Model
{
    protected $table            = 'card_albums';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['user_id', 'album_id', 'title', 'description', 'cards', 'needed_cards', 'status'];

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

    public function getTotalAlbumsCountByUser($userId)
    {
        return $this->where('user_id', $userId)->countAllResults();
    }
    public function getTotalDuplicateCardsCountByUser($userId)
    {
        $albums = $this->where('user_id', $userId)->findAll();
        $totalCardsCount = 0;
    
        foreach ($albums as $album) {
            $cards = json_decode($album['cards'], true);
            if (is_array($cards)) {
                $totalCardsCount += count($cards);
            }
        }
    
        return $totalCardsCount;
    }
}
