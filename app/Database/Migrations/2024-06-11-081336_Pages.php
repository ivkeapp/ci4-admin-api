<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'user_created' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false,
            ],
            'datetime_created' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'null' => false,
                'default' => true,
            ],
            'url_slug' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'datetime_updated' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'user_updated' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_created', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pages', TRUE, ['ENGINE' => 'InnoDB']);

    }

    public function down()
    {
        $this->forge->dropTable('pages');
    }
}