<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSenderIdToNotificationsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_notifications', [
            'sender_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'after' => 'user_id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_notifications', 'sender_id');
    }
}
