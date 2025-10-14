<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DashboardDataSeeder extends Seeder
{
    public function run()
    {
        // Seed Categories
        $categories = [
            ['name' => 'Electronics', 'parent_id' => null, 'level' => 1, 'slug' => 'electronics', 'description' => 'Electronic devices and gadgets'],
            ['name' => 'Clothing', 'parent_id' => null, 'level' => 1, 'slug' => 'clothing', 'description' => 'Fashion and apparel'],
            ['name' => 'Books', 'parent_id' => null, 'level' => 1, 'slug' => 'books', 'description' => 'Books and literature'],
            ['name' => 'Home & Garden', 'parent_id' => null, 'level' => 1, 'slug' => 'home-garden', 'description' => 'Home improvement and gardening'],
            ['name' => 'Sports', 'parent_id' => null, 'level' => 1, 'slug' => 'sports', 'description' => 'Sports equipment and gear'],
        ];

        foreach ($categories as $category) {
            $this->db->table('tb_product_categories')->insert([
                'name' => $category['name'],
                'parent_id' => $category['parent_id'],
                'level' => $category['level'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Get category IDs for products
        $categoryIds = $this->db->table('tb_product_categories')->select('id')->get()->getResultArray();
        $categoryIds = array_column($categoryIds, 'id');

        // Seed Products
        $products = [];
        $productNames = [
            'Wireless Headphones', 'Smart Watch', 'Laptop Stand', 'Bluetooth Speaker',
            'Cotton T-Shirt', 'Denim Jeans', 'Running Shoes', 'Leather Jacket',
            'Programming Book', 'Novel Collection', 'Art History', 'Cook Book',
            'Garden Tools', 'Home Decor', 'Kitchen Appliances', 'Furniture Set',
            'Tennis Racket', 'Yoga Mat', 'Basketball', 'Fitness Equipment'
        ];

        for ($i = 0; $i < 50; $i++) {
            $name = $productNames[array_rand($productNames)] . ' ' . ($i + 1);
            $price = rand(20, 500);
            $categoryId = $categoryIds[array_rand($categoryIds)];
            
            // Vary the creation dates over the last 12 months
            $createdDate = date('Y-m-d H:i:s', strtotime('-' . rand(0, 365) . ' days'));
            
            $products[] = [
                'sku' => 'SKU-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'short_name' => $name,
                'long_name' => $name . ' - Premium Quality',
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'description' => 'High-quality ' . strtolower($name) . ' with excellent features.',
                'price_in' => $price * 0.7,
                'price_with_margin' => $price * 0.85,
                'regular_price' => $price,
                'package_size' => rand(1, 5) . ' units',
                'package_weight' => rand(100, 2000) . 'g',
                'category_id' => $categoryId,
                'user_id' => 1,
                'created_at' => $createdDate,
                'updated_at' => $createdDate
            ];
        }

        $this->db->table('tb_products')->insertBatch($products);

        // Seed Blog Posts
        $blogPosts = [];
        $blogTitles = [
            'Getting Started with Web Development',
            'Best Practices for Database Design',
            'Modern CSS Techniques',
            'JavaScript ES6 Features',
            'PHP 8 New Features',
            'Building Responsive Websites',
            'API Development Guide',
            'Security Best Practices',
            'Performance Optimization Tips',
            'Code Review Guidelines'
        ];

        for ($i = 0; $i < 25; $i++) {
            $title = $blogTitles[array_rand($blogTitles)];
            $createdDate = date('Y-m-d H:i:s', strtotime('-' . rand(0, 180) . ' days'));
            
            $blogPosts[] = [
                'author_id' => 1,
                'seo_title' => $title . ' - SEO Optimized',
                'seo_description' => 'Learn about ' . strtolower($title) . ' in this comprehensive guide.',
                'title' => $title,
                'subtitle' => 'A comprehensive guide for developers',
                'image' => 'blog-image-' . ($i + 1) . '.jpg',
                'content' => '<p>This is a sample blog post about ' . strtolower($title) . '. It contains valuable information for developers and tech enthusiasts.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                'created_at' => $createdDate,
                'updated_at' => $createdDate
            ];
        }

        $this->db->table('blogs')->insertBatch($blogPosts);

        // Seed Pages
        $pages = [];
        $pageNames = [
            'About Us', 'Contact', 'Privacy Policy', 'Terms of Service',
            'FAQ', 'Support', 'Careers', 'Press Room', 'Partners', 'Testimonials'
        ];

        for ($i = 0; $i < count($pageNames); $i++) {
            $name = $pageNames[$i];
            $createdDate = date('Y-m-d H:i:s', strtotime('-' . rand(0, 90) . ' days'));
            
            $pages[] = [
                'name' => $name,
                'description' => 'This is the ' . strtolower($name) . ' page description.',
                'user_created' => 1,
                'datetime_created' => $createdDate,
                'is_active' => 1,
                'url_slug' => strtolower(str_replace(' ', '-', $name)),
                'datetime_updated' => $createdDate,
                'user_updated' => 1,
                'content' => '<h1>' . $name . '</h1><p>Content for ' . strtolower($name) . ' page goes here.</p>'
            ];
        }

        $this->db->table('pages')->insertBatch($pages);

        echo "Dashboard seed data created successfully!\n";
        echo "- " . count($categories) . " categories created\n";
        echo "- " . count($products) . " products created\n";
        echo "- " . count($blogPosts) . " blog posts created\n";
        echo "- " . count($pages) . " pages created\n";
    }
}