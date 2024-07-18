<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ExchangeRequestController extends BaseController
{

    // TODO: Creative Ideas
    // Exchange History: Implement a feature to track the history of all exchanges, successful or not, for each user. This can help in building trust among users.
    // Ratings and Reviews: Allow users to rate and review each other after an exchange is completed. This can help in identifying reliable users.
    // Automated Matching: Enhance the findCardExchanges method to periodically check for matches and notify users automatically when a potential exchange is found.
    // User Preferences: Allow users to set preferences for how they wish to be contacted (e.g., email, in-app notification) when an exchange request is made or when a match is found.

    public function index()
    {
        //
    }

    // Method to send an exchange request
    public function sendRequest()
    {
        $json = $this->request->getJSON();
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

        // Load the model
        $exchangeRequestModel = new \App\Models\ExchangeRequestModel();

        // Check for existing request
        $existingRequest = $exchangeRequestModel->where('sender_id', $json->sender_id)
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
        if ($exchangeRequestModel->insert($data)) {
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
}
