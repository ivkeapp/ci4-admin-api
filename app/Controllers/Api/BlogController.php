<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;
use App\Models\BlogModel;

class BlogController extends ResourceController
{
    protected $blogModel;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
    }

    public function index()
    {
        $blogs = $this->blogModel->findAll();
        if ($blogs == null) {
            return $this->respondCreated([
                'status' => 404,
                'message' => 'Blog was not found',
                'blog' => $blogs,
            ]);
        }
        return $this->respondCreated([
            'status' => 200,
            'message' => 'Blogs retrieved successfully',
            'blogs' => $blogs,
        ]);
    }

    public function getSingleBlog($id)
    {
        $blog = $this->blogModel->find($id);
        if ($blog == null) {
            return $this->respondCreated([
                'status' => 404,
                'message' => 'Blog was not found',
                'blog' => $blog,
            ]);
        }
        return $this->respondCreated([
            'status' => 200,
            'message' => 'Blog retrieved successfully',
            'blog' => $blog,
        ]);
    }

    public function storeBlog()
    {
        $validation = service('validation');
        // retrieve the data
        $data = $this->request->getPost([
            'seo_title',
            'seo_description',
            'title',
            'subtitle',
            'content'
        ]);
        $data['author_id'] = auth()->id();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['image'] = $this->request->getFile('image');

        // validate the data
        if (!$validation->run($data, 'blogRules')) {
            return $this->respondCreated([
                'status' => 400,
                'error' => true,
                'error_list' => $validation->getErrors(),
            ]);
        }

        $blogId = $this->blogModel->insert($data, true);
        $imageName = $blogId . '_image.jpg';

        if (!$data['image']->hasMoved()) {
            $data['image']->move('../public/assets/img/blogsImages', $imageName, true);
            $data['image'] = $imageName;
        }
        $this->blogModel->update($blogId, $data);

        return $this->respondCreated([
            'status' => 201,
            'message' => 'Blog created successfully',
        ]);
    }


    public function updateBlog($id)
    {
        helper('filesystem');
        $blog = $this->blogModel->find($id);
        if ($blog == null) {
            return $this->respondCreated([
                'status' => 404,
                'message' => 'Blog was not found',
                'blog' => $blog,
            ]);
        }

        // validating the author
        if ($blog['author_id'] !== strval(auth()->id())) {
            return $this->respondCreated([
                'status' => 403,
                'error' => true,
                'error_list' => ['author' => 'You are not the author of the blog, you cannot update the blog.'],
            ]);
            exit;
        }

        $validation = service('validation');


        $data = $this->request->getPost([
            'seo_title',
            'seo_description',
            'title',
            'subtitle',
            'content'
        ]);
        $data['author_id'] = auth()->id();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['image'] = $this->request->getFile('image');


        if (!$validation->run($data, 'blogRulesUpdate')) {
            return $this->respondCreated([
                'status' => 400,
                'error' => true,
                'error_list' => $validation->getErrors(),
            ]);
        }

        if (!$data['image']->getSize() == 0) {
            if (!$data['image']->hasMoved()) {
                $data['image']->move('../public/assets/img/blogsImages', $blog['image'], true);
            }
        } else {
            $data['image'] = $blog['image'];
        }
        $data['image'] = $blog['image'];
        $this->blogModel->update($blog['id'], $data);

        return $this->respondCreated([
            'status' => 201,
            'message' => 'Blog updated successfully',
        ]);
    }

    public function deleteSingleBlog($id)
    {
        $blog = $this->blogModel->find($id);
        if ($blog == null) {
            return $this->respondCreated([
                'status' => 404,
                'message' => 'Blog was not found',
                'blog' => $blog,
            ]);
        }

        // validating the author
        if ($blog['author_id'] !== strval(auth()->id())) {
            return $this->respondCreated([
                'status' => 403,
                'error' => true,
                'error_list' => ['author' => 'You are not the author of the blog, you cannot delete the blog.'],
            ]);
            exit;
        }

        $imagePath = FCPATH . 'assets/img/blogsImages/' . $blog['image'];
        // verify that the file exists and that it is not a seeder picture
        if (file_exists($imagePath) && is_file($imagePath) && $blog['image'] !== 'seedImage.jpg') {
            unlink($imagePath);
        }

        // delete the blog
        $blog = $this->blogModel->delete($id);
        return $this->respondCreated([
            'status' => 200,
            'message' => 'Blog deleted successfully',
        ]);
    }
}
