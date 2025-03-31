<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateSectionsTable extends Migration
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
            'section_type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'subtitle' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'button_text' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'button_link' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
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
        $this->forge->createTable('tb_page_sections');
    }

    public function down()
    {
        $this->forge->dropTable('tb_page_sections');
    }
}
