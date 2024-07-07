<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlbumCollectionsSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 100; $i++) {
            $data[] = [
                'title' => "Album Collection $i",
                'image' => "image$i.jpg",
                'description' => "Description for Album Collection $i",
                'publisher' => "Publisher $i",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Using Query Builder
        $this->db->table('tb_album_collections')->insertBatch($data);
    }
}
