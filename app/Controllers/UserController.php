<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\AuthGroups;

class UserController extends BaseController
{
    protected $userModel;
    protected $auth;

    public function __construct()
    {
        $this->auth = service('auth');
        $this->userModel = new UserModel();
    }

    public function profile()
    {
        // if (!$this->auth->loggedIn()) {
        //     return redirect()->to('/login');
        // }
        $authGroups = config(AuthGroups::class);

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'User Profile - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'groups' => $authGroups->groups,
        ];

        $data = array_merge($commonData, $specificData);

        return view('user/profile', $data);
    }
}