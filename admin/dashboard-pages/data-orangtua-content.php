<?php
include '../../config.php';

// Dapatkan nilai pencarian dari input form
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data dari tabel 'tbl_ibu' dan 'tbl_anak' berdasarkan 'id_ibu' dan filter pencarian nama ibu
$sql = "SELECT tbl_ibu.id_ibu, tbl_ibu.NIK, tbl_ibu.nama_ibu, tbl_ibu.no_telp, tbl_ibu.alamat, GROUP_CONCAT(tbl_anak.nama_anak SEPARATOR ', ') AS nama_anak 
        FROM tbl_ibu 
        LEFT JOIN tbl_anak ON tbl_ibu.id_ibu = tbl_anak.id_ibu
        WHERE tbl_ibu.nama_ibu LIKE '%$search%'
        GROUP BY tbl_ibu.id_ibu";
$result = $conn->query($sql);

// Siapkan hasil pencarian dalam format JSON untuk AJAX
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

// Mengembalikan data JSON jika permintaan datang dari AJAX
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

// Tambahkan pada bagian paling atas dari file ini
if (isset($_GET['count'])) {
    $sql_count = "SELECT COUNT(*) AS count FROM tbl_ibu";
    $result_count = $conn->query($sql_count);
    $count = $result_count->fetch_assoc()['count'];
    echo json_encode(['count' => $count]);
    exit();
}

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-4 mb-3 border-bottom">
    <h1 class="h2">Data Orang Tua</h1>
    <nav aria-label="breadcrumb" class="breadcrumb-custom">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="dashboard-page.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Data Orang Tua</li>
        </ol>
    </nav>
</div>
<div class="d-flex justify-content-between mb-3">
    <a href="../../export_excel.php" class="btn btn-primary">Cetak</a>
    <form id="search-form" method="GET" action="" class="search-form">
        <input type="text" id="search-input" name="search" class="form-control search-input" placeholder="Search by Nama Ibu..." value="<?php echo htmlspecialchars($search); ?>" />
    </form>
</div>
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">Opsi</th>
                <th scope="col">NIK</th>
                <th scope="col">Nama Ibu</th>
                <th scope="col">No Telp</th>
                <th scope="col">Alamat</th>
                <th scope="col">Anak</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <?php if (count($data) > 0): ?>
                <?php foreach ($data as $row): ?>
                    <tr id="row-<?php echo $row['id_ibu']; ?>">
                        <td>
                            <button class='btn btn-sm btn-danger' onclick="confirmDelete(<?php echo $row['id_ibu']; ?>)">Hapus</button>
                            <button class='btn btn-sm btn-warning' onclick="editData(<?php echo $row['id_ibu']; ?>, '<?php echo $row['NIK']; ?>', '<?php echo $row['nama_ibu']; ?>', '<?php echo $row['no_telp']; ?>', '<?php echo $row['alamat']; ?>')">Edit</button>
                            <button class='btn btn-sm btn-success' onclick="addChild(<?php echo $row['id_ibu']; ?>)">+ Anak</button>
                        </td>
                        <td><?php echo htmlspecialchars($row['NIK']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_ibu']); ?></td>
                        <td><?php echo htmlspecialchars($row['no_telp']); ?></td>
                        <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                        <td id="child-<?php echo $row['id_ibu']; ?>"><?php echo htmlspecialchars($row['nama_anak']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan='6' class='text-center'>Tidak ada data</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="d-flex justify-content-between">
        <small class="d-block mb-3 text-muted">2024 © SIPOS</small>
        <small class="d-block mb-3 text-muted">Crafted By BMC</small>
    </div>
</footer>

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

<!-- Modal Edit Data -->
<div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDataModalLabel">Edit Data Orang Tua</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm">
            <input type="hidden" id="edit-id-ibu">
            <div class="form-group">
                <label for="edit-nik">NIK</label>
                <input type="text" class="form-control" id="edit-nik" required>
            </div>
            <div class="form-group">
                <label for="edit-nama-ibu">Nama Ibu</label>
                <input type="text" class="form-control" id="edit-nama-ibu" required>
            </div>
            <div class="form-group">
                <label for="edit-no-telp">No Telp</label>
                <input type="text" class="form-control" id="edit-no-telp" required>
            </div>
            <div class="form-group">
                <label for="edit-alamat">Alamat</label>
                <input type="text" class="form-control" id="edit-alamat" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="saveEditButton">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Anak -->
<div class="modal fade" id="addChildModal" tabindex="-1" role="dialog" aria-labelledby="addChildModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addChildModalLabel">Tambah Data Anak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addChildForm">
            <input type="hidden" id="add-child-id-ibu">
            <div class="form-group">
                <label for="add-child-nama">Nama Anak</label>
                <input type="text" class="form-control" id="add-child-nama" required>
            </div>
            <div class="form-group">
                <label for="add-child-tempat-lahir">Tempat Lahir</label>
                <input type="text" class="form-control" id="add-child-tempat-lahir" required>
            </div>
            <div class="form-group">
                <label for="add-child-tanggal-lahir">Tanggal Lahir</label>
                <input type="date" class="form-control" id="add-child-tanggal-lahir" required>
            </div>
            <div class="form-group">
                <label for="add-child-jenis-kelamin">Jenis Kelamin</label>
                <select class="form-control" id="add-child-jenis-kelamin" required>
                    <option value="">Pilih...</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="saveChildButton">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script>
let deleteIdIbu;

function confirmDelete(id_ibu) {
    deleteIdIbu = id_ibu;
    $('#confirmDeleteModal').modal('show');
}

document.getElementById('confirmDeleteButton').addEventListener('click', function() {
    deleteIbu(deleteIdIbu);
    $('#confirmDeleteModal').modal('hide');
});

function deleteIbu(id_ibu) {
    $.ajax({
        url: 'delete-ibu.php',
        type: 'POST',
        data: { id_ibu: id_ibu },
        success: function(response) {
            console.log("Respon dari server:", response);  // Tambahkan log ini
            if (response === "success") {
                showSnackbar('Data berhasil dihapus', 'success');
                document.getElementById('row-' + id_ibu).remove();
            } else {
                showSnackbar('Gagal menghapus data', 'error');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);  // Tambahkan log ini
            showSnackbar('Terjadi kesalahan dalam menghapus data', 'error');
        }
    });
}

function showSnackbar(message, type) {
    var snackbar = document.getElementById("snackbar");
    snackbar.textContent = message;

    snackbar.className = snackbar.className.replace(/\bshow\b/g, "");
    snackbar.className = snackbar.className.replace(/\bsnackbar-\S+/g, "");

    snackbar.classList.add('show');
    snackbar.classList.add(`snackbar-${type}`);

    setTimeout(function() {
        snackbar.className = snackbar.className.replace("show", "");
    }, 3000);
}

$(document).ready(function() {
    $('#search-input').on('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            var search = this.value;
            fetchResults(search);
        }
    });

    function fetchResults(search) {
        $.ajax({
            url: 'data-orangtua-content.php',
            type: 'GET',
            data: { search: search, ajax: 1 },
            dataType: 'json',
            success: function(data) {
                updateTable(data);
                if (data.length === 0) {
                    showSnackbar('Tidak ada data yang ditemukan', 'info');
                }
            },
            error: function() {
                showSnackbar('Terjadi kesalahan dalam pencarian', 'error');
            }
        });
    }

    function updateTable(data) {
        var tableBody = document.getElementById('table-body');
        tableBody.innerHTML = '';
        if (data.length > 0) {
            data.forEach(function(row) {
                var tr = document.createElement('tr');
                tr.setAttribute('id', 'row-' + row.id_ibu);
                tr.innerHTML = `
                    <td>
                        <button class='btn btn-sm btn-danger' onclick="confirmDelete(${row.id_ibu})">Hapus</button>
                        <button class='btn btn-sm btn-warning' onclick="editData(${row.id_ibu}, '${row.NIK}', '${row.nama_ibu}', '${row.no_telp}', '${row.alamat}')">Edit</button>
                        <button class='btn btn-sm btn-success' onclick="addChild(${row.id_ibu})">+ Anak</button>
                    </td>
                    <td>${row.NIK}</td>
                    <td>${row.nama_ibu}</td>
                    <td>${row.no_telp}</td>
                    <td>${row.alamat}</td>
                    <td id="child-${row.id_ibu}">${row.nama_anak}</td>
                `;
                tableBody.appendChild(tr);
            });
        } else {
            tableBody.innerHTML = "<tr><td colspan='6' class='text-center'>Tidak ada data</td></tr>";
        }
    }
});

function editData(id_ibu, nik, nama_ibu, no_telp, alamat) {
    $('#edit-id-ibu').val(id_ibu);
    $('#edit-nik').val(nik);
    $('#edit-nama-ibu').val(nama_ibu);
    $('#edit-no-telp').val(no_telp);
    $('#edit-alamat').val(alamat);
    $('#editDataModal').modal('show');
}

document.getElementById('saveEditButton').addEventListener('click', function() {
    var id_ibu = $('#edit-id-ibu').val();
    var nik = $('#edit-nik').val();
    var nama_ibu = $('#edit-nama-ibu').val();
    var no_telp = $('#edit-no-telp').val();
    var alamat = $('#edit-alamat').val();

    $.ajax({
        url: 'edit-ibu.php',
        type: 'POST',
        data: { id_ibu: id_ibu, NIK: nik, nama_ibu: nama_ibu, no_telp: no_telp, alamat: alamat },
        success: function(response) {
            if (response === "success") {
                showSnackbar('Data berhasil diperbarui', 'success');
                $('#editDataModal').modal('hide');
                $('#row-' + id_ibu + ' td:nth-child(2)').text(nik);
                $('#row-' + id_ibu + ' td:nth-child(3)').text(nama_ibu);
                $('#row-' + id_ibu + ' td:nth-child(4)').text(no_telp);
                $('#row-' + id_ibu + ' td:nth-child(5)').text(alamat);
            } else if (response === "nik_exists") {
                showSnackbar('NIK sudah digunakan', 'error');
            } else {
                showSnackbar('Gagal memperbarui data', 'error');
            }
        },
        error: function() {
            showSnackbar('Terjadi kesalahan dalam memperbarui data', 'error');
        }
    });
});

function addChild(id_ibu) {
    $('#add-child-id-ibu').val(id_ibu);
    $('#addChildModal').modal('show');
}

document.getElementById('saveChildButton').addEventListener('click', function() {
    var id_ibu = $('#add-child-id-ibu').val();
    var nama_anak = $('#add-child-nama').val();
    var tempat_lahir = $('#add-child-tempat-lahir').val();
    var tanggal_lahir = $('#add-child-tanggal-lahir').val();
    var jenis_kelamin = $('#add-child-jenis-kelamin').val();

    $.ajax({
        url: 'add-child.php',
        type: 'POST',
        data: { id_ibu: id_ibu, nama_anak: nama_anak, tempat_lahir: tempat_lahir, tanggal_lahir: tanggal_lahir, jenis_kelamin: jenis_kelamin },
        success: function(response) {
            if (response === "success") {
                showSnackbar('Data anak berhasil ditambahkan', 'success');
                $('#addChildModal').modal('hide');
                updateChildList(id_ibu, nama_anak);
            } else {
                showSnackbar('Gagal menambahkan data anak', 'error');
            }
        },
        error: function() {
            showSnackbar('Terjadi kesalahan dalam menambahkan data anak', 'error');
        }
    });
});

function updateChildList(id_ibu, nama_anak) {
    var childCell = document.getElementById('child-' + id_ibu);
    var existingNames = childCell.innerHTML.split(', ');
    existingNames.push(nama_anak);
    childCell.innerHTML = existingNames.join(', ');
}
</script>

<style>
    #snackbar {
        visibility: hidden;
        max-width: 300px;  /* Tambahkan ini untuk mengatur lebar maksimal */
        margin-left: 350px;
        text-align: center;
        border-radius: 8px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        right: 20px;  /* Ubah dari left ke right */
        bottom: 30px; /* Ubah dari left ke right */
        font-size: 17px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: visibility 0s, bottom 0.5s, opacity 0.5s ease-in-out;
        opacity: 0;
    }

    #snackbar.show {
        visibility: visible;
        bottom: 50px;
        opacity: 1;
    }

    #snackbar.snackbar-success {
        background-color: #4CAF50; /* Hijau untuk sukses */
        color: #fff;
    }

    #snackbar.snackbar-error {
        background-color: #f44336; /* Merah untuk error */
        color: #fff;
    }

    #snackbar.snackbar-info {
        background-color: #2196F3; /* Biru untuk informasi */
        color: #fff;
    }

    .search-form {
        flex-grow: 1;
        display: flex;
        justify-content: flex-end;
    }

    .search-input {
        width: 300px;
    }

</style>
