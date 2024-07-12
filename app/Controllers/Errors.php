<?php 

namespace App\Controllers;

use App\Controllers\BaseController;

class Errors extends BaseController
{

    public function show404()
    {
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Page Not Found - WebTech Admin',
            'description' => 'It looks like you found a glitch in the matrix...',
        ];

        $data = array_merge($commonData, $specificData);

        echo view('errors/custom_404', $data);
    }
}