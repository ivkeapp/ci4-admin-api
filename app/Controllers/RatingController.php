<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\RatingModel;
use App\Models\ActivityLogModel;

class RatingController extends ResourceController
{

    protected $modelName = 'App\Models\RatingModel';
    protected $format    = 'json';
    protected $activityLogModel;

    public function __construct()
    {
        $this->activityLogModel = new ActivityLogModel();
    }

    /**
     * Get average rating for a user
     *
     * @param int $userId
     * @return \CodeIgniter\HTTP\Response
     */
    public function getAverageUserRating($userId)
    {
        $averageRating = $this->model->getAverageUserRating($userId);
        return $this->respond(['average_rating' => $averageRating]);
    }

    /**
     * Rate a user
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function rateUser()
    {
        // Check if the request method is POST
        if ($this->request->getMethod() !== 'post') {
            return $this->fail('Invalid request method');
        }
    
        // Get the JSON data
        $data = $this->request->getJSON(true);
    
        // Log the received data for debugging
        log_message('debug', 'RTING_DATA: ' . print_r($data, true));
    
        // Check if data is empty
        if (empty($data)) {
            return $this->fail('No data received');
        }
        $auth = service('auth');
        $data['rater_id'] = $auth->id();
        $ratedUserId = $data['rated_user_id'];
    
        // Attempt to rate the user
        if ($this->model->rateUser($data)) {
            // Log the activity
            $auth = service('auth');
            $this->activityLogModel->logActivity(
                $auth->id(),
                $this->activityLogModel::ACTIVITY_RATING,
                "User #{$auth->id()} rated user #{$ratedUserId} with {$data['rating']} stars",
                ['target_user_id' => $ratedUserId, 'success' => true, 'status' => 'rated']
            );
            return $this->respondCreated(['status' => 'success', 'message' => 'Rating added successfully']);
        }

        // Log the activity
        $auth = service('auth');
        $this->activityLogModel->logActivity(
            $auth->id(),
            $this->activityLogModel::ACTIVITY_RATING_FAILED,
            "Failed to rate user #{$ratedUserId}",
            ['target_user_id' => $ratedUserId, 'success' => false, 'status' => 'failed']
        );
    
        // Return failure response if rating could not be added
        return $this->fail('Failed to add rating');
    }

    /**
     * Get last five ratings in the system
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function getLastFiveRatings()
    {
        $ratings = $this->model->getLastFiveRatings();
        return $this->respond($ratings);
    }

    /**
     * Delete a rating
     *
     * @param int $ratingId
     * @return \CodeIgniter\HTTP\Response
     */
    public function deleteRating($ratingId)
    {
        if ($this->model->deleteRating($ratingId)) {
            return $this->respondDeleted(['message' => 'Rating deleted successfully']);
        }
        return $this->fail('Failed to delete rating');
    }

    /**
     * Update a rating
     *
     * @param int $ratingId
     * @return \CodeIgniter\HTTP\Response
     */
    public function updateRating($ratingId)
    {
        $data = $this->request->getRawInput();
        if ($this->model->updateRating($ratingId, $data)) {
            return $this->respond(['message' => 'Rating updated successfully']);
        }
        return $this->fail('Failed to update rating');
    }
}
