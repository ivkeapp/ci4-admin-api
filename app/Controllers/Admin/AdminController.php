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
        echo 'Test setRole method';
    }

    public function getRole()
    {
        echo 'Test getRole method';
    }

    public function deleteRole()
    {
        echo 'Test deleteRole method';
    }

    public function updateRole()
    {
        echo 'Test updateRole method';
    }

    public function login()
    {

        // $session = session();
        // $session->set('isLoggedIn', 1);
        // echo 'Test login method';
    }

    public function logout()
    {
        // $session = session();
        // $session->remove('isLoggedIn');
        // echo 'Test logout method';
    }

    public function users()
    {
        // Doble check if the user is in the superadmin group
        $redirect = $this->checkSuperAdmin();
        if ($redirect) {
            return $redirect;
        }

        $data['users'] = $this->userModel->getUsers();
        $authGroups = config(AuthGroups::class);
        $data['groups'] = $authGroups->groups;
        // print_r($data['groups']);
        $data['title'] = 'Web Tech - User Admin';
        $data['description'] = 'Web Tech - User Admin';
        return view('admin/users', $data);
    }

    public function assign()
    {
        $model = new User();

        if ($this->request->getMethod() === 'post') {
            $userId = $this->request->getPost('user_id');
            $groupName = $this->request->getPost('group');
            $user = $this->userModel->find($userId);
            // print_r($user);
            // echo('<br>');
            // echo($userId);
            // echo('<br>');
            // echo('<br>');
            // echo($groupName);
            // echo('<br>');
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
                'email'        => 'required|valid_email|is_unique[auth_identities.secret]'
            ];

            $messages = [
                'email.is_unique' => 'The email must be unique.'
            ];

            if (!$this->validate($rules, $messages)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            try {
                
                // Prepare the user data as an array
                $userData = new UserEntity([
                    'username'     => $this->request->getPost('username'),
                    'email'        => $this->request->getPost('email'),
                    'password'     => $this->request->getPost('password'),
                    'mobile_phone' => $this->request->getPost('mobile_phone'),
                    'address'      => $this->request->getPost('address'),
                    'first_name'   => $this->request->getPost('first_name'),
                    'last_name'    => $this->request->getPost('last_name'),
                ]);

                log_message('debug', 'User Data before save: ' . print_r($userData, true));

                // Save the user using the model
                if (!$users->save($userData)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'User creation failed.',
                        'user' => [],
                    ]);
                }

                // Get the complete user object with ID
                $insertId = $users->getInsertID();
                $user = $users->findById($insertId);

                log_message('debug', 'Saved User after save: ' . print_r($user->toArray(), true));

                if (!$user) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'User creation failed.',
                        'user' => [],
                    ]);
                }
                $groupId = $this->request->getPost('group');
                if($groupId != null || $groupId != ''){
                    $user->addGroup($groupId);
                } else {
                    $this->userModel->addToDefaultGroup($user);
                }

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'User added successfully',
                    'user' => $user,
                ]);

            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'User creation failed: ' . $e->getMessage());
            }
        }
        return view('admin/add_user');
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
}