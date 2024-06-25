<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserImagePathToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'image_path');
    }
}
