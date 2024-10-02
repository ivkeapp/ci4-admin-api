<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Level 1 Categories
            ['name' => 'Computers', 'parent_id' => null, 'level' => 1, 'slug' => 'computers', 'description' => 'All types of computers including desktops, laptops, and tablets.'],
            ['name' => 'Networking', 'parent_id' => null, 'level' => 1, 'slug' => 'networking', 'description' => 'Networking equipment like routers, switches, and cables.'],
            ['name' => 'Peripherals', 'parent_id' => null, 'level' => 1, 'slug' => 'peripherals', 'description' => 'Computer peripherals like keyboards, mice, monitors, and more.'],
            ['name' => 'Components', 'parent_id' => null, 'level' => 1, 'slug' => 'components', 'description' => 'All types of computer components like CPUs, GPUs, RAM, etc.'],
            ['name' => 'Software', 'parent_id' => null, 'level' => 1, 'slug' => 'software', 'description' => 'All kinds of software including operating systems, applications, and games.'],

            // Level 2 Subcategories for Computers
            ['name' => 'Laptops', 'parent_id' => 1, 'level' => 2, 'slug' => 'laptops', 'description' => 'Various types of laptops for different needs.'],
            ['name' => 'Desktops', 'parent_id' => 1, 'level' => 2, 'slug' => 'desktops', 'description' => 'Desktop computers for home and office use.'],
            ['name' => 'Tablets', 'parent_id' => 1, 'level' => 2, 'slug' => 'tablets', 'description' => 'Portable tablet computers.'],

            // Level 3 Sub-subcategories for Laptops
            ['name' => 'Gaming Laptops', 'parent_id' => 6, 'level' => 3, 'slug' => 'gaming-laptops', 'description' => 'High-performance laptops for gaming.'],
            ['name' => 'Business Laptops', 'parent_id' => 6, 'level' => 3, 'slug' => 'business-laptops', 'description' => 'Laptops tailored for business use.'],
            ['name' => '2-in-1 Laptops', 'parent_id' => 6, 'level' => 3, 'slug' => '2-in-1-laptops', 'description' => 'Convertible laptops with touchscreens.'],

            // Level 2 Subcategories for Networking
            ['name' => 'Routers', 'parent_id' => 2, 'level' => 2, 'slug' => 'routers', 'description' => 'Routers for home and office networking.'],
            ['name' => 'Switches', 'parent_id' => 2, 'level' => 2, 'slug' => 'switches', 'description' => 'Network switches for business and home use.'],

            // Level 3 Sub-subcategories for Routers
            ['name' => 'Wi-Fi Routers', 'parent_id' => 12, 'level' => 3, 'slug' => 'wifi-routers', 'description' => 'Wireless routers for high-speed internet access.'],
            ['name' => 'Wired Routers', 'parent_id' => 12, 'level' => 3, 'slug' => 'wired-routers', 'description' => 'Wired routers for stable internet connections.'],

            // Level 2 Subcategories for Peripherals
            ['name' => 'Keyboards', 'parent_id' => 3, 'level' => 2, 'slug' => 'keyboards', 'description' => 'Computer keyboards for typing and gaming.'],
            ['name' => 'Mice', 'parent_id' => 3, 'level' => 2, 'slug' => 'mice', 'description' => 'Computer mice for precise navigation.'],
            ['name' => 'Monitors', 'parent_id' => 3, 'level' => 2, 'slug' => 'monitors', 'description' => 'Monitors for various display needs.'],

            // Level 3 Sub-subcategories for Keyboards
            ['name' => 'Mechanical Keyboards', 'parent_id' => 15, 'level' => 3, 'slug' => 'mechanical-keyboards', 'description' => 'Mechanical keyboards for gaming and typing.'],
            ['name' => 'Wireless Keyboards', 'parent_id' => 15, 'level' => 3, 'slug' => 'wireless-keyboards', 'description' => 'Wireless keyboards for mobility.'],

            // Level 2 Subcategories for Components
            ['name' => 'Processors', 'parent_id' => 4, 'level' => 2, 'slug' => 'processors', 'description' => 'Computer processors (CPUs) from different brands.'],
            ['name' => 'Graphics Cards', 'parent_id' => 4, 'level' => 2, 'slug' => 'graphics-cards', 'description' => 'Graphics cards (GPUs) for gaming and professional use.'],
            ['name' => 'Memory (RAM)', 'parent_id' => 4, 'level' => 2, 'slug' => 'memory-ram', 'description' => 'Various types of memory (RAM) for different needs.'],

            // Level 3 Sub-subcategories for Graphics Cards
            ['name' => 'NVIDIA GPUs', 'parent_id' => 18, 'level' => 3, 'slug' => 'nvidia-gpus', 'description' => 'Graphics cards from NVIDIA.'],
            ['name' => 'AMD GPUs', 'parent_id' => 18, 'level' => 3, 'slug' => 'amd-gpus', 'description' => 'Graphics cards from AMD.'],
        ];

        // Using Query Builder to insert data
        $this->db->table('tb_product_categories')->insertBatch($data);
    }
}
