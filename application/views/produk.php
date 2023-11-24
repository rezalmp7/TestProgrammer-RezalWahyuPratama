
<div class="col-12 m-0 p-0">
    <div class="col-12 m-0 p-5">
        <div class="card">
            <div class="card-header">
                Data Produk
            </div>
            <div class="card-body">
                <h5 class="card-title">Data Produk</h5>

                <button onclick="getDataAPI()" class="btn btn-sm btn-primary float-end">Get Data API</button>
                <a href="<?php echo base_url(); ?>produk/tambah" class="btn btn-sm btn-success float-end">Tambah</a>
                <table id="example" class="table table-striped col-12" style="">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($produk as $key => $value) {
                            $nama_produk = $value['nama_produk'];
                        ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $value['nama_produk']; ?></td>
                            <td>Rp <?php echo number_format($value['harga']); ?></td>
                            <td><?php echo $value['nama_kategori']; ?></td>
                            <td><?php echo $value['nama_status']; ?></td>
                            <td>
                                <a href="<?php echo base_url(); ?>produk/edit/<?php echo $value['id_produk']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a onclick="confirm('Apakah kamu ingin menghapus produk <?php echo $nama_produk; ?>')" href="<?php echo base_url(); ?>produk/delete/<?php echo $value['id_produk']; ?>" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    new DataTable('#example');
    var baseUrl = "<?php echo base_url(); ?>";
    console.log(baseUrl);

    function getDataAPI() {
        Swal.fire({
            title: "Get Data From API",
            showCancelButton: true,
            confirmButtonText: "Proses",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const url = `${baseUrl}produk/getDataFromAPI`;
                    const response = await fetch(url);
                    return response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        })
        .then((result) => {
            console.log(result);
            if (result.value.message == "success") {
                Swal.fire({
                    title: "Success Get Data From API!",
                    confirmButtonText: "OK",
                }).then((result) => {
                    location.reload()
                });
            }
        });
    }
</script>