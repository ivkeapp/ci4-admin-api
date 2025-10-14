<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use App\Models\ProductBadgeModel;
use App\Models\ProductDocumentModel;
use App\Models\ProductSpecificationModel;

class ProductController extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $products = $productModel->findAll();
        $categories = $categoryModel->findAll();

        // Create a map of category IDs to category names
        $categoryMap = [];
        foreach ($categories as $category) {
            $categoryMap[$category['id']] = $category['name'];
        }

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Products - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'products' => $products,
            'categoryMap' => $categoryMap
        ];

        $data = array_merge($commonData, $specificData);

        return view('product/index', $data);
    }
    public function create()
    {
        $categoryModel = new CategoryModel();
        $rootCategories = $categoryModel->where('parent_id', null)->findAll();

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Add New Product',
            'description' => 'This is a dynamic description for SEO',
            'categories' => $rootCategories,
        ];

        $data = array_merge($commonData, $specificData);

        return view('product/create', $data);
    }
    public function store()
    {
        $productModel = new ProductModel();

        // Set up validation rules
        $validationRules = [
            'sku' => [
                'rules' => 'required|is_unique[tb_products.sku]',
                'errors' => [
                    'required' => 'SKU is required.',
                    'is_unique' => 'This SKU already exists. Please use a different SKU.'
                ]
            ],
            'short_name' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Short name is required.',
                    'min_length' => 'Short name must be at least 3 characters long.'
                ]
            ],
            'price_in' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Price is required.',
                    'decimal' => 'Price must be a valid decimal number.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            $errorMessage = implode(' ', $errors);
            
            // Check if it's an AJAX request
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMessage,
                    'errors' => $errors
                ]);
            } else {
                // For regular form submission, set flash data and redirect back
                session()->setFlashdata('error', $errorMessage);
                return redirect()->back()->withInput();
            }
        }

        $metadata = $this->request->getPost('metadata');
        if (empty($metadata)) {
            $metadata = '{}'; // Default to empty JSON object if metadata is not provided
        }

        $shortName = $this->request->getPost('short_name');
        $sku = $this->request->getPost('sku');
        $slug = $this->request->getPost('slug');

        if (empty($slug)) {
            $slug = url_title($shortName . '-' . $sku, '-', true);
        }

        $data = [
            'sku' => $sku,
            'short_name' => $shortName,
            'long_name' => $this->request->getPost('long_name'),
            'slug' => $slug,
            'description' => $this->request->getPost('description'),
            'price_in' => $this->request->getPost('price_in'),
            'price_with_margin' => $this->request->getPost('price_with_margin'),
            'regular_price' => $this->request->getPost('regular_price'),
            'package_size' => $this->request->getPost('package_size'),
            'package_weight' => $this->request->getPost('package_weight'),
            'metadata' => $metadata,
            'category_id' => $this->request->getPost('category'),
            'subcategory_id' => $this->request->getPost('subcategory'),
            'subsubcategory_id' => $this->request->getPost('subsubcategory'),
            'user_id' => $this->auth->id()
        ];

        try {
            $productId = $productModel->insert($data);
            
            if ($productId) {
                // Handle image uploads if any
                $files = $this->request->getFiles();
                if (isset($files['product_images']) && is_array($files['product_images'])) {
                    $this->handleImageUpload($productId, $files['product_images']);
                }
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Product created successfully!',
                        'product_id' => $productId
                    ]);
                } else {
                    session()->setFlashdata('success', 'Product created successfully!');
                    return redirect()->to('/products');
                }
            } else {
                throw new \Exception('Failed to create product');
            }
        } catch (\Exception $e) {
            log_message('error', 'Product creation error: ' . $e->getMessage());
            
            // Check for duplicate key error
            if (strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'sku') !== false) {
                $errorMessage = 'This SKU already exists. Please use a different SKU.';
            } else {
                $errorMessage = 'An error occurred while creating the product. Please try again.';
            }
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMessage
                ]);
            } else {
                session()->setFlashdata('error', $errorMessage);
                return redirect()->back()->withInput();
            }
        }
    }
    public function getCategories()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();
        return $this->response->setJSON($categories);
    }
    public function getSubcategories($parentId)
    {
        $categoryModel = new CategoryModel();
        $subcategories = $categoryModel->where('parent_id', $parentId)->findAll();
        return $this->response->setJSON($subcategories);
    }
    public function getSubsubcategories($parentId)
    {
        $categoryModel = new CategoryModel();
        $subsubcategories = $categoryModel->where('parent_id', $parentId)->findAll();
        return $this->response->setJSON($subsubcategories);
    }
    public function getSubsubcategoriesByCategory($categoryId)
    {
        $categoryModel = new CategoryModel();
        $subcategories = $categoryModel->where('parent_id', $categoryId)->findAll();

        $subsubcategories = [];
        foreach ($subcategories as $subcategory) {
            $subsubcategories = array_merge($subsubcategories, $categoryModel->where('parent_id', $subcategory['id'])->findAll());
        }

        return $this->response->setJSON($subsubcategories);
    }
    public function addImage($productId)
    {

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Add Product Image',
            'description' => 'This is a dynamic description for SEO',
            'productId' => $productId,
        ];

        $data = array_merge($commonData, $specificData);

        return view('product/add_image', $data);
    }
    public function addImages()
    {
        $productModel = new ProductModel();
        $products = $productModel->findAll();

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Add Product Images',
            'description' => 'This is a dynamic description for SEO',
            'products' => $products,
        ];

        $data = array_merge($commonData, $specificData);

        return view('product/add_images', $data);
    }

    public function storeImages()
    {
        $productImageModel = new ProductImageModel();
        $productId = $this->request->getPost('product_id');
        $isMain = $productImageModel->where('product_id', $productId)->countAllResults() == 0;
    
        $files = $this->request->getFiles();
        $allUploaded = true;
        $errors = [];
    
        foreach ($files['product_images'] as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                if ($file->move(FCPATH . 'public/uploads', $newName)) {
                    $data = [
                        'product_id' => $productId,
                        'image_path' => 'public/uploads/' . $newName,
                        'is_main' => $isMain
                    ];
    
                    $productImageModel->insert($data);
                    $isMain = false; // Only the first image is set as main
                } else {
                    $allUploaded = false;
                    $errors[] = $file->getErrorString();
                }
            } else {
                $allUploaded = false;
                $errors[] = $file->getErrorString();
            }
        }
    
        if ($allUploaded) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'errors' => $errors]);
        }
    }

    public function getProductImages($productId)
    {
        $productImageModel = new ProductImageModel();
        $images = $productImageModel->where('product_id', $productId)->findAll();

        return $this->response->setJSON($images);
    }

    public function deleteImage($imageId)
    {
        $productImageModel = new ProductImageModel();
        $image = $productImageModel->find($imageId);
    
        if ($image) {
            $filePath = FCPATH . $image['image_path'];
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    $productImageModel->delete($imageId);
    
                    // Check if the deleted image was the main image
                    if ($image['is_main']) {
                        // Set another image as the main image
                        $this->setNewMainImage($image['product_id']);
                    }
    
                    return $this->response->setJSON(['status' => 'success', 'message' => 'Image deleted successfully.']);
                } else {
                    return $this->response->setJSON(['status' => 'danger', 'message' => 'Failed to delete the file.']);
                }
            } else {
                // File not found, delete the record from the database
                $productImageModel->delete($imageId);
    
                // Check if the deleted image was the main image
                if ($image['is_main']) {
                    // Set another image as the main image
                    $this->setNewMainImage($image['product_id']);
                }
    
                return $this->response->setJSON(['status' => 'warning', 'message' => 'File not found, but image record deleted from the database.']);
            }
        } else {
            return $this->response->setJSON(['status' => 'danger', 'message' => 'Image not found in the database.']);
        }
    }

    public function deleteAllImages($productId)
    {
        $productImageModel = new ProductImageModel();
        $images = $productImageModel->where('product_id', $productId)->findAll();
    
        $errors = [];
        foreach ($images as $image) {
            $filePath = FCPATH . $image['image_path'];
            if (file_exists($filePath)) {
                if (!unlink($filePath)) {
                    $errors[] = 'Failed to delete file: ' . $image['image_path'];
                }
            } else {
                $errors[] = 'File not found: ' . $image['image_path'];
            }
            // Delete the record from the database regardless of file existence
            $productImageModel->delete($image['id']);
        }
    
        if (empty($errors)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'All images deleted successfully.']);
        } else {
            return $this->response->setJSON(['status' => 'warning', 'message' => 'Some errors occurred.', 'errors' => $errors]);
        }
    }

    public function setMainImage($imageId)
    {
        $productImageModel = new ProductImageModel();
        $image = $productImageModel->find($imageId);
        
        if (!$image) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Image not found.']);
        }
        
        // First, remove main status from all images of this product
        $productImageModel->where('product_id', $image['product_id'])->set(['is_main' => false])->update();
        
        // Then set this image as main
        $productImageModel->update($imageId, ['is_main' => true]);
        
        return $this->response->setJSON(['status' => 'success', 'message' => 'Main image updated successfully.']);
    }

    private function setNewMainImage($productId)
    {
        $productImageModel = new ProductImageModel();
        $newMainImage = $productImageModel->where('product_id', $productId)->first();

        if ($newMainImage) {
            $productImageModel->update($newMainImage['id'], ['is_main' => true]);
        }
    }

    /**
     * Handle image upload for a product
     * 
     * @param int $productId
     * @param array $files
     * @return array
     */
    private function handleImageUpload($productId, $files)
    {
        $productImageModel = new ProductImageModel();
        $isMain = $productImageModel->where('product_id', $productId)->countAllResults() == 0;
        
        $uploadResults = [];
        
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                if ($file->move(FCPATH . 'public/uploads', $newName)) {
                    $data = [
                        'product_id' => $productId,
                        'image_path' => 'public/uploads/' . $newName,
                        'is_main' => $isMain
                    ];
                    
                    $imageId = $productImageModel->insert($data);
                    $uploadResults[] = [
                        'success' => true,
                        'image_id' => $imageId,
                        'image_path' => 'public/uploads/' . $newName
                    ];
                    $isMain = false; // Only the first image is set as main
                } else {
                    $uploadResults[] = [
                        'success' => false,
                        'error' => $file->getErrorString()
                    ];
                }
            } else {
                $uploadResults[] = [
                    'success' => false,
                    'error' => $file->getErrorString()
                ];
            }
        }
        
        return $uploadResults;
    }
    public function manageCategories()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();
    
        // Create a map of categories by their ID for easy lookup
        $categoryMap = [];
        foreach ($categories as $category) {
            $categoryMap[$category['id']] = $category;
        }
    
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Manage Categories',
            'description' => 'Add, edit, and delete categories',
            'categories' => $categories,
            'categoryMap' => $categoryMap,
        ];
    
        $data = array_merge($commonData, $specificData);
    
        return view('product/manage_categories', $data);
    }

    public function saveCategory()
    {
        $categoryModel = new CategoryModel();
    
        $data = [
            'name' => $this->request->getPost('name'),
            'parent_id' => $this->request->getPost('parent_id'),
            'level' => $this->request->getPost('level'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
        ];
    
        if ($this->request->getPost('id')) {
            $categoryModel->update($this->request->getPost('id'), $data);
            $id = $this->request->getPost('id');
        } else {
            $id = $categoryModel->insert($data);
        }
    
        // Fetch the updated category data
        $updatedCategory = $categoryModel->find($id);
        $parentName = $updatedCategory['parent_id'] ? $categoryModel->find($updatedCategory['parent_id'])['name'] : 'None';
    
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Category saved successfully.',
            'data' => [
                'id' => $updatedCategory['id'],
                'name' => $updatedCategory['name'],
                'parent_id' => $updatedCategory['parent_id'],
                'parent_name' => $parentName,
                'level' => $updatedCategory['level'],
                'slug' => $updatedCategory['slug'],
                'description' => $updatedCategory['description'],
            ]
        ]);
    }

    public function deleteCategory($id)
    {
        $categoryModel = new CategoryModel();
        $categoryModel->delete($id, true); // true for cascading delete

        return $this->response->setJSON(['status' => 'success', 'message' => 'Category deleted successfully.']);
    }
}
