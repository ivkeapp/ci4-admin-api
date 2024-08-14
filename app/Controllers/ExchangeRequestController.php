<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ExchangeRequestModel;
use App\Models\ActivityLogModel;
use App\Models\NotificationModel;
use App\Models\RatingModel;

class ExchangeRequestController extends BaseController
{

    // TODO: Creative Ideas
    // Exchange History: Implement a feature to track the history of all exchanges, successful or not, for each user. This can help in building trust among users.
    // Ratings and Reviews: Allow users to rate and review each other after an exchange is completed. This can help in identifying reliable users.
    // Automated Matching: Enhance the findCardExchanges method to periodically check for matches and notify users automatically when a potential exchange is found.
    // User Preferences: Allow users to set preferences for how they wish to be contacted (e.g., email, in-app notification) when an exchange request is made or when a match is found.

    protected $exchangeRequestModel;
    protected $activityLogModel;
    protected $ratingModel;

    public function __construct()
    {
        $this->exchangeRequestModel = new ExchangeRequestModel();
        $this->activityLogModel = new ActivityLogModel();
        $this->ratingModel = new RatingModel();
    }

    public function index()
    {
        //
    }

    // Method to send an exchange request
    public function sendRequest()
    {
        $json = $this->request->getJSON();
        $senderId = $this->auth->id();

        // Check for existing exchange requests in either direction
        $existingRequest = $this->exchangeRequestModel
            ->where('album_id', $json->album_id)
            ->where("((sender_id = {$json->sender_id} AND receiver_id = {$json->receiver_id}) OR (sender_id = {$json->receiver_id} AND receiver_id = {$json->sender_id}))", null, false)
            ->first();

        if ($existingRequest) {
            // An exchange request already exists in either direction, handle accordingly
            return $this->response->setJSON(['status' => 0, 'message' => 'An exchange request for this album already exists between these users.']);
        }

        $validation = \Config\Services::validation();

        // Define validation rules
        $validation->setRules([
            'sender_id' => 'required|integer',
            'receiver_id' => 'required|integer',
            'album_id' => 'required|integer',
            'cards_offered' => 'required',
            'cards_requested' => 'required',
        ]);

        // Validate input data
        if (!$validation->run((array)$json)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $validation->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Check for existing request
        $existingRequest = $this->exchangeRequestModel->where('sender_id', $json->sender_id)
            ->where('receiver_id', $json->receiver_id)
            ->where('album_id', $json->album_id)
            ->first();

        if ($existingRequest) {
            return $this->response->setJSON([
                'status' => 0,
                'message' => 'An existing request already exists.',
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Prepare data for insertion
        $data = [
            'sender_id' => $json->sender_id,
            'receiver_id' => $json->receiver_id,
            'album_id' => $json->album_id,
            'cards_offered' => json_encode($json->cards_offered),
            'cards_requested' => json_encode($json->cards_requested),
            'status' => 'pending', // Default status
        ];

        // Insert the request
        if ($this->exchangeRequestModel->insert($data)) {
            $notificationModel = new NotificationModel();
            $notificationModel->insert([
                'user_id' => $json->receiver_id,
                'sender_id' => $json->sender_id,
                'message' => 'You have a new exchange request.',
                'status' => 'unread',
            ]);
            // Log the activity
            $this->activityLogModel->logActivity(
                $this->auth->id(),
                $this->activityLogModel::ACTIVITY_REQUEST_SENT,
                "User {$this->auth->id()} sent exchange request #{$json->receiver_id}",
                ['target_user_id' => $json->receiver_id, 'success' => true, 'status' => 'sent']
            );
            return $this->response->setJSON([
                'status' => 1,
                'message' => 'Exchange request sent successfully.',
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'message' => 'Failed to send exchange request.',
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function viewAllRequests() {
        $userId = $this->auth->id();
        $exchangeRequests = $this->exchangeRequestModel->getAllExchangeRequests($userId);
        foreach ($exchangeRequests as $key => $request) {
            // Decode JSON and convert to comma-separated strings
            $exchangeRequests[$key]['cards_offered'] = !empty($request['cards_offered']) ? implode(', ', json_decode($request['cards_offered'], true)) : 'No cards offered';
            $exchangeRequests[$key]['cards_requested'] = !empty($request['cards_requested']) ? implode(', ', json_decode($request['cards_requested'], true)) : 'No cards requested';
            
            // Check if the user has already rated this request
            $rating = $this->ratingModel->isRated($userId, $request['id']);
            $exchangeRequests[$key]['is_rated'] = $rating !== false;
            $exchangeRequests[$key]['rating'] = $rating; // Store the rating data if available
        }
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Received requests - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'exchangeRequests' => $exchangeRequests,
            'currentUser' => $userId,
        ];
    
        $data = array_merge($commonData, $specificData);
        return view('albums/view_requests', $data);
    }
    public function viewAllSentRequests() {
        $userId = $this->auth->id();
        $exchangeRequests = $this->exchangeRequestModel->getAllSentExchangeRequests($userId);
        foreach ($exchangeRequests as $key => $request) {
            // Decode JSON and convert to comma-separated strings
            $exchangeRequests[$key]['cards_offered'] = !empty($request['cards_offered']) ? implode(', ', json_decode($request['cards_offered'], true)) : 'No cards offered';
            $exchangeRequests[$key]['cards_requested'] = !empty($request['cards_requested']) ? implode(', ', json_decode($request['cards_requested'], true)) : 'No cards requested';

            // Check if the user has already rated this request
            $rating = $this->ratingModel->isRated($userId, $request['id']);
            $exchangeRequests[$key]['is_rated'] = $rating !== false;
            $exchangeRequests[$key]['rating'] = $rating; // Store the rating data if available
        }
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Sent requests - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'exchangeRequests' => $exchangeRequests,
            'currentUser' => $userId,
        ];
    
        $data = array_merge($commonData, $specificData);
        return view('albums/view_sent_requests', $data);
    }
    public function acceptRequest($id)
    {
        if ($this->request->isAJAX()) {
            if ($this->exchangeRequestModel->update($id, ['status' => 'accepted'])) {
            // Log the activity
            $this->activityLogModel->logActivity(
                $this->auth->id(),
                $this->activityLogModel::ACTIVITY_REQUEST_ACCEPTED,
                "User {$this->auth->id()} accepted exchange request #{$id}",
                ['target_user_id' => $this->auth->id(), 'success' => true, 'status' => 'accepted']
            );
                return $this->response->setJSON(['status' => 'success', 'message' => 'Request accepted successfully.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to accept request.']);
            }
        }
        // TODO: Fallback for non-AJAX request if needed
    }
    public function declineRequest($id)
    {
        if ($this->request->isAJAX()) {
            if ($this->exchangeRequestModel->update($id, ['status' => 'declined'])) {
                // Log the activity
                $this->activityLogModel->logActivity(
                    $this->auth->id(),
                    $this->activityLogModel::ACTIVITY_REQUEST_DECLINED,
                    "User {$this->auth->id()} declined exchange request #{$id}",
                    ['target_user_id' => $this->auth->id(), 'success' => true, 'status' => 'declined']
                );
                return $this->response->setJSON(['status' => 'success', 'message' => 'Request declined successfully.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to decline request.']);
            }
        }
        // TODO: Fallback for non-AJAX request if needed
    }
    public function deleteRequest($id)
    {
        if ($this->request->isAJAX()) {
            if ($this->exchangeRequestModel->update($id, ['status' => 'deleted'])) {
                // Log the activity
                $this->activityLogModel->logActivity(
                    $this->auth->id(),
                    $this->activityLogModel::ACTIVITY_REQUEST_DELETED,
                    "User {$this->auth->id()} deleted exchange request #{$id}",
                    ['target_user_id' => $this->auth->id(), 'success' => true, 'status' => 'deleted']
                );
                return $this->response->setJSON(['status' => 'success', 'message' => 'Request deleted successfully.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete request.']);
            }
        }
        // TODO: Fallback for non-AJAX request if needed
    }
    public function markAsCompleted()
    {
        $data = $this->request->getJSON();
        $requestId = $data->requestId;
        $userId = $this->auth->id();

        log_message('debug', 'REQUEST_ID_2: ' . print_r($requestId, true));

        $model = new ExchangeRequestModel();
        if($model->markAsCompleted($requestId, $userId)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Marked as completed.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to mark as completed.']);
        }
    }
    public function getReceivedRequestsJson() {
        $userId = $this->auth->id();
        $exchangeRequests = $this->exchangeRequestModel->getAllExchangeRequests($userId);
        foreach ($exchangeRequests as $key => $request) {
            $exchangeRequests[$key]['cards_offered'] = !empty($request['cards_offered']) ? implode(', ', json_decode($request['cards_offered'], true)) : 'No cards offered';
            $exchangeRequests[$key]['cards_requested'] = !empty($request['cards_requested']) ? implode(', ', json_decode($request['cards_requested'], true)) : 'No cards requested';
            $rating = $this->ratingModel->isRated($userId, $request['id']);
            $exchangeRequests[$key]['is_rated'] = $rating !== false;
            $exchangeRequests[$key]['rating'] = $rating;
        }
        return $this->response->setJSON($exchangeRequests);
    }
    public function getSentRequestsJson() {
        $userId = $this->auth->id();
        $exchangeRequests = $this->exchangeRequestModel->getAllSentExchangeRequests($userId);
        foreach ($exchangeRequests as $key => $request) {
            $exchangeRequests[$key]['cards_offered'] = !empty($request['cards_offered']) ? implode(', ', json_decode($request['cards_offered'], true)) : 'No cards offered';
            $exchangeRequests[$key]['cards_requested'] = !empty($request['cards_requested']) ? implode(', ', json_decode($request['cards_requested'], true)) : 'No cards requested';
            $rating = $this->ratingModel->isRated($userId, $request['id']);
            $exchangeRequests[$key]['is_rated'] = $rating !== false;
            $exchangeRequests[$key]['rating'] = $rating;
        }
        return $this->response->setJSON($exchangeRequests);
    }
}
