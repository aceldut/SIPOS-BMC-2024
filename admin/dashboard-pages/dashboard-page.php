<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posyandu Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../style/style-admin.css">
    <style>
        #snackbar {
            visibility: hidden;
            min-width: 250px;
            text-align: center;
            border-radius: 8px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            right: 30px;
            bottom: 30px;
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

        .snackbar-success {
            background-color: #4CAF50;
            color: white;
        }

        .snackbar-error {
            background-color: #f44336;
            color: white;
        }

        .snackbar-info {
            background-color: #2196F3;
            color: white;
        }

        .custom-card-info {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: left;
            font-size: medium;
        }
    </style>
</head>
<body>
    <div id="snackbar"></div>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <div class="text-left mb-4">
                        <img src="../../assets/logo.png" alt="Logo" class="img-fluid">
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard-page.php">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../jadwal-page.html">
                                <i class="fas fa-calendar-alt"></i>
                                Jadwal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../petugas-page.html">
                                <i class="fas fa-user"></i>
                                Petugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../artikel-page.php">
                                <i class="fas fa-newspaper"></i>
                                Artikel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.html">
                                <i class="fas fa-sign-out-alt"></i>
                                Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4" id="main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                <div class="card card-custom">
                    <div class="card-body text-left">
                        <h5 class="card-title">Halo Admin</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-custom card-link" data-url="perkembangan-anak-content.php">
                            <div class="card-body text-center">
                                <h5 class="card-title">Perkembangan Anak</h5>
                                <p class="card-text" id="perkembangan-anak-count">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-custom card-link" data-url="imunisasi-content.html">
                            <div class="card-body text-center">
                                <h5 class="card-title">Imunisasi</h5>
                                <p class="card-text" id="imunisasi-count">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-custom card-link" data-url="data-orangtua-content.php">
                            <div class="card-body text-center">
                                <h5 class="card-title">Data Orangtua</h5>
                                <p class="card-text" id="data-ortu-count">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-custom card-link" data-url="data-anak-content.html">
                            <div class="card-body text-center">
                                <h5 class="card-title">Data Anak</h5>
                                <p class="card-text" id="data-anak-count">0</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-1 card-form-custom">
                    <div class="card-header">
                        Form Pendaftaran Baru
                    </div>
                    <div class="card-body">
                        <div class="custom-card-info">
                            Form Pendaftaran baru digunakan untuk menginput data orang tua yang belum sama sekali didaftarkan pada website
                        </div>
                        <form action="../regis-ibu.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nik">Nik*</label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Nik" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="namaIbu">Nama Ibu*</label>
                                    <input type="text" class="form-control" id="namaIbu" name="namaIbu" placeholder="Nama Ibu" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="noTelp">No Telp Ibu*</label>
                                    <input type="text" class="form-control" id="noTelp" name="noTelp" placeholder="No Telp Ibu" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="alamat">Alamat*</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="namaAnak">Nama Anak*</label>
                                    <input type="text" class="form-control" id="namaAnak" name="namaAnak" placeholder="Nama Anak" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jenisKelamin">Jenis Kelamin*</label>
                                    <select id="jenisKelamin" name="jenisKelamin" class="form-control" required>
                                        <option selected>Pilih...</option>
                                        <option>Laki-laki</option>
                                        <option>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="tempatLahir">Tempat Lahir*</label>
                                    <input type="text" class="form-control" id="tempatLahir" name="tempatLahir" placeholder="Tempat Lahir" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tanggalLahir">Tanggal Lahir*</label>
                                    <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                <footer class="pt-4 my-md-5 pt-md-5 border-top">
                    <div class="d-flex justify-content-between">
                        <small class="d-block mb-3 text-muted">2024 © SIPOS</small>
                        <small class="d-block mb-3 text-muted">Crafted By BMC</small>
                    </div>
                </footer>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();

        $(document).ready(function() {
            $('.card-link').on('click', function() {
                var url = $(this).data('url');
                $('#main-content').load(url, function(response, status, xhr) {
                    if (status == "error") {
                        var msg = "Sorry but there was an error: ";
                        $("#main-content").html(msg + xhr.status + " " + xhr.statusText);
                    } else {
                        attachSearchListener();
                    }
                });
            });

            attachSearchListener();
            updateParentDataCount(); // Memanggil fungsi untuk mengupdate jumlah data orang tua saat halaman dimuat
            fetchCounts(); // Memanggil fungsi untuk mengupdate jumlah data pada kartu

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('message')) {
                const message = urlParams.get('message');
                const type = urlParams.get('type') || 'info';
                showSnackbar(message, type);
            }
        });

        function attachSearchListener() {
            var searchInput = document.getElementById('search-input');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        var search = this.value;
                        fetchResults(search);
                    }
                });
            }
        }

        function fetchResults(search) {
            $.ajax({
                url: 'jumlah-data-ortu.php',
                type: 'GET',
                data: { search: search, ajax: 1 },
                dataType: 'json',
                success: function(data) {
                    updateTable(data);
                    if (data.length === 0) {
                        showSnackbar('Tidak ada data yang ditemukan', 'info');
                    } else {
                        showSnackbar('Pencarian berhasil', 'success');
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
                    tr.innerHTML = `
                        <td>
                            <button class='btn btn-sm btn-danger' onclick="deleteIbu(${row.id_ibu})">Hapus</button>
                            <button class='btn btn-sm btn-warning'>Edit</button>
                            <button class='btn btn-sm btn-success'>+ Anak</button>
                        </td>
                        <td>${row.NIK}</td>
                        <td>${row.nama_ibu}</td>
                        <td>${row.no_telp}</td>
                        <td>${row.alamat}</td>
                        <td>${row.nama_anak}</td>
                    `;
                    tableBody.appendChild(tr);
                });
            } else {
                tableBody.innerHTML = "<tr><td colspan='6' class='text-center'>Tidak ada data</td></tr>";
            }
        }

        function deleteIbu(id_ibu) {
            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: 'delete-ibu.php',
                    type: 'POST',
                    data: { id_ibu: id_ibu },
                    success: function(response) {
                        if (response === "success") {
                            showSnackbar('Data berhasil dihapus', 'success');
                            fetchResults(document.getElementById('search-input').value);
                            updateParentDataCount(); // Memanggil fungsi untuk mengupdate jumlah data orang tua setelah penghapusan
                        } else {
                            showSnackbar('Gagal menghapus data', 'error');
                        }
                    },
                    error: function() {
                        showSnackbar('Terjadi kesalahan dalam menghapus data', 'error');
                    }
                });
            }
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

        function updateParentDataCount() {
            $.ajax({
                url: 'jumlah-data-ortu.php',
                type: 'GET',
                data: { count: 1 },
                dataType: 'json',
                success: function(data) {
                    document.getElementById('data-ortu-count').textContent = data.count;
                },
                error: function() {
                    console.error('Gagal mendapatkan jumlah data orang tua');
                }
            });
        }

        function fetchCounts() {
            $.ajax({
                url: 'fetch_counts.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    document.getElementById('perkembangan-anak-count').textContent = data.perkembangan_anak;
                    document.getElementById('imunisasi-count').textContent = data.imunisasi;
                    document.getElementById('data-anak-count').textContent = data.data_anak;
                },
                error: function() {
                    console.error('Gagal mendapatkan jumlah data');
                }
            });
        }
    </script>
</body>
</html>
