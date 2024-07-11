<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCardAlbumsTableAddAlbumId extends Migration
{
    public function up()
    {
        $this->forge->addColumn('card_albums', [
            'album_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id',
            ]
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('album_id', 'tb_album_collections', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop foreign key constraint
        $this->forge->dropForeignKey('card_albums', 'card_albums_album_id_foreign');

        $this->forge->dropColumn('card_albums', 'album_id');
    }
}
