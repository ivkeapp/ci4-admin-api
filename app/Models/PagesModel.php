<?php

namespace App\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{
    protected $table            = 'pages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'description',
        'user_created',
        'datetime_created',
        'is_active',
        'url_slug',
        'datetime_updated',
        'user_updated',
        'content'
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

    // Method to create a new page
    public function createPage($data)
    {
        return $this->insert($data);
    }

    // Method to update an existing page
    public function updatePage($id, $data)
    {
        return $this->update($id, $data);
    }

    // Method to delete a page
    public function deletePage($id)
    {
        return $this->delete($id);
    }
    // Method to paginate pages
    public function getPaginatedPages($perPage, $page, $search = null)
    {
        if ($search) {
            return $this->like('name', $search)
                        ->orLike('description', $search)
                        ->paginate($perPage, 'group1', $page);
        }
        return $this->paginate($perPage, 'group1', $page);
    }
    // Method to get the total number of pages
    public function getTotalPages($search = null)
    {
        if ($search) {
            return $this->like('name', $search)
                        ->orLike('description', $search)
                        ->countAllResults();
        }
        return $this->countAllResults();
    }
}
