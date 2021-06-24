<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Edit Data
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/'.$data['donasi_id'].'/update') ?>" method="post">
                        <input type="hidden" name="donasi_id" value="<?= $data['donasi_id'] ?>" />
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= $data['nama'] ?>" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" required value="<?= $data['jumlah'] ?>">
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>