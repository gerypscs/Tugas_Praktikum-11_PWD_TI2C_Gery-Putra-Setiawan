<?php
// Memanggil file koneksi sesuai ketentuan tugas
require_once 'koneksi.php';

// Query SELECT untuk mengambil semua data dari tabel anggota
$query = "SELECT id, no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat FROM anggota ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        .btn-tambah {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .btn-tambah:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .kosong {
            text-align: center;
            color: #777;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Daftar Anggota Perpustakaan Kampus</h2>
    
    <!-- Tombol menuju form_anggota.php untuk melakukan INSERT data baru -->
    <a href="form_anggota.php" class="btn-tambah">+ Tambah Anggota Baru</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Anggota</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Jenis Anggota</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['no_anggota']); ?></td>
                        <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['no_hp']); ?></td>
                        <td><?= htmlspecialchars($row['jenis_anggota']); ?></td>
                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="kosong">Belum ada data anggota yang terdaftar.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Menutup koneksi database
mysqli_close($conn);
?>