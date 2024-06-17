<?php namespace App\Controllers\Admin;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\Shield\Authorization;

class GroupController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function assign()
    {
        $model = new UserModel();

        if ($this->request->getMethod() === 'post') {
            $userId = $this->request->getPost('user_id');
            $groupName = $this->request->getPost('group');
            $user = $this->userModel->find($userId);
            if ($user) {
                $user->addGroup($groupName);
                return "User assigned to {$groupName} successfully.";
            }
            return "User not found.";
        }

        $data['users'] = $model->getUsers();
        echo view('admin/assign', $data);
    }
}