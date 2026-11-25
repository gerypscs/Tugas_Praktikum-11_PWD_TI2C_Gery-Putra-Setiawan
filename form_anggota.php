<?php
$errors = isset($_GET['errors']) ? $_GET['errors'] : [];
if (!is_array($errors)) {
    $errors = [$errors];
}

$sukses = isset($_GET['status']) && $_GET['status'] === 'sukses';
$gagal = isset($_GET['status']) && $_GET['status'] === 'gagal';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pendaftaran Anggota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        .container {
            width: 450px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 12px;
        }
        label {
            display: block;
            margin-bottom: 4px;
            font-weight: bold;
        }
        input[type="text"], select, textarea {
            width: 100%;
            padding: 7px;
            box-sizing: border-box;
        }
        button {
            padding: 8px 15px;
            background-color: #2b6cb0;
            color: white;
            border: none;
            cursor: pointer;
        }
        .sukses {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }
        .gagal {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="container">
    <h3>Pendaftaran Anggota Perpustakaan</h3>

    <?php if ($sukses): ?>
        <div class="sukses">
            Data anggota berhasil didaftarkan.
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="gagal">
            <strong>Pendaftaran gagal:</strong>
            <ul>
                <?php foreach ($errors as $err): ?>
                    <?php if (is_scalar($err)): ?>
                        <li><?= htmlspecialchars((string) $err, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($gagal): ?>
        <div class="gagal">
            Data gagal disimpan. Silakan coba lagi.
        </div>
    <?php endif; ?>

    <form action="proses_anggota.php" method="POST">
        <div class="form-group">
            <label for="no_anggota">Nomor Anggota</label>
            <input type="text" name="no_anggota" id="no_anggota" placeholder="Maksimal 15 digit angka">
        </div>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>

        <div class="form-group">
            <label for="no_hp">Nomor HP</label>
            <input type="text" name="no_hp" id="no_hp" placeholder="10 - 13 digit angka">
        </div>

        <div class="form-group">
            <label for="jenis_anggota">Jenis Anggota</label>
            <select name="jenis_anggota" id="jenis_anggota">
                <option value="">-- Pilih Jenis Anggota --</option>
                <option value="Mahasiswa">Mahasiswa</option>
                <option value="Dosen">Dosen</option>
                <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" rows="3"></textarea>
        </div>

        <button type="submit" name="submit">Daftar</button>
    </form>
</div>

</body>
</html>
