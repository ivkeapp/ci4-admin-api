<?php
namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;

class UserEntity extends ShieldUser
{
    protected $attributes = [
        'mobile_phone' => null,
        'address'      => null,
        'first_name'   => null,
        'last_name'    => null,
    ];

    // Getter and setter for mobile_phone
    public function setMobilePhone($value)
    {
        $this->attributes['mobile_phone'] = $value;
        return $this;
    }

    public function getMobilePhone()
    {
        return $this->attributes['mobile_phone'];
    }

    // Getter and setter for address
    public function setAddress($value)
    {
        $this->attributes['address'] = $value;
        return $this;
    }

    public function getAddress()
    {
        return $this->attributes['address'];
    }

    // Getter and setter for first_name
    public function setFirstName($value)
    {
        $this->attributes['first_name'] = $value;
        return $this;
    }

    public function getFirstName()
    {
        return $this->attributes['first_name'];
    }

    // Getter and setter for last_name
    public function setLastName($value)
    {
        $this->attributes['last_name'] = $value;
        return $this;
    }

    public function getLastName()
    {
        return $this->attributes['last_name'];
    }

    // Optional: Method to get full name
    public function getFullName()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }
}
