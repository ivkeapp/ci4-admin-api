<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MessageModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $messageModel;
    protected $auth;

    public function __construct()
    {
        $this->auth = service('auth');
        $this->userModel = new UserModel();
        $this->messageModel = new MessageModel();
    }

    public function index()
    {
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Dashboard - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
        ];

        $data = array_merge($commonData, $specificData);
        return view('pages/dashboard', $data);
    }
}
