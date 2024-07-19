<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationAddCompletedStatusToExchangeRequests extends Migration
{
    public function up()
    {
        // Modify the 'status' column to include 'completed'
        $this->db->query("ALTER TABLE `exchange_requests` MODIFY COLUMN `status` ENUM('pending', 'accepted', 'declined', 'deleted', 'completed') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        // WARNING: Modifying ENUM columns directly to remove options can lead to data loss.
        // Implement this method with caution and consider your specific requirements.
        echo "Reverting this migration may lead to data loss for 'completed' statuses. Manual intervention required.";
    }
}
