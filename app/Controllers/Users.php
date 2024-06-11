<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class Users extends BaseController
{
    private $userObject;
    public function __construct()
    {
        $this->userObject = new UsersModel();
    }
    public function index()
    {
        //
    }

    public function insertUser()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@site.com',
            'phone' => '1234567890'
        ];

        if($this->userObject->insert($data)){
            return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED)->setJSON(['message' => 'User created successfully']);
        }else{
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)->setJSON(['message' => 'Failed to create user']);
        }
    }

    public function updateUser()
    {

        $userId = 1;
        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@site.com',
            'phone' => '0987654321'
        ];

        if($this->userObject->update($userId, $data)){
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)->setJSON(['message' => 'User updated successfully']);
        }else{
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)->setJSON(['message' => 'Failed to update user']);
        }
    }

    public function deleteUser()
    {
        $userId = 1;

        if($this->userObject->delete($userId)){
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)->setJSON(['message' => 'User deleted successfully']);
        }else{
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)->setJSON(['message' => 'Failed to delete user']);
        }
    }

    public function getAllUsers()
    {
        $users = $this->userObject->findAll();
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK)->setJSON($users);
    }
}
