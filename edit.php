<?php
include "koneksi.php";
session_start();

$update_message = "";
$update_successful = false;
$error_occurred = false;

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM calon_siswa WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            echo "Data tidak ditemukan";
        }
    } else {
        echo "Gagal menjalankan perintah";
    }
} else {
    echo "ID tidak valid";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["daftar"])) {
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $agama = $_POST["agama"];
    $sekolah_asal = $_POST["sekolah_asal"];

    try {
        $sql = "UPDATE calon_siswa SET nama=?, alamat=?, jenis_kelamin=?, agama=?, sekolah_asal=? WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssssi", $nama, $alamat, $jenis_kelamin, $agama, $sekolah_asal, $id);

        if ($stmt->execute()) {
            $update_message = "Data Berhasil Diperbarui";
            $update_successful = true;
        } else {
            $update_message = "Data Gagal Diperbarui, Coba Lagi !";
            $error_occurred = true;
        }
    } catch (mysqli_sql_exception $e) {
        $update_message = " " . $e->getMessage();
        $error_occurred = true;
    }

    $db->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Barang</title>
    <style>
        body {
            background-image: url(background/bg-form.png); 
            background-size: cover;
            background-position: center;
            height: 100vh;
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #7C3E66;
            color: #ffffff;
            padding: 20px; /* Adjust padding as needed */
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px; /* Adjust font size as needed */
            height: 20px; /* Set height if you want to enforce a specific height */
            display: flex;
            align-items: center; /* Vertically centers content within the header */
            justify-content: center;
        }

        .header-title {
            color: #fff; /* White text color */
            text-align: center;
            margin: 0
        }

        .container1 {
            position: absolute; 
            top: 55%;
            left: 50%;
            width: 600px;
            transform: translate(-50%, -50%);      
            background-color: rgba(255, 255, 255, 0.35);
            padding: 20px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;    
        }

        .alert-custom {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-info {
            color: #fff;
            background-color: #41B06E;
            border-color: #bce8f1;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-custom .btn-success,
        .alert-custom .btn-danger {
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            margin-left: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .alert-custom .btn-success:hover,
        .alert-custom .btn-danger:hover {
            opacity: 0.9;
        }
        .btn-primary,
        .btn-secondary {
            background-color: #85586F; 
            color: #fff; 
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            margin-top: 10px;
            box-shadow: 0 4px 6px rgba(108, 92, 231, 0.2); 
            transition: all 0.3s ease;
        }
        .btn-primary:hover,
        .btn-secondary:hover {
            background-color: #8879B0; 
            box-shadow: 0 6px 8px rgba(108, 92, 231, 0.4); 
        }
        .success {
           font-weight: bold;
            margin-bottom: 10px;
            line-height: 11px;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            line-height: 11px;
        }
        .form-control {
            width: calc(100% - 20px); /* subtract padding */
            margin-bottom: 10px; /* Increased margin for spacing */
            border-radius: 10px;
        }

                .form-select {
                    width: calc(100% - 20px); /* subtract padding */
                    margin-bottom: 10px; /* Increased margin for spacing */
                    border-radius: 10px;
                    padding: 10px;
                    font-size: 16px;
                    font-family: 'Times New Roman', Times, serif;
                }

                /* Optional: Adjust input and textarea appearance */
                input[type="text"], textarea {
                    padding: 10px;
                    border: 1px solid #ccc;
                    transition: border-color 0.2s ease;
                    font-family: 'Times New Roman', Times, serif;
                    font-size: 16px;
                }

           input[type="text"]:focus, textarea:focus {
                    border-color: #007bff;
                    outline: none;
                    font-family: 'Times New Roman', Times, serif;
                    font-size: 16px;
                }

    </style>
</head>
<body>
    
    <header class="header">
        <h1 class="header-title">Ubah Data</h1>
    </header>

    <div class="container1">
        <?php if (!empty($_POST) && isset($_POST["daftar"])) : ?>
            <div class="alert alert-info alert-dismissible fade show alert-custom <?php echo $update_successful ? 'success' : ($error_occurred ? 'error' : ''); ?>" role="alert">
                <?php echo $update_message; ?>
                <?php if ($update_successful) : ?>
                    <a href="tampilkan-pendaftar.php" class="btn btn-sm btn-success float-end btnM">Lihat Pendaftar</a>
                <?php endif; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
            <form method="POST" action="edit.php?id=<?= $id ?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="row mb-2">
                        <label for="nama" class="col-sm-3 col-form-label">Nama :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat :</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="alamat" id="alamat" style="height: 100px" required><?= htmlspecialchars($data['alamat']) ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                    <label for="agama" class="col-sm-3 col-form-label">Agama :</label>
                    <div class="col-sm-9">
                        <select class="form-select" name="agama" id="agama" required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam" <?= ($data['agama'] == 'Islam') ? 'selected' : '' ?>>Islam</option>
                            <option value="Kristen Katolik" <?= ($data['agama'] == 'Kristen Katolik') ? 'selected' : '' ?>>Kristen Katolik</option>
                            <option value="Kristen Protestan" <?= ($data['agama'] == 'Kristen Protestan') ? 'selected' : '' ?>>Kristen Protestan</option>
                            <option value="Budha" <?= ($data['agama'] == 'Budha') ? 'selected' : '' ?>>Budha</option>
                            <option value="Hindu" <?= ($data['agama'] == 'Hindu') ? 'selected' : '' ?>>Hindu</option>
                            <option value="Lainnya" <?= ($data['agama'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                </div>
                <fieldset class="row mb-2">
    <legend class="col-form-label col-sm-3 pt-0">Jenis Kelamin :</legend>
    <div class="col-sm-9">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_perempuan" value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'checked' : '' ?> required>
            <label class="form-check-label" for="jenis_kelamin_perempuan">Perempuan</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_laki_laki" value="Laki-Laki" <?= ($data['jenis_kelamin'] == 'Laki-Laki') ? 'checked' : '' ?> required>
            <label class="form-check-label" for="jenis_kelamin_laki_laki">Laki-Laki</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_lainnya" value="Lainnya" <?= ($data['jenis_kelamin'] == 'Lainnya') ? 'checked' : '' ?> required>
            <label class="form-check-label" for="jenis_kelamin_lainnya">Lainnya</label>
        </div>
    </div>
</fieldset>
<div class="row mb-2">
    <label for="sekolah_asal" class="col-sm-3 col-form-label">Sekolah Asal :</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="sekolah_asal" id="sekolah_asal" value="<?= htmlspecialchars($data['sekolah_asal']) ?>" required>
    </div>
</div>

                    <div class="row mb-3">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" name="daftar" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
        </div>
        
        <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>    
    </body>
</html>