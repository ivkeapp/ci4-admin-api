<?php namespace App\Controllers\Admin;

// use App\Models\DataModel;
use CodeIgniter\Controller;
use CodeIgniter\Shield\Authorization;

class GroupController extends Controller
{
    protected $data;

    public function __construct()
    {
        // $this->data = new DataModel();
    }
    public function assign()
    {
        echo 'In development...';
        // echo view('admin/assign', $data);
    }
}