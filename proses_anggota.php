<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    // Ambil data dan bersihkan spasi di awal/akhir
    $no_anggota    = isset($_POST['no_anggota']) ? trim($_POST['no_anggota']) : '';
    $nama_lengkap  = isset($_POST['nama_lengkap']) ? trim($_POST['nama_lengkap']) : '';
    $email         = isset($_POST['email']) ? trim($_POST['email']) : '';
    $no_hp         = isset($_POST['no_hp']) ? trim($_POST['no_hp']) : '';
    $jenis_anggota = isset($_POST['jenis_anggota']) ? trim($_POST['jenis_anggota']) : '';
    $alamat        = isset($_POST['alamat']) ? trim($_POST['alamat']) : '';

    // Validasi Nomor Anggota
    if (empty($no_anggota)) {
        $errors[] = "Nomor anggota wajib diisi.";
    } elseif (!ctype_digit($no_anggota)) {
        $errors[] = "Nomor anggota hanya boleh berisi angka.";
    } elseif (strlen($no_anggota) > 15) {
        $errors[] = "Nomor anggota maksimal 15 digit.";
    }

    // Validasi Nama Lengkap
    if (empty($nama_lengkap)) {
        $errors[] = "Nama lengkap wajib diisi.";
    } elseif (strlen($nama_lengkap) > 100) {
        $errors[] = "Nama lengkap maksimal 100 karakter.";
    }

    // Validasi Email
    if (empty($email)) {
        $errors[] = "Email wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    } elseif (strlen($email) > 100) {
        $errors[] = "Email maksimal 100 karakter.";
    }

    // Validasi Nomor HP
    if (empty($no_hp)) {
        $errors[] = "Nomor HP wajib diisi.";
    } elseif (!ctype_digit($no_hp)) {
        $errors[] = "Nomor HP hanya boleh berisi angka.";
    } elseif (strlen($no_hp) < 10 || strlen($no_hp) > 13) {
        $errors[] = "Nomor HP harus 10 sampai 13 digit.";
    }

    // Validasi Jenis Anggota
    $pilihan_sah = ['Mahasiswa', 'Dosen', 'Tenaga Kependidikan'];
    if (empty($jenis_anggota)) {
        $errors[] = "Jenis anggota wajib dipilih.";
    } elseif (!in_array($jenis_anggota, $pilihan_sah)) {
        $errors[] = "Pilihan jenis anggota tidak valid.";
    }

    // Validasi Alamat
    if (empty($alamat)) {
        $errors[] = "Alamat wajib diisi.";
    }

    // Cek apakah ada error validasi
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: form_anggota.php");
        exit;
    }

    // Simpan data ke database menggunakan prepared statement
    $sql = "INSERT INTO anggota (no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $no_anggota, $nama_lengkap, $email, $no_hp, $jenis_anggota, $alamat);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['sukses'] = "Data anggota berhasil didaftarkan.";
        } else {
            $_SESSION['errors'] = ["Gagal menyimpan data: " . mysqli_stmt_error($stmt)];
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['errors'] = ["Terjadi kesalahan pada query database: " . mysqli_error($conn)];
    }

    mysqli_close($conn);
    header("Location: form_anggota.php");
    exit;
} else {
    header("Location: form_anggota.php");
    exit;
}
?>