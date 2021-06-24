<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DonasiSeeder extends Seeder
{
	public function randString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
	public function run()
	{
		$data = [
			'donasi_id' => "DN-".$this->randString(),
			'tanggal' => date("Y-m-d H:i:s"),
			'nama' => 'Hamba Allah',
			'jumlah'=> 100000,
		];
		$this->db->query("INSERT INTO donasi (donasi_id, tanggal,nama,jumlah) VALUES(:donasi_id:, :tanggal:, :nama:,:jumlah:)", $data);
	}
}
