<?php
namespace App\Controllers;

use App\Models\CategoryModel;
use App\Controllers\BaseController;

class CategoryController extends BaseController
{
    public function getCategoryTree()
    {
        $model = new CategoryModel();
        $categories = $model->findAll();

        // Build a category tree
        $tree = [];
        $indexed = [];

        foreach ($categories as $cat) {
            $cat['children'] = [];
            $indexed[$cat['id']] = $cat;
        }

        foreach ($indexed as $id => &$cat) {
            if ($cat['parent_id']) {
                $indexed[$cat['parent_id']]['children'][] = &$cat;
            } else {
                $tree[] = &$cat;
            }
        }

        return $this->response->setJSON($tree);
    }

    public function getCategories() {
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Page Builder - WebTech Admin',
            'description' => 'Manage pages, sections and content.'
        ];
    
        $data = array_merge($commonData, $specificData);
    
        return view('/categories/categories', $data);
    }
}
