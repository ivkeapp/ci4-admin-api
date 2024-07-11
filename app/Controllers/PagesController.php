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
        $pagesModel = new PagesModel();
        $userData = $this->userModel->find($this->auth->id());
        $page = $this->request->getVar('page') ?? 1;
        $search = $this->request->getVar('search') ?? '';
        $perPage = 10;

        $pages = $pagesModel->getPaginatedPages($perPage, $page, $search);
        $total = $pagesModel->getTotalPages($search);

        $data = [
            'title' => 'Pages - WebTech Admin',
            'pages' => $pages,
            'pager' => $pagesModel->pager,
            'total' => $total,
            'search' => $search,
            'description' => 'This is a dynamic description for SEO',
            'userGroups' => $userData->getGroups(),
            'userData' => $userData
        ];

        return view('admin/pages/index', $data);

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
        $userData = $this->userModel->find($this->auth->id());

        $data = [
            'title' => 'Create page - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userGroups' => $userData->getGroups(),
            'userData' => $userData
        ];
        return view('admin/pages/create', $data);
    }

    // Store a newly created page in storage
    public function store()
    {
        helper('html_sanitize');

        $data = $this->request->getPost();

        $userId = $this->auth->id();
        $data['user_created'] = $userId; // Add the user ID to the data array

        if (!$userId) {
            // Handle the case where there is no authenticated user
            return redirect()->back()->with('error', 'You must be logged in to create a page.');
        }

        // Sanitize the content field
        $data['content'] = sanitize_html($data['content']);

        $this->pagesModel->createPage($data);
        return redirect()->to('/pages');
    }

    // Show the form for editing the specified page
    public function edit($id = null)
    {
        $userData = $this->userModel->find($this->auth->id());

        $data = [
            'title' => 'Page edit - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userGroups' => $userData->getGroups(),
            'userData' => $userData
        ];
        $data['page'] = $this->pagesModel->find($id);
        if (empty($data['page'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page Not Found');
        }
        return view('admin/pages/edit', $data);
    }

    // Update the specified page in storage
    public function update($id = null)
    {
        helper('html_sanitize');

        $data = $this->request->getPost();

        // Sanitize the content field
        $data['content'] = sanitize_html($data['content']);

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
