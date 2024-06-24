<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $auth;

    public function __construct()
    {
        $this->auth = service('auth');
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userData = $this->userModel->find($this->auth->id());
        $data = [
            'title' => 'Dashboard - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userGroups' => $userData->getGroups()
        ];
        return view('pages/dashboard', $data);
    }
}
