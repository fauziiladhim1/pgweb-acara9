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
    // Jika koneksi gagal, kembalikan respons JSON dengan status error dan pesan kesalahan
    die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]));
}

// Ambil ID dari parameter POST request
$id = isset($_POST['id']) ? $_POST['id'] : ''; // Mengambil ID jika tersedia, kosong jika tidak

// Cek apakah ID tersedia
if ($id) {
    // Query untuk menghapus data dari tabel 'penduduk' berdasarkan ID
    $sql = "DELETE FROM penduduk WHERE id = $id";

    // Eksekusi query dan cek apakah berhasil
    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, kembalikan respons JSON dengan status sukses
        echo json_encode(["status" => "success", "message" => "Data berhasil dihapus!"]);
    } else {
        // Jika gagal, kembalikan respons JSON dengan status error dan pesan kesalahan
        echo json_encode(["status" => "error", "message" => "Gagal menghapus data: " . $conn->error]);
    }
} else {
    // Jika ID tidak ditemukan dalam request, kembalikan pesan error dalam format JSON
    echo json_encode(["status" => "error", "message" => "ID tidak ditemukan!"]);
}

// Menutup koneksi database
$conn->close();
?>