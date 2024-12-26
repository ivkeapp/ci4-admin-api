<?php

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use App\Models\CategoryModel;

class CategoriesAPIController extends ResourceController
{
    protected $modelName = 'App\Models\CategoryModel';
    protected $format    = 'json';

    // Get all categories
    public function index()
    {
        $categories = $this->model->findAll();
        $categoryTree = $this->buildCategoryTree($categories);

        return $this->respond([
            'status' => 200,
            'error' => false,
            'message' => 'Categories fetched successfully',
            'data' => $categoryTree
        ]);
    }

    // Build category tree
    private function buildCategoryTree(array $categories, $parentId = null)
    {
        $branch = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $children = $this->buildCategoryTree($categories, $category['id']);
                if ($children) {
                    $category['subcategories'] = $children;
                }
                $branch[] = $category;
            }
        }
        return $branch;
    }

    // Get a single category by ID
    public function show($id = null)
    {
        $category = $this->model->find($id);
        if ($category) {
            return $this->respond([
                'status' => 200,
                'error' => false,
                'message' => 'Category fetched successfully',
                'data' => $category
            ]);
        } else {
            return $this->failNotFound('Category not found');
        }
    }

    // Create a new category
    public function create()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated([
                'status' => 201,
                'error' => false,
                'message' => 'Category created successfully',
                'data' => $data
            ]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    // Update an existing category
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if ($this->model->update($id, $data)) {
            return $this->respond([
                'status' => 200,
                'error' => false,
                'message' => 'Category updated successfully',
                'data' => $data
            ]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    // Delete a category
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted([
                'status' => 200,
                'error' => false,
                'message' => 'Category deleted successfully'
            ]);
        } else {
            return $this->failNotFound('Category not found');
        }
    }
}