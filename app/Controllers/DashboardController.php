<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MessageModel;
use App\Models\ProductModel;
use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\PagesModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $messageModel;
    protected $productModel;
    protected $blogModel;
    protected $categoryModel;
    protected $pagesModel;
    protected $auth;

    public function __construct()
    {
        $this->auth = service('auth');
        $this->userModel = new UserModel();
        $this->messageModel = new MessageModel();
        $this->productModel = new ProductModel();
        $this->blogModel = new BlogModel();
        $this->categoryModel = new CategoryModel();
        $this->pagesModel = new PagesModel();
    }

    public function index()
    {
        $commonData = $this->getCommonData();
        $analyticsData = $this->getDashboardAnalytics();
        
        $specificData = [
            'title' => 'Dashboard - WebTech Admin',
            'description' => 'Analytics dashboard with real-time business metrics',
        ];

        $data = array_merge($commonData, $specificData, $analyticsData);
        return view('pages/dashboard', $data);
    }

    /**
     * Get comprehensive dashboard analytics
     */
    private function getDashboardAnalytics()
    {
        try {
            return [
                'totalProducts' => $this->getTotalProducts(),
                'totalCategories' => $this->getTotalCategories(),
                'totalBlogPosts' => $this->getTotalBlogPosts(),
                'totalUsers' => $this->getTotalUsers(),
                'totalPages' => $this->getTotalPages(),
                'unreadMessages' => $this->getUnreadMessagesCount(),
                'monthlyProductsData' => $this->getMonthlyProductsData(),
                'categoryDistribution' => $this->getCategoryDistribution(),
                'recentActivity' => $this->getRecentActivity(),
                'productsByPrice' => $this->getProductsByPriceRange(),
            ];
        } catch (\Exception $e) {
            log_message('error', 'Dashboard: Error getting analytics data - ' . $e->getMessage());
            
            // Return default values if there's an error
            return [
                'totalProducts' => 0,
                'totalCategories' => 0,
                'totalBlogPosts' => 0,
                'totalUsers' => 0,
                'totalPages' => 0,
                'unreadMessages' => 0,
                'monthlyProductsData' => [],
                'categoryDistribution' => [],
                'recentActivity' => [
                    'products_30d' => 0,
                    'posts_30d' => 0,
                    'pages_30d' => 0,
                ],
                'productsByPrice' => [],
            ];
        }
    }

    /**
     * Get total products count
     */
    private function getTotalProducts()
    {
        try {
            return $this->productModel->countAllResults();
        } catch (\Exception $e) {
            log_message('error', 'Dashboard: Error getting product count - ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get total categories count
     */
    private function getTotalCategories()
    {
        try {
            return $this->categoryModel->countAllResults();
        } catch (\Exception $e) {
            log_message('error', 'Dashboard: Error getting category count - ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get total blog posts count
     */
    private function getTotalBlogPosts()
    {
        try {
            return $this->blogModel->countAllResults();
        } catch (\Exception $e) {
            log_message('error', 'Dashboard: Error getting blog count - ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get total users count
     */
    private function getTotalUsers()
    {
        try {
            return $this->userModel->countAllResults();
        } catch (\Exception $e) {
            log_message('error', 'Dashboard: Error getting user count - ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get total pages count
     */
    private function getTotalPages()
    {
        try {
            return $this->pagesModel->countAllResults();
        } catch (\Exception $e) {
            log_message('error', 'Dashboard: Error getting page count - ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get unread messages count for current user
     */
    private function getUnreadMessagesCount()
    {
        try {
            $userId = $this->auth->id();
            if (!$userId) {
                return 0;
            }
            return $this->messageModel->where('receiver_user_id', $userId)
                                      ->where('status', 'unread')
                                      ->countAllResults();
        } catch (\Exception $e) {
            log_message('error', 'Dashboard: Error getting unread messages count - ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get monthly products data for line chart
     */
    private function getMonthlyProductsData()
    {
        $db = \Config\Database::connect();
        
        // Use a more database-agnostic approach
        $twelveMonthsAgo = date('Y-m-d', strtotime('-12 months'));
        
        // First check if table exists and has data
        if (!$db->tableExists('tb_products')) {
            return [];
        }
        
        $query = $db->table('tb_products')
                   ->select("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count", false)
                   ->where('created_at >=', $twelveMonthsAgo)
                   ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
                   ->orderBy('month', 'ASC')
                   ->get();
        
        $results = $query->getResultArray();
        
        // Fill in missing months with 0
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $count = 0;
            foreach ($results as $result) {
                if ($result['month'] == $month) {
                    $count = (int) $result['count'];
                    break;
                }
            }
            $monthlyData[] = ['month' => $month, 'count' => $count];
        }
        
        return $monthlyData;
    }

    /**
     * Get category distribution for pie chart
     */
    private function getCategoryDistribution()
    {
        $db = \Config\Database::connect();
        
        // Check if tables exist
        if (!$db->tableExists('tb_product_categories') || !$db->tableExists('tb_products')) {
            return [];
        }
        
        $query = $db->table('tb_product_categories c')
                   ->select('c.name, COUNT(p.id) as product_count')
                   ->join('tb_products p', 'c.id = p.category_id', 'left')
                   ->groupBy('c.id, c.name')
                   ->having('product_count >', 0)
                   ->orderBy('product_count', 'DESC')
                   ->limit(10)
                   ->get();
        
        return $query->getResultArray();
    }

    /**
     * Get recent activity for progress tracking
     */
    private function getRecentActivity()
    {
        try {
            $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));
            
            $recentProducts = $this->productModel->where('created_at >=', $thirtyDaysAgo)->countAllResults();
            $recentPosts = $this->blogModel->where('created_at >=', $thirtyDaysAgo)->countAllResults();
            $recentPages = $this->pagesModel->where('datetime_created >=', $thirtyDaysAgo)->countAllResults();
            
            return [
                'products_30d' => $recentProducts,
                'posts_30d' => $recentPosts,
                'pages_30d' => $recentPages,
            ];
        } catch (\Exception $e) {
            log_message('error', 'Dashboard: Error getting recent activity - ' . $e->getMessage());
            return [
                'products_30d' => 0,
                'posts_30d' => 0,
                'pages_30d' => 0,
            ];
        }
    }

    /**
     * Get products by price range for analysis
     */
    private function getProductsByPriceRange()
    {
        $db = \Config\Database::connect();
        
        // Check if table exists
        if (!$db->tableExists('tb_products')) {
            return [];
        }
        
        $query = $db->table('tb_products')
                   ->select("
                       CASE 
                           WHEN regular_price < 50 THEN 'Under $50'
                           WHEN regular_price BETWEEN 50 AND 100 THEN '$50 - $100'
                           WHEN regular_price BETWEEN 100 AND 200 THEN '$100 - $200'
                           ELSE 'Over $200'
                       END as price_range,
                       COUNT(*) as count
                   ", false)
                   ->where('regular_price IS NOT NULL')
                   ->where('regular_price >', 0)
                   ->groupBy("
                       CASE 
                           WHEN regular_price < 50 THEN 'Under $50'
                           WHEN regular_price BETWEEN 50 AND 100 THEN '$50 - $100'
                           WHEN regular_price BETWEEN 100 AND 200 THEN '$100 - $200'
                           ELSE 'Over $200'
                       END
                   ")
                   ->orderBy('count', 'DESC')
                   ->get();
        
        return $query->getResultArray();
    }

    /**
     * API endpoint for dashboard data (AJAX calls)
     */
    public function apiData()
    {
        $analyticsData = $this->getDashboardAnalytics();
        return $this->response->setJSON($analyticsData);
    }
}
