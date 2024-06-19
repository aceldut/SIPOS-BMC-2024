<?php include '../../config.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Perkembangan Anak</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #e9ecef;">
            <li class="breadcrumb-item"><a href="dashboard-page.php" style="color: #007bff; text-decoration: none">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Perkembangan Anak</li>
        </ol>
    </nav>
</div>
<div class="d-flex justify-content-between mb-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPerkembangan">Tambah Data Perkembangan Anak</button>
    <input type="text" class="form-control w-25" placeholder="Search..." style="width: 25%">
</div>
<table class="table table-hover table-bordered" style="background-color: #f8f9fa; margin-top: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <thead class="thead-light">
        <tr>
            <th scope="col">Opsi</th>
            <th scope="col">Nama Anak</th>
            <th scope="col">Tgl</th>
            <th scope="col">Berat Badan</th>
            <th scope="col">Ket</th>
            <th scope="col">Tinggi Badan</th>
            <th scope="col">Ket</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT tbl_perkembangananak.*, tbl_anak.nama_anak FROM tbl_perkembangananak
                  JOIN tbl_anak ON tbl_perkembangananak.id_anak = tbl_anak.id_anak";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr id='row-" . $row['kode'] . "'>";
                echo "<td>
                        <button class='btn btn-sm btn-danger' onclick='confirmDelete(" . $row['kode'] . ")' style='background-color: #dc3545; border-color: #dc3545'>Hapus</button>
                        <button class='btn btn-sm btn-warning' style='background-color: #ffc107; border-color: #ffc107'>Edit</button>
                      </td>";
                echo "<td>" . $row['nama_anak'] . "</td>";
                echo "<td>" . $row['tanggal'] . "</td>";
                echo "<td>" . $row['berat_badan'] . "</td>";
                echo "<td>" . $row['ketbb'] . "</td>";
                echo "<td>" . $row['tinggi_badan'] . "</td>";
                echo "<td>" . $row['kettb'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='text-center'>Tidak ada data</td></tr>";
        }
        ?>
    </tbody>
</table>
<footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="d-flex justify-content-between">
        <small class="d-block mb-3 text-muted">2024 © SIPOS</small>
        <small class="d-block mb-3 text-muted">Crafted By BMC</small>
    </div>
</footer>

<!-- Modal Tambah Data Perkembangan Anak -->
<div class="modal fade" id="modalTambahPerkembangan" tabindex="-1" role="dialog" aria-labelledby="modalTambahPerkembanganLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPerkembanganLabel">Form Tambah Data Perkembangan Anak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTambahPerkembangan" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_anak">ID Anak</label>
                        <select class="form-control" id="id_anak" name="id_anak" required>
                            <?php
                            $query = "SELECT * FROM tbl_anak";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id_anak'] . "' data-nama='" . $row['nama_anak'] . "'>" . $row['nama_anak'] . "</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" id="nama_anak" name="nama_anak">
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="berat_badan">Berat Badan (KG)</label>
                        <input type="number" step="0.01" class="form-control" id="berat_badan" name="berat_badan" placeholder="Masukkan berat badan dalam KG" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_berat_badan">Keterangan Berat Badan</label>
                        <input type="text" class="form-control" id="keterangan_berat_badan" name="keterangan_berat_badan" placeholder="Masukkan keterangan berat badan" required>
                    </div>
                    <div class="form-group">
                        <label for="tinggi_badan">Tinggi Badan (CM)</label>
                        <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" placeholder="Masukkan tinggi badan dalam CM" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_tinggi_badan">Keterangan Tinggi Badan</label>
                        <input type="text" class="form-control" id="keterangan_tinggi_badan" name="keterangan_tinggi_badan" placeholder="Masukkan keterangan tinggi badan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Konfirmasi Penghapusan -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to show snackbar
    function showSnackbar(message, type) {
        var snackbar = document.getElementById("snackbar");
        snackbar.textContent = message;
        snackbar.className = snackbar.className.replace(/\bshow\b/g, "").replace(/\bsnackbar-\S+/g, "");
        snackbar.classList.add('show');
        snackbar.classList.add(`snackbar-${type}`);
        setTimeout(function() {
            snackbar.className = snackbar.className.replace("show", "");
        }, 3000);
    }

    // Handle form submission with AJAX
    function tambahData(id_anak = '', nama_anak = '', tanggal = '', berat_badan = '', keterangan_berat_badan = '', tinggi_badan = '', keterangan_tinggi_badan = '') {
        $('#id_anak').val(id_anak);
        $('#nama_anak').val(nama_anak);
        $('#tanggal').val(tanggal);
        $('#berat_badan').val(berat_badan);
        $('#keterangan_berat_badan').val(keterangan_berat_badan);
        $('#tinggi_badan').val(tinggi_badan);
        $('#keterangan_tinggi_badan').val(keterangan_tinggi_badan);
        $('#modalTambahPerkembanganAnak').modal('show');
    }

    // Handle form submission with AJAX
    $('#formTambahPerkembangan').on('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize();
    console.log('Serialized form data:', formData); // Log form data for debugging

    $.ajax({
        type: 'POST',
        url: 'proses-tambah-perkembangan.php',
        data: formData,
        success: function(response) {
            console.log('AJAX response:', response); // Log response for debugging
            var res = JSON.parse(response);
            if (res.status === 'success') {
                $('#modalTambahPerkembangan').modal('hide');
                $('#formTambahPerkembangan')[0].reset(); // Reset the form
                showSnackbar('Data berhasil disimpan', 'success');
                // Reload the content
                $('#main-content').load('perkembangan-anak-content.php');
            } else {
                showSnackbar('Gagal menyimpan data: ' + res.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX error response:', xhr.responseText); // Log error response for debugging
            showSnackbar('Terjadi kesalahan dalam menyimpan data', 'error');
        }
    });
});

    // Set the hidden input value based on the selected dropdown option
    $('#id_anak').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var namaAnak = selectedOption.data('nama');
        $('#nama_anak').val(namaAnak);
    });

    // Function to show snackbar
    function showSnackbar(message, type) {
        var snackbar = document.getElementById("snackbar");
        snackbar.textContent = message;
        snackbar.className = snackbar.className.replace(/\bshow\b/g, "").replace(/\bsnackbar-\S+/g, "");
        snackbar.classList.add('show');
        snackbar.classList.add(`snackbar-${type}`);
        setTimeout(function() {
            snackbar.className = snackbar.className.replace("show", "");
        }, 3000);
    }

    // Function to confirm delete
    function confirmDelete(kode) {
        $('#confirmDeleteButton').attr('onclick', 'deleteData(' + kode + ')');
        $('#confirmDeleteModal').modal('show');
    }

    // Function to delete data
    function deleteData(kode) {
        $.ajax({
            type: 'POST',
            url: 'hapus-perkembangan.php',
            data: {
                kode: kode
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#confirmDeleteModal').modal('hide');
                    showSnackbar('Data berhasil dihapus', 'success');
                    $('#row-' + kode).remove();
                } else {
                    showSnackbar('Gagal menghapus data: ' + res.message, 'error');
                }
            },
            error: function() {
                showSnackbar('Terjadi kesalahan dalam menghapus data', 'error');
            }
        });
    }
    // Function to confirm delete
    function confirmDelete(kode) {
        $('#confirmDeleteButton').attr('onclick', 'deleteData(' + kode + ')');
        $('#confirmDeleteModal').modal('show');
    }

    // Function to delete data
    function deleteData(kode) {
        $.ajax({
            type: 'POST',
            url: 'hapus-perkembangan.php',
            data: {
                kode: kode
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#confirmDeleteModal').modal('hide');
                    showSnackbar('Data berhasil dihapus', 'success');
                    $('#row-' + kode).remove();
                } else {
                    showSnackbar('Gagal menghapus data: ' + res.message, 'error');
                }
            },
            error: function() {
                showSnackbar('Terjadi kesalahan dalam menghapus data', 'error');
            }
        });
    }
</script>