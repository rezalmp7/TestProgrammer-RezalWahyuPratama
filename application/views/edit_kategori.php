
<div class="col-12 m-0 p-0">
    <div class="col-12 m-0 p-5">
        <div class="card">
            <div class="card-header">
                Edit Data Kategori
            </div>
            <div class="card-body">
                <h5 class="card-title">Edit Data Kategori</h5>
                <form method="POST" action="<?php echo base_url(); ?>kategori/update/<?php echo $kategori->id_kategori; ?>">
                    <div class="mb-3">
                        <label for="inputNamaProduk" class="form-label">Nama Kategori</label>
                        <input type="text" value="<?php echo $kategori->nama_kategori; ?>" class="form-control" name="nama_kategori" id="inputNamaProduk" aria-describedby="namaProdukHelp" required>
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