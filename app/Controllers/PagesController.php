<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PagesModel;
use App\Models\UserModel;

class PagesController extends BaseController
{
    protected $pagesModel;

    public function __construct()
    {
        $this->pagesModel = new PagesModel();
    }
    // Display a list of all pages
    public function index()
    {
        $pagesModel = new PagesModel();
        $page = $this->request->getVar('page') ?? 1;
        $search = $this->request->getVar('search') ?? '';
        $perPage = 10;

        $pages = $pagesModel->getPaginatedPages($perPage, $page, $search);
        $total = $pagesModel->getTotalPages($search);

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Pages - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'pages' => $pages,
            'pager' => $pagesModel->pager,
            'total' => $total,
            'search' => $search,
        ];

        $data = array_merge($commonData, $specificData);

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

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Create page - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
        ];

        $data = array_merge($commonData, $specificData);
        
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
        // Log the activity
        $activityLogModel = new \App\Models\ActivityLogModel();
        $activityLogModel->logActivity(
            $this->auth->id(),
            \App\Models\ActivityLogModel::ACTIVITY_PAGE_CREATED,
            "Page created by user: {$userId}",
            ['page_created' => true, 'page_title' => $data['name']]
        );
        // TODO: return JSON response
        return redirect()->to('/pages');
    }

    // Show the form for editing the specified page
    public function edit($id = null)
    {

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Page edit - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'page' =>  $this->pagesModel->find($id),
        ];

        $data = array_merge($commonData, $specificData);

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
        // Log the activity
        $activityLogModel = new \App\Models\ActivityLogModel();
        $activityLogModel->logActivity(
            $this->auth->id(),
            \App\Models\ActivityLogModel::ACTIVITY_PAGE_EDITED,
            "Page {$id} edited by user: {$this->auth->id()}",
            ['page_edited' => true, 'page_id' => $id]
        );
        return redirect()->to('/pages');
    }

    // Remove the specified page from storage
    public function delete($id = null)
    {
        if($id === null) {
            return redirect()->to('/pages');
        }
        $this->pagesModel->deletePage($id);
        // Log the activity
        $activityLogModel = new \App\Models\ActivityLogModel();
        $activityLogModel->logActivity(
            $this->auth->id(),
            \App\Models\ActivityLogModel::ACTIVITY_PAGE_DELETED,
            "Page {$id} deleted by user: {$this->auth->id()}",
            ['page_deleted' => true, 'page_id' => $id]
        );
        return redirect()->to('/pages');
    }
}
