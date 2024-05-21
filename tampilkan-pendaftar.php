<?php
include "koneksi.php";

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $sql_delete = "DELETE FROM calon_siswa WHERE id = ?";
    $stmt = $db->prepare($sql_delete);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $delete_message = "Data berhasil dihapus.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $delete_message = "Gagal menghapus data.";
    }
}

$sql = "SELECT * FROM calon_siswa";
$result = $db->query($sql);

if ($result === false) {
   
    echo "Error: " . $db->error;
} else {
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/pen.css' rel='stylesheet'>
    <style>
        body {
            background-image: url('background/bg-form.png'); 
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.45);
            padding: 20px;
            margin: 20px auto 20px auto; 
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            width: 100%;
            height: auto; 
            position: relative;
            overflow-y: auto; 
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        header {
            background-color: #85586F;
            color: #ffffff;
            padding: 20px; 
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px; 
            height: 20px; 
            display: flex;
            align-items: center; 
            justify-content: center; 
        }

        .center {
            text-align: center;
        }

        .table {
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-collapse: separate;
            border-spacing: 0 6px; 
        }

        .table th, .table td {
            padding: 12px 15px;
            text-align: center;
            vertical-align: middle; 
            font-size: 17px; 
            font-family: 'Times New Roman', Times, serif;
        }

        .table th {
            background-color: #85586F;  
            color: white;
        }

        .table tbody tr {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .table tbody tr:hover {
            transform: translateY(-5px);
        }

        .table td:first-child, .table th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .table td:last-child, .table th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px; 
            float: left;
            padding: 15px;
        }
        .btn-primary,
        .btn-secondary {
            background-color: #85586F;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            margin-top: 10px;
            margin-right: 10px;
            box-shadow: 0 4px 6px rgba(108, 92, 231, 0.2);
            transition: all 0.3s ease;
            display: inline-block;
            font-family:'Times New Roman', Times, serif;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            background-color: #8879B0;
            box-shadow: 0 6px 8px rgba(108, 92, 231, 0.4);
        }


        .btn-custom {
            padding: 8px 12px;
            font-size: 16px;
            border-radius: 5px;
            margin-right: 5px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            display: inline-flex; 
            align-items: center; 
            float: left; 
        }

        .btn-danger {
            background-color: #e74c3c;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            box-shadow: 0 4px 6px rgba(231, 76, 60, 0.2);
        }

        .btn-warning {
            background-color: #f39c12;
            color: #fff;
        }

        .btn-warning:hover {
            background-color: #e67e22;
            box-shadow: 0 4px 6px rgba(243, 156, 18, 0.2);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px; 
        }
    </style>
</head>
<body>
<header>
    <h1>Data Pendaftar</h1>
</header>

<div class="container">
    <div class="center">

        <?php if (isset($delete_message)): ?>
            <div class="alert alert-info">
                <?= $delete_message ?>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Agama</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Asal Sekolah</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
            $counter = 1; 
            ?>
                <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <th scope="row"><?= $counter ?></th> 
        <td><?= htmlspecialchars($row["nama"]) ?></td>
        <td><?= htmlspecialchars($row["alamat"]) ?></td>
        <td><?= htmlspecialchars($row["agama"]) ?></td>
        <td><?= htmlspecialchars($row["jenis_kelamin"]) ?></td>
        <td><?= htmlspecialchars($row["sekolah_asal"]) ?></td>
        <td>
            <a class="btn btn-custom btn-danger" href="?delete=<?= htmlspecialchars($row["id"]) ?>">Hapus Data</a>
            <a class="btn btn-custom btn-warning" href="edit.php?id=<?= htmlspecialchars($row["id"]) ?>"><i class="gg-pen"></i> Edit</a>
        </td>
    </tr>
    <?php 
    $counter++; 
    ?>
<?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">
                Tidak ada data yang ditemukan.
            </div>
        <?php endif; ?>
        <div class="center action-buttons">
    <a href="halaman-pendaftar.php" class="btn btn-primary">Daftar</a>
    <br>
    <a class="btn btn-secondary" href="index.php">Kembali ke Beranda</a>
</div>

</div>

<?php $db->close(); ?>

<script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
}
?>
