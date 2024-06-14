<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            // Add more data as needed
        ];
        return view('pages/dashboard', $data);
    }
}
