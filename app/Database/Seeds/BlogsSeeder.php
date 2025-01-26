<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
use App\Models\UserModel;

class BlogsSeeder extends Seeder
{
    public function run()
    {
        $usersModel = new UserModel();
        $users = $usersModel->getUsers();
        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                $this->db->table('blogs')->insert($this->generateFakeBlogData($user->id));
            }
        }
    }

    private function generateFakeBlogData($userId): array
    {
        $faker = Factory::create();
        return [
            'author_id' => $userId,
            'seo_title' => $faker->title(),
            'seo_description' => $faker->text(),
            'title' => $faker->title(),
            'subtitle' => $faker->title(),
            'image' => 'seedImage.jpg',
            'content' => $faker->text(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
