<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ActivityLogModel;
use App\Models\UserModel;

class ActivityLogController extends BaseController
{
    public function index()
    {
        $activityLogModel = new ActivityLogModel();
        $userModel = new UserModel();

        $logs = $activityLogModel->select('activity_logs.*, users.first_name, users.last_name, users.mobile_phone, users.address')
                                 ->join('users', 'users.id = activity_logs.user_id')
                                 ->orderBy('activity_logs.created_at', 'DESC')
                                 ->findAll();
        // Prepare data to pass to the view
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Activity Log - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'logs' => $logs,
        ];

        $data = array_merge($commonData, $specificData);

        echo view('activity_logs/index', $data);
    }
}
