<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClothingProductsSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // Male Clothing
            [
                'sku' => 'M-SHORT-001',
                'short_name' => 'Men\'s Sports Shorts',
                'long_name' => 'Comfortable Men\'s Sports Shorts',
                'slug' => 'mens-sports-shorts-54',
                'description' => 'Durable and lightweight sports shorts for men.',
                'price_in' => 10.00,
                'price_with_margin' => 12.50,
                'regular_price' => 15.00,
                'package_size' => 'Medium',
                'package_weight' => 0.5,
                'metadata' => json_encode(['material' => 'Polyester']),
                'category_id' => 56, // Men's Clothing
                'subcategory_id' => 58, // Shorts
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            [
                'sku' => 'M-TOP-002',
                'short_name' => 'Men\'s T-shirt',
                'long_name' => 'Classic Men\'s Cotton T-shirt',
                'slug' => 'mens-cotton-tshirt-2',
                'description' => 'Premium quality T-shirt with a comfortable fit.',
                'price_in' => 8.00,
                'price_with_margin' => 10.00,
                'regular_price' => 12.00,
                'package_size' => 'Small',
                'package_weight' => 0.3,
                'metadata' => json_encode(['color' => 'Black']),
                'category_id' => 56,
                'subcategory_id' => 60, // T-shirts
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            // Female Clothing
            [
                'sku' => 'F-TOP-003',
                'short_name' => 'Women\'s Summer Top',
                'long_name' => 'Stylish Women\'s Summer Top',
                'slug' => 'womens-summer-top-12',
                'description' => 'Breathable summer top, perfect for sunny days.',
                'price_in' => 9.00,
                'price_with_margin' => 11.50,
                'regular_price' => 14.00,
                'package_size' => 'Small',
                'package_weight' => 0.25,
                'metadata' => json_encode(['style' => 'Casual']),
                'category_id' => 57,
                'subcategory_id' => 66, // Tops
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            [
                'sku' => 'F-SHORT-004',
                'short_name' => 'Women\'s Athletic Shorts',
                'long_name' => 'High-Performance Women\'s Athletic Shorts',
                'slug' => 'womens-athletic-shorts-4',
                'description' => 'Perfect for running, gym, or casual wear.',
                'price_in' => 12.00,
                'price_with_margin' => 15.00,
                'regular_price' => 18.00,
                'package_size' => 'Medium',
                'package_weight' => 0.4,
                'metadata' => json_encode(['color' => 'Pink']),
                'category_id' => 57,
                'subcategory_id' => 59,
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            [
                'sku' => 'F-SHORT-005',
                'short_name' => 'Women\'s Athletic Shorts',
                'long_name' => 'High-Performance Women\'s Athletic Shorts',
                'slug' => 'womens-athletic-shorts-11',
                'description' => 'Perfect for running, gym, or casual wear.',
                'price_in' => 12.00,
                'price_with_margin' => 15.00,
                'regular_price' => 18.00,
                'package_size' => 'Medium',
                'package_weight' => 0.4,
                'metadata' => json_encode(['color' => 'Pink']),
                'category_id' => 57,
                'subcategory_id' => 59,
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            [
                'sku' => 'F-SHORT-006',
                'short_name' => 'Women\'s Athletic Shorts',
                'long_name' => 'High-Performance Women\'s Athletic Shorts',
                'slug' => 'high-performance-womens-athletic-shorts',
                'description' => 'Perfect for running, gym, or casual wear.',
                'price_in' => 12.00,
                'price_with_margin' => 15.00,
                'regular_price' => 18.00,
                'package_size' => 'Medium',
                'package_weight' => 0.4,
                'metadata' => json_encode(['color' => 'Pink']),
                'category_id' => 57,
                'subcategory_id' => 59,
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            [
                'sku' => 'F-SHORT-007',
                'short_name' => 'Women\'s Athletic Shorts',
                'long_name' => 'High-Performance Women\'s Athletic Shorts',
                'slug' => 'womens-athletic-shorts-2',
                'description' => 'Perfect for running, gym, or casual wear.',
                'price_in' => 12.00,
                'price_with_margin' => 15.00,
                'regular_price' => 18.00,
                'package_size' => 'Medium',
                'package_weight' => 0.4,
                'metadata' => json_encode(['color' => 'Pink']),
                'category_id' => 57,
                'subcategory_id' => 59,
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            [
                'sku' => 'M-TOP-003',
                'short_name' => 'Men\'s T-shirt',
                'long_name' => 'Classic Men\'s Cotton T-shirt',
                'slug' => 'mens-cotton-tshirt-3',
                'description' => 'Premium quality T-shirt with a comfortable fit.',
                'price_in' => 8.00,
                'price_with_margin' => 10.00,
                'regular_price' => 12.00,
                'package_size' => 'Small',
                'package_weight' => 0.3,
                'metadata' => json_encode(['color' => 'Black']),
                'category_id' => 56,
                'subcategory_id' => 60, // T-shirts
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            [
                'sku' => 'M-TOP-004',
                'short_name' => 'Men\'s T-shirt',
                'long_name' => 'Classic Men\'s Cotton T-shirt',
                'slug' => 'mens-cotton-tshirt-4',
                'description' => 'Premium quality T-shirt with a comfortable fit.',
                'price_in' => 8.00,
                'price_with_margin' => 10.00,
                'regular_price' => 12.00,
                'package_size' => 'Small',
                'package_weight' => 0.3,
                'metadata' => json_encode(['color' => 'Black']),
                'category_id' => 56,
                'subcategory_id' => 60, // T-shirts
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            [
                'sku' => 'M-TOP-005',
                'short_name' => 'Men\'s T-shirt',
                'long_name' => 'Classic Men\'s Cotton T-shirt',
                'slug' => 'mens-cotton-tshirt-5',
                'description' => 'Premium quality T-shirt with a comfortable fit.',
                'price_in' => 8.00,
                'price_with_margin' => 10.00,
                'regular_price' => 12.00,
                'package_size' => 'Small',
                'package_weight' => 0.3,
                'metadata' => json_encode(['color' => 'Black']),
                'category_id' => 56,
                'subcategory_id' => 60, // T-shirts
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            [
                'sku' => 'M-SHORT-002',
                'short_name' => 'Men\'s Sports Shorts',
                'long_name' => 'Comfortable Men\'s Sports Shorts',
                'slug' => 'mens-sports-shorts-23',
                'description' => 'Durable and lightweight sports shorts for men.',
                'price_in' => 10.00,
                'price_with_margin' => 12.50,
                'regular_price' => 15.00,
                'package_size' => 'Medium',
                'package_weight' => 0.5,
                'metadata' => json_encode(['material' => 'Polyester']),
                'category_id' => 56, // Clothing
                'subcategory_id' => 58, // Shorts
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
            [
                'sku' => 'M-SHORT-003',
                'short_name' => 'Men\'s Sports Shorts',
                'long_name' => 'Comfortable Men\'s Sports Shorts',
                'slug' => 'mens-sports-shorts',
                'description' => 'Durable and lightweight sports shorts for men.',
                'price_in' => 10.00,
                'price_with_margin' => 12.50,
                'regular_price' => 15.00,
                'package_size' => 'Medium',
                'package_weight' => 0.5,
                'metadata' => json_encode(['material' => 'Polyester']),
                'category_id' => 56, // Clothing
                'subcategory_id' => 58, // Shorts
                'subsubcategory_id' => null,
                'user_id' => 1,
            ],
        ];

        // Insert products
        $this->db->table('tb_products')->insertBatch($products);
    }
}
