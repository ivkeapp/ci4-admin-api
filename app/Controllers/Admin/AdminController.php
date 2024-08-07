<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Entities\UserEntity; // Use custom UserEntity
use Config\AuthGroups;

class AdminController extends BaseController
{

    protected $auth;
    protected $userModel;
    protected $groupEntity;

    public function __construct()
    {
        $this->auth = service('auth');
        $this->userModel = new UserModel();
    }
    public function setRole()
    {
        echo 'setRole method';
    }

    public function getRole()
    {
        echo 'getRole method';
    }

    public function deleteRole()
    {
        echo 'deleteRole method';
    }

    public function updateRole()
    {
        echo 'updateRole method';
    }

    public function users()
    {
        // Doble check if the user is in the superadmin group
        $redirect = $this->checkSuperAdmin();
        if ($redirect) {
            return $redirect;
        }

        $authGroups = config(AuthGroups::class);

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'User Admin - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'groups' => $authGroups->groups,
            'users' => $this->userModel->getUsers(),
        ];

        $data = array_merge($commonData, $specificData);

        return view('admin/users', $data);
    }

    public function assign()
    {

        if ($this->request->getMethod() === 'post') {
            $userId = $this->request->getPost('user_id');
            $groupName = $this->request->getPost('group');
            $user = $this->userModel->find($userId);
            if ($user) {
                $user->addGroup($groupName);
                $activityLogModel = new \App\Models\ActivityLogModel();
                $activityLogModel->logActivity(
                    $this->auth->id(),
                    \App\Models\ActivityLogModel::ACTIVITY_USER_ASSIGNED,
                    "User {$userId} assigned to {$groupName} group",
                    ['user_assigned_to_group' => true, 'group_name' => $groupName]
                );
                return "User assigned to {$groupName} successfully.";
            }
            return "User not found.";
        }

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Assign to a Group - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'users' => $this->userModel->getUsers()
        ];

        $data = array_merge($commonData, $specificData);
        echo view('admin/assign', $data);
    }

    public function addUser()
    {
        if (!$this->auth->inGroup('superadmin')) {
            // return redirect()->to('/no-access');
        }
    
        if ($this->request->getMethod() === 'post') {
            $users = new UserModel;
            $newUser = new \App\Entities\UserEntity();
            log_message('debug', 'Starting user insertation.');
            $rules = [
                'username'     => 'required|min_length[3]|is_unique[users.username]',
                'password'     => 'required|min_length[5]',
                'first_name'   => 'required',
                'last_name'    => 'required',
                'mobile_phone' => 'required',
                'address'      => 'required',
                'email'        => 'required|valid_email|is_unique[auth_identities.secret]',
                // Keep the user_image validation rules here, but actual validation will happen after checking file upload success
                'user_image'   => 'permit_empty|uploaded[user_image]|max_size[user_image,1024]|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]',
            ];
    
            $messages = [
                'email.is_unique' => 'The email must be unique.',
                'user_image.is_image' => 'The file uploaded is not a valid image. Try another one!'
            ];
    
            if (!$this->validate($rules, $messages)) {
                log_message('debug', 'Validation failed: ' . print_r($this->validator->getErrors(), true));
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
    
            try {
                $image = $this->request->getFile('user_image');
                if ($image !== null && $image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $image->move(FCPATH . 'public/uploads', $newName);
                    $imagePath = 'public/uploads/' . $newName;
                    log_message('debug', 'Image upload success.');
                } else {
                    // Handle cases where no image is uploaded or there is an error with the uploaded file
                    if ($image !== null) {
                        log_message('error', 'Image upload failed: ' . $image->getErrorString());
                        return redirect()->back()->withInput()->with('error', 'Image upload failed: ' . $image->getErrorString());
                    } else {
                        // No file was uploaded, proceed without setting an image path or handle accordingly
                        $imagePath = null; // TODO: add default image path
                    }
                }

                // Fill the UserEntity with the POST data
                $newUser->username = $this->request->getPost('username');
                $newUser->email = $this->request->getPost('email');
                $newUser->password = $this->request->getPost('password');
                $newUser->first_name = $this->request->getPost('first_name');
                $newUser->last_name = $this->request->getPost('last_name');
                $newUser->mobile_phone = $this->request->getPost('mobile_phone');
                $newUser->address = $this->request->getPost('address');
                $newUser->image_path = $imagePath;
    
                $userData = [
                    'username'     => $this->request->getPost('username'),
                    'email'        => $this->request->getPost('email'),
                    'password'     => $this->request->getPost('password'),
                    'mobile_phone' => $this->request->getPost('mobile_phone'),
                    'address'      => $this->request->getPost('address'),
                    'first_name'   => $this->request->getPost('first_name'),
                    'last_name'    => $this->request->getPost('last_name'),
                    'image_path'   => $imagePath,
                ];
    
                log_message('debug', 'User Data before save: ' . print_r($userData, true));
                if (!$this->userModel->save($newUser)) {
                    log_message('debug', 'User creation failed: ' . print_r($userData, true));
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'User creation failed.',
                        'user' => [],
                    ]);
                } else {
                    $newUserId = $this->userModel->getInsertID();
                    $addedUser = $this->userModel->findById($newUserId);
                    $groupName = $this->request->getPost('group');
                    if(isset($groupName) && !empty($groupName)) {
                        $addedUser->addGroup($groupName);
                    } else {
                        $this->userModel->addToDefaultGroup($addedUser);
                    }
                    $activityLogModel = new \App\Models\ActivityLogModel();
                    $activityLogModel->logActivity(
                        $this->auth->id(),
                        \App\Models\ActivityLogModel::ACTIVITY_USER_ADDED,
                        "User {$newUserId} added",
                        ['target_user_id' => $newUserId]
                    );
                    log_message('debug', 'User creation success. New ID: ' . $newUserId);
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'User created successfully.',
                        'user' => $newUserId,
                    ]);
                }
    
            } catch (\Exception $e) {
                log_message('error', 'User creation failed: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'User creation failed: ' . $e->getMessage());
            }
        }
    }
    
    // Function to remove user
    public function removeUser($userId)
    {
        if (!$this->auth->inGroup('superadmin')) {
            // return redirect()->to('/no-access');
        }

        try {
            // Get the User Provider (UserModel by default)
            $users = auth()->getProvider();

            // Find the user
            $user = $users->findById($userId);

            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User not found.',
                ]);
            }
            // Initialize the ActivityLogModel
            $activityLogModel = new \App\Models\ActivityLogModel();

            // Delete the user
            if (!$users->delete($userId)) {
                $activityLogModel->logActivity(
                    $this->auth->id(),
                    \App\Models\ActivityLogModel::ACTIVITY_USER_DELETED,
                    "User {$userId} delete failed",
                    ['target_user_id' => $userId]
                );
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete user.',
                ]);
            } else {
                $activityLogModel->logActivity(
                    $this->auth->id(),
                    \App\Models\ActivityLogModel::ACTIVITY_USER_DELETED,
                    "User {$userId} deleted",
                    ['target_user_id' => $userId]
                );
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User deleted successfully.',
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User deletion failed: ' . $e->getMessage(),
            ]);
        }
    }

    public function updateUser()
    {
        $userId = $this->request->getPost('user_id');

        // Fetch the existing user by ID
        $user = $this->userModel->find($userId);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not found.',
            ]);
        }

        $rules = [
            'username'     => 'required|min_length[3]',
            'password'     => 'required|min_length[5]',
            'first_name'   => 'required',
            'last_name'    => 'required',
            'mobile_phone' => 'required',
            'address'      => 'required',
            'email'        => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $this->validator->getErrors(),
            ]);
        }

        try {
            // Update the user data
            $user->username = $this->request->getPost('username');
            $user->email = $this->request->getPost('email');
            $user->password = $this->request->getPost('password');
            $user->first_name = $this->request->getPost('first_name');
            $user->last_name = $this->request->getPost('last_name');
            $user->mobile_phone = $this->request->getPost('mobile_phone');
            $user->address = $this->request->getPost('address');

            $this->userModel->save($user);

            // Log the activity
            $activityLogModel = new \App\Models\ActivityLogModel();
            $activityLogModel->logActivity(
                $this->auth->id(),
                \App\Models\ActivityLogModel::ACTIVITY_USER_EDITED,
                "User {$userId} updated successfully",
                ['target_user_id' => $userId, 'is_successfull' => true, 'updated_user' => $user->toArray()]
            );

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User updated successfully.',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            // Log the activity
            $activityLogModel = new \App\Models\ActivityLogModel();
            $activityLogModel->logActivity(
                $this->auth->id(),
                \App\Models\ActivityLogModel::ACTIVITY_USER_EDITED,
                "User {$userId} update failed",
                ['target_user_id' => $userId, 'is_successfull' => false, 'error' => $e->getMessage()]
            );
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User update failed: ' . $e->getMessage(),
            ]);
        }
    }

    // Function to show the edit user form
    public function editUserForm($userId)
    {
        if (!$this->auth->inGroup('superadmin')) {
            // return redirect()->to('/no-access');
        }

        // Get the user from the UserModel
        $user = $this->userModel->find($userId);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not found.',
            ]);
        }

        return view('admin/edit_user', [
            'user' => $user
        ]);
    }

    // Function to update the user
    public function editUser($userId)
    {
        if (!$this->auth->inGroup('superadmin')) {
            // return redirect()->to('/no-access');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'username'     => 'required|min_length[3]|is_unique[users.username,id,'.$userId.']',
                'password'     => 'permit_empty|min_length[5]',
                'first_name'   => 'required',
                'last_name'    => 'required',
                'mobile_phone' => 'required',
                'address'      => 'required',
                'email'        => 'required|valid_email|is_unique[auth_identities.secret,id,'.$userId.']'
            ];

            $messages = [
                'email.is_unique' => 'The email must be unique.'
            ];

            if (!$this->validate($rules, $messages)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            try {
                // Get the User Provider (UserModel by default)
                $users = auth()->getProvider();

                // Get the user entity
                $user = $users->findById($userId);

                if (!$user) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'User not found.',
                    ]);
                }

                // Update the user entity with new data
                $user->fill([
                    'username'     => $this->request->getPost('username'),
                    'email'        => $this->request->getPost('email'),
                    'password'     => $this->request->getPost('password'),
                    'mobile_phone' => $this->request->getPost('mobile_phone'),
                    'address'      => $this->request->getPost('address'),
                    'first_name'   => $this->request->getPost('first_name'),
                    'last_name'    => $this->request->getPost('last_name'),
                ]);

                log_message('debug', 'User Entity before save: ' . print_r($user->toArray(), true));

                // Initialize the ActivityLogModel
                $activityLogModel = new \App\Models\ActivityLogModel();

                // Save the updated user using the UserModel
                if (!$users->save($user)) {
                    // Log the activity
                    $activityLogModel->logActivity(
                        $this->auth->id(),
                        \App\Models\ActivityLogModel::ACTIVITY_USER_EDITED,
                        "User {$userId} update failed",
                        ['target_user_id' => $userId, 'is_successfull' => false]
                    );
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'User update failed.',
                        'user' => [],
                    ]);
                }

                // Get the updated user object
                $updatedUser = $users->findById($userId);

                log_message('debug', 'Updated User after save: ' . print_r($updatedUser->toArray(), true));

                // Log the activity
                $activityLogModel->logActivity(
                    $this->auth->id(),
                    \App\Models\ActivityLogModel::ACTIVITY_USER_EDITED,
                    "User {$userId} updated",
                    ['target_user_id' => $userId, 'success' => true]
                );
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'User updated successfully',
                    'user' => $updatedUser,
                ]);

            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'User update failed: ' . $e->getMessage());
            }
        }

        return view('admin/edit_user');
    }
    // Function to show the groups
    public function groups()
    {
        
        $authGroups = config(AuthGroups::class);
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Groups - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'groups' => $authGroups->groups,
        ];

        $data = array_merge($commonData, $specificData);

        return view('admin/groups', $data);
    }

    /**
     * Checks if the user is in the superadmin group.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|null
     */
    private function checkSuperAdmin()
    {
        // Double check if the user is in the superadmin group
        $userData = $this->userModel->find($this->auth->id());
        if (!$userData->inGroup('superadmin')) {
            return redirect()->to('/no-access');
        }
    
        return null;
    }
}