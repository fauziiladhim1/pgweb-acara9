<?php
// Konfigurasi koneksi ke database MySQL
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "pgweb_8"; 

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    // Jika koneksi gagal, kirim respons JSON dengan status error dan pesan kesalahan
    die(json_encode([
        "status" => "error",
        "message" => "Koneksi gagal: " . $conn->connect_error
    ]));
}

// Mengambil parameter 'id' dari permintaan GET
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Memeriksa apakah parameter 'id' tersedia
if ($id) {
    // Menyiapkan pernyataan SQL untuk mengambil data berdasarkan ID
    $sql = "SELECT * FROM penduduk WHERE id = $id";
    $result = $conn->query($sql);

    // Memeriksa apakah data ditemukan
    if ($result->num_rows > 0) {
        // Mengambil data sebagai array asosiatif
        $data = $result->fetch_assoc();
        // Mengirim data dalam format JSON
        echo json_encode($data);
    } else {
        // Jika data tidak ditemukan, kirim respons JSON dengan status error
        echo json_encode([
            "status" => "error",
            "message" => "Data tidak ditemukan!"
        ]);
    }
} else {
    // Jika parameter 'id' tidak tersedia, kirim respons JSON dengan status error
    echo json_encode([
        "status" => "error",
        "message" => "ID tidak ditemukan!"
    ]);
}

// Menutup koneksi database
$conn->close();
?>
