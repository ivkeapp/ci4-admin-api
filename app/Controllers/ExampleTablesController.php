<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExampleTablesModel;
use App\Models\UserModel;

class ExampleTablesController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {

        $model = new ExampleTablesModel();
        $userId = $this->auth->id();
        $userData = $this->userModel->find($userId);

        $data = [
            'title' => 'Example Table - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'tableData' => $model->findAll()
        ];

        return view('pages/tables_example', $data);

    }
}
