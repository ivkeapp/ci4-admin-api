<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNeededCardsToCardAlbumsTableMigration extends Migration
{
    public function up()
    {
        $this->forge->addColumn('card_albums', [
            'needed_cards' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'cards',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('card_albums', 'needed_cards');
    }
}
