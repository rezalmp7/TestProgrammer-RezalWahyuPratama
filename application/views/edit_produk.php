
<div class="col-12 m-0 p-0">
    <div class="col-12 m-0 p-5">
        <div class="card">
            <div class="card-header">
                Tambah Data Produk
            </div>
            <div class="card-body">
                <h5 class="card-title">Tambah Data Produk</h5>
                <form method="POST" action="<?php echo base_url(); ?>produk/update/<?php echo $produk->id_produk; ?>">
                    <div class="mb-3">
                        <label for="inputNamaProduk" class="form-label">Nama Produk</label>
                        <input value="<?php echo $produk->nama_produk; ?>" type="text" class="form-control" name="nama_produk" id="inputNamaProduk" aria-describedby="namaProdukHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputHargaProduk" class="form-label">Harga Produk</label>
                        <input type="number" value="<?php echo $produk->harga; ?>" class="form-control" name="harga_produk" id="inputHargaProduk" aria-describedby="hargaProdukHelp">
                    </div>
                    <div class="mb-3">
                        <label for="inputKategori" class="form-label col-12">Kategori</label>
                        <select class="js-example-basic-single col-12" name="kategori">
                            <?php
                            foreach ($kategori as $key => $value) {
                            ?>
                            <option value="<?php echo $value['id_kategori']; ?>" <?php if($value['id_kategori'] == $produk->kategori_id) echo "selected"; ?>><?php echo $value['nama_kategori']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="inputStatus" class="form-label col-12">Status</label>
                        <select class="js-example-basic-single col-12" name="status">
                            <?php
                            foreach ($status as $key => $value) {
                            ?>
                            <option value="<?php echo $value['id_status']; ?>" <?php if($value['id_status'] == $produk->status_id) echo "selected"; ?>><?php echo $value['nama_status']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    new DataTable('#example');

    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>