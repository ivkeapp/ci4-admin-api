<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCompletionFlagsToExchangeRequests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('exchange_requests', [
            'sender_completed' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'status'
            ],
            'receiver_completed' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'sender_completed'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('exchange_requests', 'sender_completed');
        $this->forge->dropColumn('exchange_requests', 'receiver_completed');
    }
}
