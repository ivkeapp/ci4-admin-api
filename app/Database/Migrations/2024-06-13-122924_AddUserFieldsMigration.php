<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserFieldsMigration extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'mobile_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'mobile_phone');
        $this->forge->dropColumn('users', 'address');
        $this->forge->dropColumn('users', 'first_name');
        $this->forge->dropColumn('users', 'last_name');
    }
}
