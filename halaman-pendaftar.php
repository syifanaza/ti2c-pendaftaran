<?php
include "koneksi.php";
session_start();

$register_message = " ";
$update_successful = false;

function generateRandomID() {
    return str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
}

if (isset($_POST["daftar"])) {
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $agama = $_POST["agama"];
    $sekolah_asal = $_POST["sekolah_asal"];

    $id = generateRandomID();

    try {
        $sql = "INSERT INTO calon_siswa (id, nama, alamat, jenis_kelamin, agama, sekolah_asal) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("isssss", $id, $nama, $alamat, $jenis_kelamin, $agama, $sekolah_asal);

        if ($stmt->execute()) {
            $_SESSION['register_message'] = "Pendaftaran Berhasil";
            $_SESSION['update_successful'] = true;
        } else {
            $_SESSION['register_message'] = "Pendaftaran Gagal, Coba Lagi !";
            $_SESSION['update_successful'] = false;
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['register_message'] = " " . $e->getMessage();
        $_SESSION['update_successful'] = false;
    }

    $db->close();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran</title>
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <style>
    body {
        background-image: url('background/bg-form.png');
        background-size: cover;
        background-position: center;
        height: 100vh;
        font-family: 'Times New Roman', Times, serif;
        margin: 0;
        padding: 0;
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

    .container1 {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 600px;
        transform: translate(-50%, -50%);
        background-color: rgba(255, 255, 255, 0.60);
        padding: 20px;
        margin: 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .alert-custom {
        width: 100%;
        margin: 0 auto 20px;
        font-size: 16px;
    }

    .btn-primary,
    .btn-secondary {
        background-color: #85586F;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        margin-top: 10px;
        margin-right: 10px;
        box-shadow: 0 4px 6px rgba(108, 92, 231, 0.2);
        transition: all 0.3s ease;
        font-family: 'Times New Roman', Times, serif;
        font-size: 15px;
    }

    .btn-primary:hover,
    .btn-secondary:hover {
        background-color: #8879B0;
        box-shadow: 0 6px 8px rgba(108, 92, 231, 0.4);
    }

    .form-control,
    .form-select {
        width: calc(100% - 10px);
        margin-bottom: 10px;
        border-radius: 5px;
        padding: 10px;
        font-size: 16px;
        font-family: 'Times New Roman', Times, serif;
    }

    input[type="text"],
    textarea {
        padding: 10px;
        border: 1px solid #ccc;
        transition: border-color 0.2s ease;
        font-size: 16px;
    }

    input[type="text"]:focus,
    textarea:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-check-input {
        margin-right: 10px;
    }

    label {
        font-weight: bold;
    }
    </style>

</head>

<body>
    <header class="header">
        <h1 class="header-title">Formulir Pendaftaran</h1>
    </header>

    <div class="container1">
        <form method="post" action="">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-12">
                        <div class="row mb-2">
                            <label for="nama" class="col-sm-3 col-form-label">Nama :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nama" id="nama" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat :</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="alamat" id="alamat" style="height: 100px" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="agama" class="col-sm-3 col-form-label">Agama :</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="agama" id="agama" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen Katolik">Kristen Katolik</option>
                                    <option value="Kristen Protestan">Kristen Protestan</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <fieldset class="row mb-2">
                            <legend class="col-form-label col-sm-3 pt-0">Jenis Kelamin :</legend>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_perempuan" value="Perempuan" required>
                                    <label class="form-check-label" for="jenis_kelamin_perempuan">Perempuan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_laki_laki" value="Laki-Laki" required>
                                    <label class="form-check-label" for="jenis_kelamin_laki_laki">Laki-Laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_lainnya" value="Lainnya" required>
                                    <label class="form-check-label" for="jenis_kelamin_lainnya">Lainnya</label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row mb-2">
                            <label for="sekolah_asal" class="col-sm-3 col-form-label">Sekolah Asal :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="sekolah_asal" id="sekolah_asal" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" name="daftar" class="btn btn-primary">Simpan</button>
                                <a href="index.php" class="btn btn-secondary ms-2">Kembali</a>
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
