<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationAddStatusToCardAlbums extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `card_albums` ADD COLUMN `status` ENUM('active', 'archived', 'expired') NOT NULL DEFAULT 'active'");
    }

    public function down()
    {
        echo "Reverting this migration may lead to data loss for 'status' values. Manual intervention required.";
    }
}
