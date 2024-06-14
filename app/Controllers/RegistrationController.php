<?php
namespace App\Controllers;

use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegistrationController;
use App\Models\UserModel as UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class RegistrationController extends ShieldRegistrationController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function registerView()
    {
        // Call the parent's registerView method
        $parentResponse = parent::registerView();

        // Return the parent's response
        return $parentResponse;
    }

    public function registerAction(): RedirectResponse
    {
        // Get the request data
        $data = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'mobile_phone' => $this->request->getPost('mobile_phone'),
            'address' => $this->request->getPost('address'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
        ];

        // Validate the data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'mobile_phone' => 'required|numeric',
            'address' => 'required',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
        ]);

        if (!$validation->run($data)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Create the user
        try {
            $this->model->save($data);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        // Get the user
        $user = $this->model->where('email', $data['email'])->first();

        // Log the user in
        $auth = service('authentication');
        $auth->login($user);

        // Redirect the user
        return redirect()->to('/');
    }
}