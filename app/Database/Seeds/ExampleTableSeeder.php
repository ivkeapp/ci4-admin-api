<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExampleTableSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        for ($i = 1; $i <= 200; $i++) {
            $data[] = [
                'field1' => 'Sample Data ' . $i,
                'field2' => 'This is sample text for field2, entry ' . $i,
                'field3' => rand(1, 1000)
            ];
        }

        // Using Query Builder
        $this->db->table('example_table')->insertBatch($data);
    }
}
