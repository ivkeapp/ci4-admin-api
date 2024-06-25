<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Errors extends Controller
{
    protected $userModel;
    protected $auth;

    public function __construct()
    {
        $this->auth = service('auth');
        $this->userModel = new UserModel();
    }

    public function show404()
    {
        $userData = $this->userModel->find($this->auth->id());
        $data = [
            'title' => 'Page Not Found - WebTech Admin',
            'description' => 'It looks like you found a glitch in the matrix...',
            'userData' => $userData,
            'userGroups' => $userData->getGroups(),
        ];
        echo view('errors/custom_404', $data); // Make sure this path matches your view file
    }
}