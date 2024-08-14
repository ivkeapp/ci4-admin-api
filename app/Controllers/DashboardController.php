<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MessageModel;
use App\Models\CardAlbumModel;
use App\Models\ExchangeRequestModel;
use App\Models\RatingModel;
use App\Models\ActivityLogModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $messageModel;
    protected $auth;
    protected $cardAlbumModel;
    protected $exchangeRequestModel;
    protected $ratingModel;
    protected $activityLogModel;

    public function __construct()
    {
        $this->auth = service('auth');
        $this->userModel = new UserModel();
        $this->messageModel = new MessageModel();
        $this->cardAlbumModel = new CardAlbumModel();
        $this->exchangeRequestModel = new ExchangeRequestModel();
        $this->ratingModel = new RatingModel();
        $this->activityLogModel = new ActivityLogModel();
    }

    public function index()
    {
        $userId = $this->auth->id();
        $totalAlbumsCount = $this->cardAlbumModel->getTotalAlbumsCountByUser($userId);
        $totalDuplicateCardsCount = $this->cardAlbumModel->getTotalDuplicateCardsCountByUser($userId);
        $pendingRequestsCount = $this->exchangeRequestModel->countPendingRequestsByUser($userId);
        $completedExchangesCount = $this->exchangeRequestModel->countCompletedExchangesByUser($userId);
        $recentRequests =  $this->exchangeRequestModel->getRecentExchangeRequests($userId);
        $recentActivities = $this->activityLogModel->getRecentActivities($userId);

        foreach ($recentRequests as $key => $request) {
            // Decode JSON and convert to comma-separated strings
            $recentRequests[$key]['cards_offered'] = !empty($request['cards_offered']) ? implode(', ', json_decode($request['cards_offered'], true)) : 'No cards offered';
            $recentRequests[$key]['cards_requested'] = !empty($request['cards_requested']) ? implode(', ', json_decode($request['cards_requested'], true)) : 'No cards requested';
            
            // Check if the user has already rated this request
            $rating = $this->ratingModel->isRated($userId, $request['id']);
            $recentRequests[$key]['is_rated'] = $rating !== false;
            $recentRequests[$key]['rating'] = $rating; // Store the rating data if available
        }

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Dashboard - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'currentUser' => $userId,
            'totalAlbumsCount' => $totalAlbumsCount,
            'totalDuplicateCardsCount' => $totalDuplicateCardsCount,
            'pendingRequestsCount' => $pendingRequestsCount,
            'completedExchangesCount' => $completedExchangesCount,
            'recentRequests' => $recentRequests,
            'recentActivities' => $recentActivities,
        ];

        $data = array_merge($commonData, $specificData);
        return view('pages/dashboard', $data);
    }
}
