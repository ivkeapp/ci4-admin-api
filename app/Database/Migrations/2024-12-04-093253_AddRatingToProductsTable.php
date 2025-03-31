<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRatingToProductsTable extends Migration
{
    public function up()
    {
        $fields = [
            'rating' => [
                'type' => 'DECIMAL',
                'constraint' => '2,1',
                'null' => true,
                'default' => null,
            ],
            'number_of_ratings' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0,
            ],
        ];
        $this->forge->addColumn('tb_products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_products', 'rating');
        $this->forge->dropColumn('tb_products', 'number_of_ratings');
    }
}
