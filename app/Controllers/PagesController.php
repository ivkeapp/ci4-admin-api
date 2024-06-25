<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PagesModel;
use App\Models\UserModel;

class PagesController extends BaseController
{
    protected $pagesModel;
    protected $userModel;
    protected $auth;

    public function __construct()
    {
        $this->pagesModel = new PagesModel();
        $this->userModel = new UserModel();
        $this->auth = service('auth');
    }
    // Display a list of all pages
    public function index()
    {
        $userData = $this->userModel->find($this->auth->id());
        $data = [
            'title' => 'Pages - WebTech Admin',
            'pages' => $this->pagesModel->findAll(),
            'description' => 'This is a dynamic description for SEO',
            'userGroups' => $userData->getGroups(),
            'userData' => $userData
        ];
        return view('pages/index', $data);
    }
    // Show a single page
    public function view($id = null)
    {
        $data['page'] = $this->pagesModel->find($id);
        if (empty($data['page'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page Not Found');
        }
        return view('pages/view', $data);
    }

    // Show the form for creating a new page
    public function create()
    {
        return view('pages/create');
    }

    // Store a newly created page in storage
    public function store()
    {
        $data = $this->request->getPost();
    
        // Assuming you have a method to get the current authenticated user's ID
        $userId = $this->auth->id();
        $data['user_created'] = $userId; // Add the user ID to the data array
    
        if (!$userId) {
            // Handle the case where there is no authenticated user
            return redirect()->back()->with('error', 'You must be logged in to create a page.');
        }
    
        $this->pagesModel->createPage($data);
        return redirect()->to('/pages');
    }

    // Show the form for editing the specified page
    public function edit($id = null)
    {
        $data['page'] = $this->pagesModel->find($id);
        if (empty($data['page'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page Not Found');
        }
        return view('pages/edit', $data);
    }

    // Update the specified page in storage
    public function update($id = null)
    {
        $data = $this->request->getPost();
        $this->pagesModel->updatePage($id, $data);
        return redirect()->to('/pages');
    }

    // Remove the specified page from storage
    public function delete($id = null)
    {
        $this->pagesModel->deletePage($id);
        return redirect()->to('/pages');
    }
}
