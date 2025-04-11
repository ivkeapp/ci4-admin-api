<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BlogModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Files\File;

class BlogController extends BaseController
{
    protected $blogModel;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
        $this->auth = service('authentication');
    }

    public function index()
    {
        $commonData = $this->getCommonData();
        $blogData['blogs'] = $this->blogModel->orderBy('id', 'desc')->paginate(8, 'blogGroup');
        $blogData['pager'] = $this->blogModel->pager;
        $specificData = [
            'title' => 'Dashboard - WebTech Admin',
            'description' => 'This is a blog section',
        ];
        $authId['userId'] = $this->auth->id();
        $data = array_merge($commonData, $blogData, $specificData, $authId);
        return view('blog/blogList', $data);
    }
    public function show($blogId)
    {
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Dashboard - WebTech Admin',
            'description' => 'This is a blog section',
        ];
        $blogData['blog'] = $this->blogModel->find($blogId);
        $authId['userId'] = $this->auth->id();

        $data = array_merge($commonData, $blogData, $specificData, $authId);
        return view('blog/blogShow', $data);
    }
    public function create()
    {
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Dashboard - WebTech Admin',
            'description' => 'This is a blog section',
        ];
        $data = array_merge($commonData, $specificData);
        return view('blog/blogCreate', $data);
    }
    public function store()
    {
        $validation = service('validation');
        // get the data
        $data = $this->request->getPost([
            'seo_title',
            'seo_description',
            'title',
            'subtitle',
            'content'
        ]);
        $data['author_id'] = $this->auth->id();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['image'] = $this->request->getFile('image');

        // validate the data
        if (!$validation->run($data, 'blogRules')) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        // save the blog without the image
        $blogId = $this->blogModel->insert($data, true);
        $imageName = $blogId . '_image.jpg';

        // upload the image
        if (!$data['image']->hasMoved()) {
            $data['image']->move('../public/assets/img/blogsImages', $imageName, true);
            $data['image'] = $imageName;
        }
        // add the image to the blog
        $this->blogModel->update($blogId, $data);
        return redirect()->to(url_to('blogCreate'))->with('message', 'Blog created successfully.');
    }
    public function edit($blogId)
    {
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Dashboard - WebTech Admin',
            'description' => 'This is a blog section',
        ];
        $blogData['blog'] = $this->blogModel->find($blogId);
        $data = array_merge($commonData, $specificData, $blogData);
        return view('blog/blogEdit', $data);
    }
    public function update($blogId)
    {
        helper('filesystem');
        $validation = service('validation');
        $blog = $this->blogModel->find($blogId);

        // validating the author
        if ($blog['author_id'] !== strval($this->auth->id())) {
            return redirect()->to(url_to('blog'));
            exit;
        }
        // retrieve the data
        $data = $this->request->getPost([
            'seo_title',
            'seo_description',
            'title',
            'subtitle',
            'content'
        ]);
        $data['author_id'] = $this->auth->id();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['image'] = $this->request->getFile('image');

        // validate the data
        if (!$validation->run($data, 'blogRulesUpdate')) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        // update the image if the new image was uploaded
        if (!$data['image']->getSize() == 0) {
            if (!$data['image']->hasMoved()) {
                $data['image']->move('../public/assets/img/blogsImages', $blog['image'], true);
            }
        } else {
            $data['image'] = $blog['image'];
        }
        $data['image'] = $blog['image'];
        // update the blog
        $this->blogModel->update($blog['id'], $data);
        return redirect()->to(url_to('blog'))->with('message', 'Blog updated successfully.');
    }
    public function delete($blogId)
    {
        helper('filesystem');
        $blog = $this->blogModel->find($blogId);

        // validating the author
        if ($blog['author_id'] !== strval($this->auth->id())) {
            return redirect()->to(url_to('blog'));
            exit;
        }

        $imagePath = FCPATH . 'assets/img/blogsImages/' . $blog['image'];
        // verify that the file exists and that it is not a seeder picture
        if (file_exists($imagePath) && is_file($imagePath) && $blog['image'] !== 'seedImage.jpg') {
            unlink($imagePath);
        }

        // unlink('assets/img/blogsImages/' . $blog['image']);
        $this->blogModel->delete($blogId);

        return redirect()->to(url_to('blog'))->with('message', 'Blog deleted successfully.');
    }
}
