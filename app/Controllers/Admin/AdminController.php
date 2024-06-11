<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    public function setRole()
    {
        echo 'Test setRole method';
    }

    public function getRole()
    {
        echo 'Test getRole method';
    }

    public function deleteRole()
    {
        echo 'Test deleteRole method';
    }

    public function updateRole()
    {
        echo 'Test updateRole method';
    }

    public function login()
    {

        $session = session();
        $session->set('isLoggedIn', 1);
        echo 'Test login method';
    }

    public function logout()
    {
        $session = session();
        $session->remove('isLoggedIn');
        echo 'Test logout method';
    }
}
