<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HomepageSeeder extends Seeder
{
    public function run()
    {
         // Insert Fixed Page
        //  $this->db->table('tb_fixed_pages')->insert([
        //     'page_name' => 'Homepage',
        //     'slug' => 'homepage',
        //     'meta_title' => 'Welcome to Our Store',
        //     'meta_description' => 'Discover the best products, collections, and deals.',
        //     'meta_keywords' => 'shop, best products, collections, deals',
        // ]);

        // Get Page ID
        // $pageId = $this->db->table('tb_fixed_pages')->where('slug', 'homepage')->get()->getRow()->id;

        // Insert Sections
        $sections = [
            // Hero Section
            [
                'page_id' => 1,
                'section_type' => 'hero',
                'image' => 'hero-background.jpg',
                'title' => 'Welcome to Our Store',
                'subtitle' => 'Discover amazing products just for you',
                'button_text' => 'Shop Now',
                'button_link' => '/shop',
            ],
            // Two Column Section
            [
                'page_id' => 1,
                'section_type' => 'two-column',
                'image' => 'column1.jpg',
                'title' => 'Explore Collections',
                'subtitle' => 't',
                'button_text' => 'View More',
                'button_link' => '/collections',
            ],
            [
                'page_id' => 1,
                'section_type' => 'two-column',
                'image' => 'column2.jpg',
                'title' => 'Discover Deals',
                'subtitle' => 't',
                'button_text' => 'Shop Deals',
                'button_link' => '/deals',
            ],
            // Fourth Section
            [
                'page_id' => 1,
                'section_type' => 'hero',
                'image' => 'fourth-section-background.jpg',
                'title' => 'Limited Edition Products',
                'subtitle' => 'Exclusive deals for limited time only',
                'button_text' => 'Learn More',
                'button_link' => '/limited-edition',
            ],
            // Fifth Section (Two Rows of Two Columns)
            [
                'page_id' => 1,
                'section_type' => 'two-column',
                'image' => 'fifth-row1-col1.jpg',
                'title' => 'Row 1 - Column 1',
                'subtitle' => 't',
                'button_text' => 'Check It Out',
                'button_link' => '/row1-col1',
            ],
            [
                'page_id' => 1,
                'section_type' => 'two-column',
                'image' => 'fifth-row1-col2.jpg',
                'title' => 'Row 1 - Column 2',
                'subtitle' => 't',
                'button_text' => 'Discover',
                'button_link' => '/row1-col2',
            ],
            [
                'page_id' => 1,
                'section_type' => 'two-column',
                'image' => 'fifth-row2-col1.jpg',
                'title' => 'Row 2 - Column 1',
                'subtitle' => 't',
                'button_text' => 'Find Out',
                'button_link' => '/row2-col1',
            ],
            [
                'page_id' => 1,
                'section_type' => 'two-column',
                'image' => 'fifth-row2-col2.jpg',
                'title' => 'Row 2 - Column 2',
                'subtitle' => 't',
                'button_text' => 'Explore',
                'button_link' => '/row2-col2',
            ],
        ];
        $this->db->table('tb_page_sections')->insertBatch($sections);

        // Insert Sliders
        $sliders = [
            [
                'page_id' => 1,
                'slider_type' => 'popular',
                'title' => 'Popular Products',
                'link' => '/popular-products',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'page_id' => 1,
                'slider_type' => 'best_selling',
                'title' => 'Best Selling Products',
                'link' => '/best-sellers',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'page_id' => 1,
                'slider_type' => 'selected_collection',
                'title' => 'Selected Collections',
                'link' => '/collections',
                'is_active' => true,
                'order' => 3,
            ],
        ];
        $this->db->table('tb_sliders')->insertBatch($sliders);

        // Insert Slider Products
        $sliders = $this->db->table('tb_sliders')->get()->getResult();

        $products = [
            11, 12, 13, 14, 15, // IDs for popular products
            16, 17, 18, 19, 10, // IDs for best-selling products
            20 // IDs for selected collection
        ];

        $sliderProducts = [];
        foreach ($sliders as $slider) {
            foreach (array_slice($products, 0, 5) as $productId) {
                $sliderProducts[] = [
                    'slider_id' => $slider->id,
                    'product_id' => $productId,
                ];
            }
            array_splice($products, 0, 5);
        }

        $this->db->table('tb_slider_products')->insertBatch($sliderProducts);
    }
}
