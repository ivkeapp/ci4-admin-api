<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Entities\UserEntity; // Use custom UserEntity
use Config\AuthGroups;
use App\Models\AlbumCollectionModel;

class AdminController extends BaseController
{

    protected $auth;
    protected $userModel;
    protected $groupEntity;
    protected $albumModel;

    public function __construct()
    {
        $this->auth = service('auth');
        $this->userModel = new UserModel();
        $this->albumModel = new AlbumCollectionModel();
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
        $userData = $this->userModel->find($this->auth->id());
        // $data['users'] = $this->userModel->getUsers();
        $authGroups = config(AuthGroups::class);
        // $data['groups'] = $authGroups->groups;
        // print_r($authGroups->groups);
        $data['title'] = 'Web Tech - User Admin';
        $data['description'] = 'Web Tech - User Admin';
        $data = [
            'title' => 'Web Tech - User Admin',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'userGroups' => $userData->getGroups(),
            'groups' => $authGroups->groups,
            'users' => $this->userModel->getUsers(),
        ];
        return view('admin/users', $data);
    }

    public function assign()
    {
        $model = new User();

        if ($this->request->getMethod() === 'post') {
            $userId = $this->request->getPost('user_id');
            $groupName = $this->request->getPost('group');
            $user = $this->userModel->find($userId);
            if ($user) {
                $user->addGroup($groupName);
                return "User assigned to {$groupName} successfully.";
            }
            return "User not found.";
        }

        $data['users'] = $model->getUsers();
        echo view('admin/assign', $data);
    }

    public function addUser()
    {
        if (!$this->auth->inGroup('superadmin')) {
            // return redirect()->to('/no-access');
        }

        if ($this->request->getMethod() === 'post') {
            $users = new UserModel;

            $rules = [
                'username'     => 'required|min_length[3]|is_unique[users.username]',
                'password'     => 'required|min_length[5]',
                'first_name'   => 'required',
                'last_name'    => 'required',
                'mobile_phone' => 'required',
                'address'      => 'required',
                'email'        => 'required|valid_email|is_unique[auth_identities.secret]',
                'user_image'   => 'uploaded[user_image]|is_image[user_image]' // Add validation rule for image
            ];

            $messages = [
                'email.is_unique' => 'The email must be unique.',
                'user_image.is_image' => 'The file uploaded is not a valid image.' // Custom message for image validation
            ];

            if (!$this->validate($rules, $messages)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            try {
                // Handle image upload
                $image = $this->request->getFile('user_image');
                if ($image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    // Use FCPATH to get a path relative to the front controller
                    $image->move(FCPATH . 'public/uploads', $newName);
                    // Adjust the imagePath to use the relative path
                    $imagePath = 'public/uploads/' . $newName;
                } else {
                    throw new \RuntimeException('Image upload failed');
                }

                // Prepare the user data as an array, including the image path
                $userData = new UserEntity([
                    'username'     => $this->request->getPost('username'),
                    'email'        => $this->request->getPost('email'),
                    'password'     => $this->request->getPost('password'),
                    'mobile_phone' => $this->request->getPost('mobile_phone'),
                    'address'      => $this->request->getPost('address'),
                    'first_name'   => $this->request->getPost('first_name'),
                    'last_name'    => $this->request->getPost('last_name'),
                    'image_path'   => $imagePath, // Save the image path
                ]);

                log_message('debug', 'User Data before save: ' . print_r($userData, true));
                // Save the user using the model
                if (!$users->save($userData)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'User creation failed.',
                        'user' => [],
                    ]);
                } else {
                    $newUserId = $users->getInsertID();
                    $activityLogModel = new \App\Models\ActivityLogModel();
                    $activityLogModel->logActivity(
                        $this->auth->id(),
                        \App\Models\ActivityLogModel::ACTIVITY_USER_ADDED,
                        "User {$newUserId} added",
                        ['target_user_id' => $newUserId] // Additional metadata if needed
                    );
                }

            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'User creation failed: ' . $e->getMessage());
            }
        }
        return redirect()->back()->withInput()->with('success', 'User created successfuly!');
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

            // Delete the user
            if (!$users->delete($userId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete user.',
                ]);
            } else {
                $activityLogModel = new \App\Models\ActivityLogModel();
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

            $activityLogModel = new \App\Models\ActivityLogModel();
            $activityLogModel->logActivity(
                $this->auth->id(),
                \App\Models\ActivityLogModel::ACTIVITY_USER_EDITED,
                "User {$userId} updated",
                ['target_user_id' => $userId]
            );

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User updated successfully.',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
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

                // Save the updated user using the UserModel
                if (!$users->save($user)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'User update failed.',
                        'user' => [],
                    ]);
                }

                // Get the updated user object
                $updatedUser = $users->findById($userId);

                log_message('debug', 'Updated User after save: ' . print_r($updatedUser->toArray(), true));

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
    /**
     * MANAGING ALBUMS
     */
    public function albums()
    {
        $userId = $this->auth->id();
        $userData = $this->userModel->find($userId);

        // Fetch all albums from the model
        $albums = $this->albumModel->findAll();

        // Prepare data to pass to the view
        $data = [
            'title' => 'Manage Albums - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'albums' => $albums
        ];

        // Render the view with data
        return view('admin/albums', $data);
    }
    public function addAlbum()
    {
        if ($this->request->getMethod() === 'post') {
            // Handle image upload
            $image = $this->request->getFile('image');
            if ($image->isValid() && ! $image->hasMoved()) {
                $newName = $image->getRandomName();
                $image->move(ROOTPATH . 'public/uploads', $newName);
                $imagePath = 'uploads/' . $newName;
            } else {
                $imagePath = '';
            }

            // Prepare data for insertion
            $data = [
                'title' => $this->request->getPost('title'),
                'image' => $imagePath,
                'description' => $this->request->getPost('description'),
                'publisher' => $this->request->getPost('publisher'),
            ];

            // Insert data into database
            $this->albumModel->insert($data);

            // Redirect with success message
            echo ('Album collection added successfully.');
            // return redirect()->to('/admin/albums')->with('success', 'Album collection added successfully.');
        }

        $userId = $this->auth->id();
        $userData = $this->userModel->find($userId);

        $data = [
            'title' => 'Add Album - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
        ];

        return view('admin/albums/add', $data);
    }
   
    public function editAlbum($id)
    {
        $album = $this->albumModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $data = [
                'title' => $this->request->getPost('title'),
                'image' => $this->request->getPost('image'),
                'description' => $this->request->getPost('description'),
                'publisher' => $this->request->getPost('publisher'),
            ];

            $this->albumModel->update($id, $data);

            return redirect()->to('/admin/albums')->with('success', 'Album collection updated successfully.');
        }

        $userId = $this->auth->id();
        $userData = $this->userModel->find($userId);
        
        // Prepare data to pass to the view
        $data = [
            'title' => 'Manage Albums - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'album' => $album
        ];

        return view('admin/albums/edit', $data);
    }
}