<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class UpdateDatetimeFieldsInPagesFix extends Migration
{
    public function up()
    {
        $fields = [
            'datetime_created' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'datetime_updated' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'on update' => new RawSql('CURRENT_TIMESTAMP')
            ]
        ];
        $this->forge->modifyColumn('pages', $fields);
    }

    public function down()
    {
        //
    }
}
