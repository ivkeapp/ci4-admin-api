<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\Events\Events;
use App\Models\MessageModel;
use App\Models\UserModel;
use App\Models\ExchangeRequestModel;
use App\Models\NotificationModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $auth;
    protected $userModel;
    protected $messageModel;
    protected $exchangeRequestModel;
    protected $notificationModel;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->auth = service('auth');
        $this->userModel = new UserModel();
        $this->messageModel = new MessageModel();
        $this->exchangeRequestModel = new ExchangeRequestModel();
        $this->notificationModel = new NotificationModel();
        
        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = \Config\Services::session();

        // Prepare log activity data
        $userId = $this->auth->id();
        $actionType = 'page_visit';
        $description = 'Visited page: ' . current_url();

        // Trigger the event
        Events::trigger('log_activity', $userId, $actionType, $description);
    }
    /**
     * Get common data for all controllers
     * @return array<string, mixed>
     */
    protected function getCommonData()
    {
        $userId = $this->auth->id();
        $userData = $this->userModel->find($userId);
        $messages = $this->messageModel->getLimitedUnreadMessages($userId);
        $messageNo = count($messages);

         // Fetch unread notifications
        // $exchangeRequests = $this->exchangeRequestModel->getLimitedPendingExchangeRequests($userId);
        // $exchangeRequestNo = $this->exchangeRequestModel->getPendingExchangeRequestCount($userId);
        $notifications = $this->notificationModel->getUnreadNotificationsWithUserDetails($userId);
        $notificationsNo = $this->notificationModel->getUnreadNotificationsCount($userId);

        if($notificationsNo > 0){
            if ($notificationsNo > 99) {
                $notificationsNo = '99+';
            } else {
                $notificationsNo = $notificationsNo;
            }
        } else {
            $exchangeRequestNo = 0;
        }

        return [
            'userGroups' => $userData->getGroups(),
            'userData' => $userData,
            'messages' => $messages,
            'messageNo' => $messageNo,
            'notifications' => $notifications,
            'notificationsNo' => $notificationsNo,
            // 'exchangeRequests' => $exchangeRequests,
            // 'exchangeRequestNo' => $exchangeRequestNo,
        ];
    }
}
