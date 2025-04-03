<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPageIdToSections extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_sections', [
            'page_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'id',
            ],
        ]);

        $this->db->query('
            ALTER TABLE tb_sections 
            ADD CONSTRAINT fk_sections_page 
            FOREIGN KEY (page_id) 
            REFERENCES pages(id) 
            ON DELETE CASCADE;
        ');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE tb_sections DROP FOREIGN KEY fk_sections_page');
        $this->forge->dropColumn('tb_sections', 'page_id');
    }
}
