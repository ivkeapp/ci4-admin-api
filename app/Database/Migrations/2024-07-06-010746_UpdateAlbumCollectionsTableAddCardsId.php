<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAlbumCollectionsTableAddCardsId extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_album_collections', [
            'cards_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id',
            ]
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('cards_id', 'tb_cards', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('tb_album_collections', 'tb_album_collections_cards_id_foreign');
        $this->forge->dropColumn('tb_album_collections', 'cards_id');
    }
}
