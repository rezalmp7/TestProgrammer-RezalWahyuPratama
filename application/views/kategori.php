
<div class="col-12 m-0 p-0">
    <div class="col-12 m-0 p-5">
        <div class="card">
            <div class="card-header">
                Data Kategori
            </div>
            <div class="card-body">
                <h5 class="card-title">Data Kategori</h5>

                <a href="<?php echo base_url(); ?>kategori/tambah" class="btn btn-sm btn-success float-end">Tambah</a>
                <table id="example" class="table table-striped col-12" style="">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($kategori as $key => $value) {
                            $nama_kategori = $value['nama_kategori'];
                        ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $value['nama_kategori']; ?></td>
                            <td>
                                <a href="<?php echo base_url(); ?>kategori/edit/<?php echo $value['id_kategori']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a onclick="confirm('Apakah kamu ingin menghapus produk <?php echo $nama_kategori; ?>')" href="<?php echo base_url(); ?>kategori/delete/<?php echo $value['id_kategori']; ?>" class="btn btn-sm btn-danger">Hapus</a>
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
</script>