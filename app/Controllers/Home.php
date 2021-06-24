<?php

namespace App\Controllers;
use App\Models\DonasiModel;
use Config\Services;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
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
	public function index()
	{
		return view('list');
	}
	public function get()
    {
        $request = Services::request();
        $datatable = new DonasiModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $list->donasi_id;
                $row[] = $list->tanggal;
				$row[] = $list->nama;
                $row[] = $list->jumlah;
				$row[] = '<a class="btn btn-sm btn-primary" href="'.$list->donasi_id.'/edit">Edit</a>&nbsp;<a href="#" data-href="'.base_url('/'.$list->donasi_id.'/delete').'" onclick="confirmToDelete(this)" class="btn btn-sm btn-danger">Hapus</a>';
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
	public function tambah() {
		return view('tambah');
	}
	public function add() {
		// lakukan validasi
		$request = Services::request();
        $validation =  Services::validation();
        $validation->setRules(
			[
				'nama' => 'required', 
				'jumlah'=>'required',
			]
		);
        $isDataValid = $validation->withRequest($request)->run();

        // jika data valid, simpan ke database
        if($isDataValid){
            $model = new DonasiModel($request);
            $model->insert([
				"donasi_id" => "DN-".$this->randString(),
				"tanggal" => date("Y-m-d H:i:s"),
                "nama" => $request->getPost('nama'),
				"jumlah" => $request->getPost('jumlah'),
            ]);
            return redirect('/');
        }
		
        // tampilkan form create
        echo view('tambah');
	}
	public function edit($id) {
		$request = Services::request();
		$model = new DonasiModel($request);
		$data['data'] = $model->where('donasi_id', $id)->first();
		
		if(!$data['data']){
			throw PageNotFoundException::forPageNotFound();
		}
		echo view('edit', $data);
	}
	public function update($id) {
		$request = Services::request();
		// ambil donasi yang akan diedit
        $model = new DonasiModel($request);
        $data['data'] = $model->where('donasi_id', $id)->first();
        
        // lakukan validasi data donasi
        $validation =  Services::validation();
        $validation->setRules([
            'donasi_id' => 'required',
            'nama' => 'required', 
			'jumlah'=>'required',
        ]);
        $isDataValid = $validation->withRequest($request)->run();
        // jika data vlid, maka simpan ke database
        if($isDataValid){
            $model->update($id, [
                "nama" => $request->getPost('nama'),
				"jumlah" => $request->getPost('jumlah'),
            ]);
            return redirect('/');
        }

        // tampilkan form edit
        echo view('edit', $data);
    }

    //--------------------------------------------------------------------------

	public function delete($id){
		$request = Services::request();
        $model = new DonasiModel($request);
        $model->delete($id);
        return redirect('/');
    }
}
