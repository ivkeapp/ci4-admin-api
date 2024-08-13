<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\AuthGroups;
use App\Models\RatingModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $ratingModel;
    protected $auth;

    public function __construct()
    {
        $this->auth = service('auth');
        $this->userModel = new UserModel();
        $this->ratingModel = new RatingModel();
    }

    public function profile()
    {
        // if (!$this->auth->loggedIn()) {
        //     return redirect()->to('/login');
        // }
        $authGroups = config(AuthGroups::class);
        $userId = $this->auth->id();

        $commonData = $this->getCommonData();
        $averageRating = $this->ratingModel->getAverageUserRating($userId);
        $specificData = [
            'title' => 'User Profile - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'groups' => $authGroups->groups,
            'rating' => $averageRating
        ];

        $data = array_merge($commonData, $specificData);

        return view('user/profile', $data);
    }
}