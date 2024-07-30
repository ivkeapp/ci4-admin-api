<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\NotificationModel;

class NotificationsController extends BaseController
{
    public function index()
    {
        return redirect()->to('/');
    }

    public function checkNew()
    {
        $userId = $this->auth->id();
        $notificationModel = new NotificationModel();
        $notifications = $notificationModel->where('user_id', $userId)
                                           ->where('status', 'unread')
                                           ->findAll();

        return $this->response->setJSON($notifications);
    }
}
