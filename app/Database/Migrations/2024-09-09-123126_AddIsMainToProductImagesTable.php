<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsMainToProductImagesTable extends Migration
{
    public function up()
    {
        $fields = [
            'is_main' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'image_path' // Position the new column after 'image_path'
            ],
        ];

        $this->forge->addColumn('tb_product_images', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_product_images', 'is_main');
    }
}
