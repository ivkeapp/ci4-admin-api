<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['user_id', 'action_type', 'description', 'metadata', 'created_at'];

    protected bool $allowEmptyInserts = false;

    const ACTIVITY_LOGIN = 'login';
    const ACTIVITY_LOGOUT = 'logout';
    const ACTIVITY_PAGE_VISITED = 'page_visited';
    const ACTIVITY_USER_ADDED = 'user_added';
    const ACTIVITY_USER_EDITED = 'user_edited';
    const ACTIVITY_USER_DELETED = 'user_deleted';
    const ACTIVITY_PAGE_ADDED = 'page_added';
    const ACTIVITY_MESSAGE_SENT = 'message_sent';
    const ACTIVITY_MESSAGE_READ = 'message_read';
    const ACTIVITY_USER_ASSIGNED = 'user_assigned_to_group';
    const ACTIVITY_PAGE_CREATED = 'page_created';
    const ACTIVITY_PAGE_EDITED = 'page_edited';
    const ACTIVITY_PAGE_DELETED = 'page_deleted';
    const ACTIVITY_REQUEST_ACCEPTED = 'request_accepted';
    const ACTIVITY_REQUEST_DECLINED = 'request_declined';
    const ACTIVITY_REQUEST_DELETED = 'request_deleted';
    const ACTIVITY_RATING = 'user_rated';
    const ACTIVITY_RATING_FAILED = 'user_rating_failed';

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Log a new activity in the database.
     *
     * @param int|null $userId The ID of the user performing the action.
     * @param string $actionType The type of action being logged.
     * @param string $description A description of the action.
     * @param array|null $metadata Optional metadata about the action.
     * @return bool True on success, false on failure.
    */
    public function logActivity($userId, $actionType, $description, $additionalData = null)
    {
        // Initialize the UserAgent
        $request = \Config\Services::request(); // Ensure you have access to the request object
        $metadata = $this->collectMetadata($request);

        // Ensure $additionalData is an array
        $additionalData = is_array($additionalData) ? $additionalData : [];
        
        // Merge additional data with metadata
        $metadata = array_merge($additionalData, $metadata);

        $data = [
            'user_id' => $userId,
            'action_type' => $actionType,
            'description' => $description,
            'metadata' => $metadata ? json_encode($metadata) : null, // Encode metadata as JSON
        ];
        log_message('debug', 'Logging data: ' . print_r($data, true));

        return $this->insert($data);
    }
    /**
     * Collect metadata about the current request.
     * 
     * @param \CodeIgniter\HTTP\Request $request The current request object.
     * @return array An array of metadata about the request.
     * @todo Implement geolocation logic as needed.
     * @todo Implement additional metadata collection as needed.
     */
    private function collectMetadata($request) {
        $userAgent = $request->getUserAgent();
        $ipAddress = $request->getIPAddress();
        $device = $userAgent->getPlatform();
        $browser = $userAgent->getBrowser();
        $version = $userAgent->getVersion();
        $mobile = $userAgent->isMobile() ? 'Mobile' : 'Not Mobile';
        $location = 'to_do_use_geolocation'; // Implement geolocation logic as needed
        $method = $request->getMethod();
        $metadata = [
            'request_method' => $method,
            'ip_address' => $ipAddress,
            'device' => $device,
            'browser' => $browser,
            'version' => $version,
            'mobile' => $mobile,
            'location' => $location,
        ];

        return $metadata;
    }
}
