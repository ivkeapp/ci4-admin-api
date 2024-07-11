<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCardAlbumsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('card_albums', [
            'cards_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'after' => 'cards',
            ]
        ]);

        // Add Foreign Key
        $this->forge->addForeignKey('cards_id', 'tb_cards', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop Foreign Key first
        $this->forge->dropForeignKey('card_albums', 'card_albums_cards_id_foreign');

        // Drop Column
        $this->forge->dropColumn('card_albums', 'cards_id');
    }
}
