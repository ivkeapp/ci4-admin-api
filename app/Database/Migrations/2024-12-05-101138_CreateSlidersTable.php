<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateSlidersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'page_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'slider_type' => [
                'type' => 'ENUM',
                'constraint' => ['popular', 'best_selling', 'selected_collection', 'new_arrivals', 'trending_now', 'seasonal_collection', 'limited_edition', 'discounted', 'top_rated', 'editors_pick', 'featured_products', 'recently_viewed', 'customer_favorites', 'shop_by_category', 'upcoming_launches'],
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'link' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'order' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'on update' => new RawSql('CURRENT_TIMESTAMP')
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('page_id', 'tb_fixed_pages', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_sliders');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'slider_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('slider_id', 'tb_sliders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'tb_products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_slider_products');
    }

    public function down()
    {
        $this->forge->dropTable('tb_slider_products');
        $this->forge->dropTable('tb_sliders');
    }
}
