<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 5,
                "unsigned" => true,
                "auto_increment" => true
            ],
            "name" => [
                "type" => "VARCHAR",
                "constraint" => 100,
                "null" => false
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
