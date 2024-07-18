<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateExchangeRequestsTableMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'sender_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'receiver_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'album_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'cards_offered' => [
                'type' => 'JSON',
                'null' => false,
            ],
            'cards_requested' => [
                'type' => 'JSON',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'accepted', 'declined', 'deleted'],
                'default' => 'pending',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'on update' => new RawSql('CURRENT_TIMESTAMP')
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('sender_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('receiver_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('album_id', 'tb_album_collections', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('exchange_requests');
    }

    public function down()
    {
        $this->forge->dropTable('exchange_requests');
    }
}
