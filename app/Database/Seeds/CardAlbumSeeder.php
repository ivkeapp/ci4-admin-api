<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CardAlbumSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // User IDs to randomly assign
        $userIds = [1, 2, 3, 5];

        for ($i = 0; $i < 100; $i++) {
            $cards = [];

            // Generate random cards array
            for ($j = 0; $j < rand(5, 20); $j++) {
                $cards[] = [
                    'card_title' => $faker->sentence,
                    'card_description' => $faker->paragraph,
                ];
            }

            $data = [
                'user_id' => $faker->randomElement($userIds),
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'cards' => json_encode($cards),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Insert each album data into the card_albums table
            $this->db->table('card_albums')->insert($data);
        }
    }
}