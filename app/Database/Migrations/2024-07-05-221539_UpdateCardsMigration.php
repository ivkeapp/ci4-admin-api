<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCardsMigration extends Migration
{
    public function up()
    {
        // Add Foreign Key
        $this->forge->addForeignKey('album_id', 'card_albums', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop Foreign Key first
        $this->forge->dropForeignKey('card_albums', 'card_albums_cards_id_foreign');
    }
}
