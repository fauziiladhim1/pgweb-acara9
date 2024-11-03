<?php
// Pastikan semua data POST tersedia dan diambil dari form input
$kecamatan = isset($_POST['kecamatan']) ? $_POST['kecamatan'] : ''; // Mengambil data 'kecamatan' dari form POST
$longitude = isset($_POST['longitude']) ? $_POST['longitude'] : ''; // Mengambil data 'longitude' dari form POST
$latitude = isset($_POST['latitude']) ? $_POST['latitude'] : ''; // Mengambil data 'latitude' dari form POST
$luas = isset($_POST['luas']) ? $_POST['luas'] : ''; // Mengambil data 'luas' dari form POST
$jumlah_penduduk = isset($_POST['jumlah_penduduk']) ? $_POST['jumlah_penduduk'] : ''; // Mengambil data 'jumlah_penduduk' dari form POST

// Cek apakah semua field sudah diisi
if (empty($kecamatan) || empty($longitude) || empty($latitude) || empty($luas) || empty($jumlah_penduduk)) {
    // Jika ada field yang kosong, tampilkan pesan kesalahan dan hentikan eksekusi
    die("<div class='error'>Semua field harus diisi! <a href='index.html'>Kembali ke Form</a></div>");
}

// Konfigurasi MySQL
$servername = "localhost"; // Nama server database (default: localhost)
$username = "root"; // Username untuk koneksi database
$password = ""; // Password untuk koneksi database (kosong jika default pada server lokal)
$dbname = "pgweb_8"; // Nama database yang akan diakses

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi ke database
if ($conn->connect_error) {
    // Jika koneksi gagal, tampilkan pesan error dan hentikan eksekusi
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk memasukkan data ke tabel 'penduduk'
$sql = "INSERT INTO penduduk (kecamatan, longitude, latitude, luas, jumlah_penduduk) 
        VALUES ('$kecamatan', $longitude, $latitude, $luas, $jumlah_penduduk)"; // Menggunakan nilai dari form input
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Mengatur karakter encoding halaman -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsivitas tampilan -->
    <title>Input Data Penduduk</title> <!-- Judul halaman -->
    <style>
        /* Tambahkan gaya CSS jika diperlukan */
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Mengeksekusi query dan mengecek apakah data berhasil ditambahkan
        if ($conn->query($sql) === TRUE) {
            // Jika eksekusi berhasil, tampilkan pesan konfirmasi
            echo "<h2>Data berhasil ditambahkan!</h2>";
        } else {
            // Jika terjadi kesalahan, tampilkan pesan error
            echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
        // Menutup koneksi database
        $conn->close();
        ?>
        <!-- Link untuk kembali ke halaman utama -->
        <a href="leaflet.php" class="button">Kembali ke WEB GIS Sleman</a>
    </div>
</body>
</html>
