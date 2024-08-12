<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'exchange_request_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'rater_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'rated_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'rating' => [
                'type'       => 'INT',
                'constraint' => 1,
                'unsigned'   => true,
            ],
            'rating_description' => [
                'type'       => 'TEXT',
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'on update' => new RawSql('CURRENT_TIMESTAMP')
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['exchange_request_id', 'rater_id']); // Unique composite key
        $this->forge->addForeignKey('exchange_request_id', 'exchange_requests', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('rater_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('rated_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_user_ratings');
    }

    public function down()
    {
        $this->forge->dropTable('tb_user_ratings');
    }
}