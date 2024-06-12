<?php

namespace App\Controllers\Api;

use App\Models\PagesModel;
use CodeIgniter\RESTful\ResourceController;

class PagesController extends ResourceController
{
    public function addPage() {
        $rules = [
            'name' => 'required|max_length[100]',
            'description' => 'permit_empty',
            'is_active' => 'required|in_list[0,1]',
            'url_slug' => 'required|max_length[100]',
            'content' => 'permit_empty'
        ];
        if(!$this->validate($rules)){
            $response = [
                'status' => 400,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        } else {
            $userId = auth()->id();
            $pageObject = new PagesModel();
            $data = [
                'name' => $this->request->getVar('name'),
                'description' => $this->request->getVar('description'),
                'user_created' => $userId,
                'datetime_created' => date('Y-m-d H:i:s'),
                'is_active' => $this->request->getVar('is_active'),
                'url_slug' => $this->request->getVar('url_slug'),
                'datetime_updated' => date('Y-m-d H:i:s'),
                'user_updated' => $userId,
                'content' => $this->request->getVar('content')
            ];

            if($pageObject->insert($data)){
                $response = [
                    'status' => 201,
                    'error' => false,
                    'message' => 'Page created successfully',
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => 'Failed to create page',
                    'data' => []
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function listPages() {
        $pageObject = new PagesModel();
        $pages = $pageObject->findAll();
        if (empty($pages)) {
            $response = [
                'status' => 404,
                'error' => true,
                'message' => 'No pages found',
                'data' => []
            ];
        } else {
            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Pages retrieved successfully',
                'data' => $pages
            ];
        }
        return $this->respond($response);
    }

    public function show($id = null)
    {
        $pageObject = new PagesModel();
        $page = $pageObject->find($id);
        if (empty($page)) {
            $response = [
                'status' => 404,
                'error' => true,
                'message' => 'Page not found',
                'data' => []
            ];
        } else {
            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Page retrieved successfully',
                'data' => [$page]
            ];
        }
        return $this->respond($response);
    }

    public function deletePage($id) {
        $pageObject = new PagesModel();
        if($pageObject->delete($id)){
            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Page deleted successfully',
                'data' => []
            ];
        } else {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => 'Failed to delete page',
                'data' => []
            ];
        }
        return $this->respond($response);
    }
}
