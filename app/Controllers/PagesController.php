<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PagesModel;
use App\Models\UserModel;
use App\Models\FixedPagesModel;
use App\Models\SectionsModel;
use App\Models\SlidersModel;
use App\Models\SliderProductsModel;
use App\Models\ProductModel;

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
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Page - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'page' => $this->pagesModel->find($id),
        ];

        $data = array_merge($commonData, $specificData);
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

    // Homepage
    public function editHomepage()
    {
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Homepage Administration - WebTech Admin',
            'description' => 'It looks like you found a glitch in the matrix...'
        ];

        $data = array_merge($commonData, $specificData);
        $fixedPagesModel = new FixedPagesModel();
        $sectionsModel = new SectionsModel();
        $slidersModel = new SlidersModel();
        $sliderProductsModel = new SliderProductsModel();
        $productModel = new ProductModel();

        $homepage = $fixedPagesModel->where('page_name', 'homepage')->first();
        $sections = $sectionsModel->where('page_id', $homepage['id'])->findAll();
        $sliders = $slidersModel->where('page_id', $homepage['id'])->findAll();
        $allProducts = $productModel->findAll();

        // Fetch products for each slider
        foreach ($sliders as &$slider) {
            $sliderProductIds = $sliderProductsModel->getProductsBySliderId($slider['id']);
            $productIds = array_column($sliderProductIds, 'product_id');
            $slider['products'] = $productModel->whereIn('id', $productIds)->findAll();
        }

        $tmpData = array_merge($commonData, $specificData);

        $data = array_merge($tmpData, [
            'homepage' => $homepage,
            'sections' => $sections,
            'sliders' => $sliders,
            'allProducts' => $allProducts
        ]);

        return view('admin/pages/homepage/edit', $data);
    }

    public function updateHomepage()
    {
        $fixedPagesModel = new FixedPagesModel();
        $sectionsModel = new SectionsModel();
        $slidersModel = new SlidersModel();
        $sliderProductsModel = new SliderProductsModel();
    
        $data = $this->request->getPost();

        // var_dump($data);
        $files = $this->request->getFiles();+
        print_r($files);
    
        // Update fixed page data
        $fixedPageData = [
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'meta_keywords' => $data['meta_keywords'],
            'slug' => $data['slug']
        ];
        $fixedPagesModel->update(1, $fixedPageData);
    
        // Update sections data
        foreach ($data['sections'] as $sectionId => $sectionData) {
            // Handle file upload
            if (isset($files['sections'][$sectionId]['image'])) {
                $file = $files['sections'][$sectionId]['image'];
                if ($file->isValid() && !$file->hasMoved()) {
                    // Delete old image if it exists
                    $oldSection = $sectionsModel->find($sectionId);
                    if (!empty($oldSection['image']) && file_exists(FCPATH . $oldSection['image'])) {
                        unlink(FCPATH . $oldSection['image']);
                    }

                    // Upload new image
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/sections', $newName);
                    $sectionData['image'] = 'uploads/sections/' . $newName;
                }
            }
            $sectionsModel->update($sectionId, $sectionData);
        }
    
        // Update sliders data
        foreach ($data['sliders'] as $sliderId => $sliderData) {
            $sliderProducts = $sliderData['products'];
            unset($sliderData['products']);
            $slidersModel->update($sliderId, $sliderData);
    
            // Update slider products
            $sliderProductsModel->where('slider_id', $sliderId)->delete();
            foreach ($sliderProducts as $productId) {
                $sliderProductsModel->insert([
                    'slider_id' => $sliderId,
                    'product_id' => $productId
                ]);
            }
        }
    
        return redirect()->to('/homepage')->with('success', 'Homepage updated successfully');
    }
}
