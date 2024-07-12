<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExampleTablesModel;
use App\Models\UserModel;

class ExampleTablesController extends BaseController
{
    
    public function index()
    {

        $model = new ExampleTablesModel();
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Page Not Found - WebTech Admin',
            'description' => 'It looks like you found a glitch in the matrix...',
            'tableData' => $model->findAll()
        ];

        $data = array_merge($commonData, $specificData);

        return view('pages/tables_example', $data);

    }
}
