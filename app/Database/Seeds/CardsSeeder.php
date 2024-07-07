<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CardsSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        // Sample card collections
        $sampleCollections = [
            json_encode([1, 5, 'M3', 'J45', 8]),
            json_encode(['A1', 3, 'Q2', 'R5']),
            json_encode(['B2', 7, 2, 'H8']),
            json_encode(['C4', 10, 'N1', 'L6']),
            json_encode([9, 'D3', 'G7', 4]),
        ];

        // Sample album_ids (these should correspond to existing ids in card_albums table)
        $albumIds = [1, 2, 3, 4, 5];

        foreach ($albumIds as $albumId) {
            $data[] = [
                'album_id' => $albumId,
                'cards' => $sampleCollections[array_rand($sampleCollections)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Using Query Builder
        $this->db->table('tb_cards')->insertBatch($data);
    }
}
