<?php
// Konfigurasi MySQL
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "pgweb_8"; 

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi ke database
if ($conn->connect_error) {
    // Jika koneksi gagal, tampilkan pesan error dan hentikan eksekusi
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil semua data dari tabel 'penduduk'
$sql = "SELECT * FROM penduduk";
$result = $conn->query($sql);

// Array untuk menyimpan data hasil query
$markers = [];
if ($result->num_rows > 0) {
    // Jika ada data yang diambil, simpan setiap baris ke dalam array $markers
    while ($row = $result->fetch_assoc()) {
        $markers[] = $row; // Menambahkan data ke array
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> <!-- Mengatur karakter encoding halaman -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsivitas tampilan -->
    <title>WEB GIS Sleman</title> <!-- Judul halaman -->

    <!-- Link ke CSS Bootstrap untuk styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Link ke CSS Leaflet untuk peta -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">

    <!-- Gaya kustom halaman -->
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Font yang digunakan */
            background: linear-gradient(90deg, #B7D7C9, #b2dfdb); /* Latar belakang gradient */
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #00796b; /* Warna navbar */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); /* Bayangan navbar */
        }

        .navbar-brand,
        .nav-link {
            color: #fff !important; /* Warna teks navbar */
        }

        .nav-link:hover {
            color: #b2dfdb !important; /* Warna teks saat hover */
        }

        .container {
            margin-top: 20px; /* Jarak atas container */
        }

        .card {
            margin-bottom: 20px;
            border-radius: 12px; /* Radius sudut kartu */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan kartu */
        }

        .card-header {
            background-color: #00796b;
            color: #fff; /* Warna teks header kartu */
            text-align: center;
            font-weight: bold;
        }

        #map {
            height: 500px; /* Tinggi elemen peta */
            border-radius: 12px;
        }

        table {
            margin-top: 10px; /* Jarak atas tabel */
        }

        th,
        td {
            text-align: center; /* Teks di tengah */
            vertical-align: middle;
        }

        th {
            background-color: #00796b; /* Warna latar belakang header tabel */
            color: #fff;
        }

        .form-label {
            font-weight: 600; /* Ketebalan font label form */
        }

        .btn-primary {
            background-color: #00796b; /* Warna tombol utama */
            border: none; /* Menghapus border */
        }

        .btn-primary:hover {
            background-color: #004d40; /* Warna tombol saat hover */
        }

        .btn-edit {
            background-color: #ffc107; /* Warna tombol edit */
            border: none;
            color: #fff;
        }

        .btn-edit:hover {
            background-color: #e0a800; /* Warna tombol edit saat hover */
        }

        .btn-delete {
            background-color: #dc3545; /* Warna tombol hapus */
            border: none;
            color: #fff;
        }

        .btn-delete:hover {
            background-color: #c82333; /* Warna tombol hapus saat hover */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">WEB GIS Sleman</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#infoModal">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal untuk informasi pembuat -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="infoModalLabel">Info Pembuat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td>Fauzil</td>
                        </tr>
                        <tr>
                            <th>NIM</th>
                            <td>23/521853/SV/23514</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>PG WEB B</td>
                        </tr>
                        <tr>
                            <th>Github</th>
                            <td><a href="https://github.com/fauziiladhim1?tab=repositories" target="_blank"
                                    rel="noopener noreferrer">http;//github.com/fauziladhim1</a></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Container utama -->
    <div class="container">
        <!-- Kartu untuk peta -->
        <div class="card mb-4">
            <div class="card-header">Peta Sleman</div>
            <div id="map"></div> <!-- Elemen peta -->
        </div>

        <!-- Kartu untuk tabel data penduduk -->
        <div class="card mb-4">
            <div class="card-header">Data Penduduk</div>
            <div class="table-responsive">
                <?php if ($result->num_rows > 0): ?>
                    <!-- Tabel data penduduk -->
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Kecamatan</th>
                                <th>Longitude</th>
                                <th>Latitude</th>
                                <th>Luas (km²)</th>
                                <th>Jumlah Penduduk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($markers as $row): ?>
                                <tr>
                                    <!-- Menampilkan data dengan htmlspecialchars untuk menghindari XSS -->
                                    <td><?= htmlspecialchars($row['kecamatan']) ?></td>
                                    <td><?= htmlspecialchars($row['longitude']) ?></td>
                                    <td><?= htmlspecialchars($row['latitude']) ?></td>
                                    <td><?= htmlspecialchars($row['luas']) ?></td>
                                    <td><?= htmlspecialchars($row['jumlah_penduduk']) ?></td>
                                    <td>
                                        <!-- Tombol untuk mengedit dan menghapus data -->
                                        <button class="btn btn-edit btn-sm" onclick="editData(<?= $row['id'] ?>)">Edit</button>
                                        <button class="btn btn-delete btn-sm" onclick="deleteData(<?= $row['id'] ?>)">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <!-- Pesan jika tidak ada data -->
                    <p class="text-center">Tidak ada data yang ditemukan.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form input atau edit data -->
        <div class="card">
            <div class="card-header">Form Input / Edit Data Penduduk</div>
            <div class="card-body">
                <form action="input.php" method="post" onsubmit="return validateForm()">
                    <input type="hidden" id="id" name="id"> <!-- Input tersembunyi untuk ID -->
                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan:</label>
                        <input type="text" id="kecamatan" name="kecamatan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="longitude" class="form-label">Longitude:</label>
                        <input type="text" id="longitude" name="longitude" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="latitude" class="form-label">Latitude:</label>
                        <input type="text" id="latitude" name="latitude" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="luas" class="form-label">Luas (km²):</label>
                        <input type="text" id="luas" name="luas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_penduduk" class="form-label">Jumlah Penduduk:</label>
                        <input type="text" id="jumlah_penduduk" name="jumlah_penduduk" class="form-control" required>
                    </div>
                    <input type="submit" value="Submit" class="btn btn-primary w-100">
                </form>
            </div>
        </div>
    </div>

    <!-- Impor JavaScript untuk Bootstrap, Leaflet, dan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Inisialisasi peta Leaflet dengan koordinat awal Sleman
        var map = L.map('map').setView([-7.750, 110.360], 12);

        // Menambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Mengambil data marker dari PHP dan menambahkannya ke peta
        var markers = <?php echo json_encode($markers); ?>;
        markers.forEach(function(marker) {
            if (marker.latitude && marker.longitude) {
                // Menambahkan marker ke peta
                L.marker([marker.latitude, marker.longitude])
                    .addTo(map)
                    .bindPopup('<strong>Kecamatan:</strong> ' + marker.kecamatan + '<br>' +
                        '<strong>Jumlah Penduduk:</strong> ' + marker.jumlah_penduduk);
            }
        });

        // Fungsi untuk menghapus data dengan konfirmasi SweetAlert2
        function deleteData(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mengirim permintaan untuk menghapus data
                    fetch('delete.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'id=' + encodeURIComponent(id),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire('Berhasil!', data.message, 'success')
                                    .then(() => location.reload()); // Refresh halaman setelah penghapusan berhasil
                            } else {
                                Swal.fire('Gagal!', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Gagal!', 'Terjadi kesalahan: ' + error, 'error');
                        });
                }
            });
        }

        // Fungsi untuk mengedit data dan mengisi form dengan data yang diambil
        function editData(id) {
            fetch('edit.php?id=' + id)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Jaringan bermasalah atau server mengembalikan error.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status !== 'error') {
                        // Mengisi form dengan data yang diperoleh dari server
                        document.getElementById('id').value = data.id;
                        document.getElementById('kecamatan').value = data.kecamatan;
                        document.getElementById('longitude').value = data.longitude;
                        document.getElementById('latitude').value = data.latitude;
                        document.getElementById('luas').value = data.luas;
                        document.getElementById('jumlah_penduduk').value = data.jumlah_penduduk;
                        Swal.fire({
                            title: 'Edit Data',
                            text: 'Silakan perbarui data di formulir',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Scroll ke bawah halaman setelah konfirmasi
                            window.scrollTo(0, document.body.scrollHeight);
                        });
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat mengambil data: ' + error.message, 'error');
                });
        }
    </script>
</body>

</html>
