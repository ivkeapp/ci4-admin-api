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
        $userData = $this->userModel->find($this->auth->id());
        $messages = $this->messageModel->getAllMessages($this->auth->id());
        $messageNo = count($messages);

        $data = [
            'title' => 'Dashboard - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userGroups' => $userData->getGroups(),
            'userData' => $userData,
            'messages' => $messages,
            'messageNo' => $messageNo
        ];
        return view('pages/dashboard', $data);
    }
}
