<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Models\MessageModel;

class ChatController extends BaseController
{
    protected $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessageModel();
    }

    public function index($messageId)
    {
        // Find the message by ID
        $message = $this->messageModel->find($messageId);

        $userId = $this->auth->id();
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Chat - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'message'
        ];

        $data = array_merge($commonData, $specificData);
        // Check if the message exists and belongs to the authenticated user
        if ($message && $message['receiver_user_id'] == $userId) {
            // Update the message status to 'read'
            $this->messageModel->update($messageId, ['status' => 'read', 'status_timestamp' => date('Y-m-d H:i:s')]);
            
            // Load the view with the message data
            return view('pages/chat', $data);
        } else {
            // Show an error message if the message does not exist or does not belong to the user
            return redirect()->to('/no-access');
        }
    }
    
    public function sendMessage()
    {
        $messageModel = new MessageModel();

        $data = [
            'sender_user_id' => $this->auth->id(),
            'receiver_user_id' => $this->request->getPost('receiver_user_id'),
            'content' => $this->request->getPost('content'),
            'timestamp' => new Time('now'),
            'status' => 'unread',
            'status_timestamp' => new Time('now')
        ];

        if ($messageModel->insert($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Message sent successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to send message']);
        }
    }

    public function getMessages($userId)
    {
        $messageModel = new MessageModel();

        $messages = $messageModel
            ->where('receiver_user_id', $userId)
            ->orWhere('sender_user_id', $userId)
            ->orderBy('FIELD(status, "unread", "read", "replied")', 'ASC')
            ->orderBy('timestamp', 'DESC')
            ->findAll();

        return $this->response->setJSON($messages);
    }
}
