<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDonasi extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'donasi_id'          => [
					'type'           => 'VARCHAR',
					'constraint'     => "10",					
			],
			'tanggal'       => [
				'type'       => 'DATETIME',
				'null' => true,
			],
			'nama'       => [
					'type'       => 'VARCHAR',
					'constraint' => '100',
			],
			'jumlah' => [
				'type' => 'INTEGER',
				'null' => false,
			],
		]);
		$this->forge->addKey('donasi_id', true);
		$this->forge->createTable('donasi');
	}

	public function down()
	{
		$this->forge->dropTable('donasi');
	}
}
