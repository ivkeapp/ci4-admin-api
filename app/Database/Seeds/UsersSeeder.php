<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UsersSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) { //to add 10 clients. Change limit as desired
            $this->db->table('users')->insert($this->generateFakeUserData());
        }
    }

    private function generateFakeUserData(): array
    {
        $faker = Factory::create();
        return [
            'username' => $faker->userName(),
            'created_at' => date('Y-m-d H:i:s')
        ];
    }
}