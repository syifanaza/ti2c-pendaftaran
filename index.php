<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Landing Page Sederhana</title>
<link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
<style>
      body {
        background-image: url(background/bg-index.png); 
        background-size: cover;
        background-position: center;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
        color: white;
        text-align: center;
        font-family: 'Times New Roman', serif;
      }

      .container {
        max-width: 700px;
      }

      .h2 {
        font-size: 40px;
        font-weight: bold;
        color: #fff;
      }

      .p {
        font-size: 1.2em;
        color: #fff;
        padding: 10px;
      }

      .btn {
        display: inline-block;
        font-size: 1em;
        padding: 10px 20px;
        margin-top: 20px;
        border: 2px solid #fff;
        border-radius: 5px;
        background-color: transparent;
        color: #fff;
        text-decoration: none;
        transition: all 0.3s ease;
      }

      .btn:hover {
        background-color: #fff;
        color: #32012F;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      }

      .top-right-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 10px 20px;
        border: 2px solid #fff;
        border-radius: 5px;
        background-color: transparent;
        color: #fff;
        text-decoration: none;
        transition: all 0.3s ease;
      }

      .top-right-btn:hover {
        background-color: #fff;
        color: #32012F;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      }

      .alert-custom {
        position: fixed;
        top: 10%;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        max-width: 600px;
        z-index: 1000;
        font-size: 1.2em;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.5s, visibility 0.5s;
      }

      .alert-custom.show {
        opacity: 1;
        visibility: visible;
      }

      .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
      }

      .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
      }

      .alert-custom .btn-close {
        position: absolute;
        top: 10px;
        right: 10px;
      }
</style>
</head>
<body>
  <?php if (isset($_SESSION['register_message'])): ?>
      <div id="alert-message" class="alert alert-dismissible alert-custom <?php echo $_SESSION['update_successful'] ? 'alert-success' : 'alert-danger'; ?>" role="alert">
          <?php echo $_SESSION['register_message']; ?>
          <button type="button" class="btn-close" aria-label="Close"></button>
      </div>
      <?php
      
      unset($_SESSION['register_message']);
      unset($_SESSION['update_successful']);
      ?>
  <?php endif; ?>

  <a href="tampilkan-pendaftar.php" class="top-right-btn">Tampilkan Pendaftar</a>
  
  <div class="container">
    <div class="h2">Selamat datang di Portal Pendaftaran Siswa Baru</div>
    <div class="p">Kami dengan senang hati mengundang Anda untuk menjadi bagian dari komunitas sekolah kami. Mulailah perjalanan akademis Anda bersama kami.</div>
    <a href="halaman-pendaftar.php" class="btn">Daftar</a>
  </div>
  
  <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      const alertMessage = document.getElementById('alert-message');
      if (alertMessage) {
        setTimeout(() => {
          alertMessage.classList.add('show');
        }, 100);

        setTimeout(() => {
          alertMessage.classList.remove('show');
        }, 2000);
        
        const btnClose = alertMessage.querySelector('.btn-close');
        btnClose.addEventListener('click', () => {
          alertMessage.classList.remove('show');
        });
      }
    });
  </script>
</body>
</html>
