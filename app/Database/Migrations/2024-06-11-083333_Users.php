<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        // $this->forge->addField([
        //     "id" => [
        //         "type" => "INT",
        //         "constraint" => 5,
        //         "unsigned" => true,
        //         "auto_increment" => true
        //     ],
        //     "name" => [
        //         "type" => "VARCHAR",
        //         "constraint" => 100,
        //         "null" => false
        //     ],
        //     "email" => [
        //         "type" => "VARCHAR",
        //         "constraint" => 50,
        //         "null" => true
        //     ],
        //     "phone" => [
        //         "type" => "VARCHAR",
        //         "constraint" => 50,
        //         "null" => true
        //     ],
        // ]);

        // $this->forge->addPrimaryKey("id");

        // $this->forge->createTable("users");
    }

    public function down()
    {
        // $this->forge->dropTable("users");
        $this->db->table('users')->truncate();
    }
    
    public function rollback()
    {
        $this->db->table('users')->truncate();
    }

}
