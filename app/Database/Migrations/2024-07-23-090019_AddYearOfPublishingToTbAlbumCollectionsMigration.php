<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddYearOfPublishingToTbAlbumCollectionsMigration extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_album_collections', [
            'publishing_year' => [
                'type' => 'INT',
                'constraint' => 4,
                'unsigned' => true,
                'null' => true,
                'after' => 'publisher'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_album_collections', 'publishing_year');
    }
}
