<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class AuthController extends ResourceController
{
    // POST
    // Use to create and save a new user
    public function register()
    {

        $rules = [
            'username' => 'required|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[auth_identities.secret]',
            'password' => 'required|min_length[8]'
        ];

        if(!$this->validate($rules)){
            $response = [
                'status' => 400,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        } else {
            $userObject = new UserModel();
            $userEntity = new User([
                'username' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'password' => $this->request->getVar('password')
            ]);

            $userObject->save($userEntity);

            $response = [
                'status' => 201,
                'error' => false,
                'message' => 'User registered successfully',
                'data' => []
            ];
        }

        return $this->respondCreated($response);
    }

    // POST
    // Use to login and generate a JWT for the user
    public function login(){

        if(auth()->loggedIn()){
            auth()->logout();
        }

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];

        if(!$this->validate($rules)){
            $response = [
                'status' => 400,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        } else {
            
            $credentials = $this->request->getVar(['email', 'password']);

            $login = auth()->attempt($credentials);

            if(!$login->isOk()){
                $response = [
                    'status' => 401,
                    'error' => true,
                    'message' => 'Invalid credentials',
                    'data' => []
                ];
            } else {
                $userObject = new UserModel();
                $userData = $userObject->findById(auth()->id());

                $token = $userData->generateAccessToken('SomeSecretKey');

                $authToken = $token->raw_token;

                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'User logged in successfully',
                    'data' => [
                        'token' => $authToken
                    ]
                ];
            }

            return $this->respond($response);
        }
    }

    // GET
    // Use to retrieve user profile
    public function profile(){
            return $this->respondCreated([
                'status' => 200,
                'message' => 'User profile retrieved successfully',
                'data' => auth()->user()
            ]);
    }

    // GET
    // Use to logout user and destroy JWT
    public function logout(){
        auth()->logout();

        auth()->user()->revokeAllAccessTokens();

        return $this->respondCreated([
            'status' => 200,
            'message' => 'User logged out successfully',
            'data' => []
        ]);
    }

    public function accesDenied(){
        return $this->respondCreated([
            'status' => 403,
            'message' => 'Access Denied',
            'data' => []
        ]);
    }
}
