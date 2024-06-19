<?php
namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        // Add additional fields to allowedFields
        $this->allowedFields = array_merge($this->allowedFields, [
            'mobile_phone',
            'address',
            'first_name',
            'last_name'
        ]);
    }

    public function getUsers()
    {
        return $this->findAll();
    }
}