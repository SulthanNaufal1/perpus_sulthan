<?php
session_start();

if(isset($_SESSION["signIn"]) ) {
  header("Location: ../../petugas/index.php");
  exit;
}
require "../../loginSystem/connect.php";

if(isset($_POST["signIn"])) {
    $nama = strtolower($_POST["nama_admin"]);
    $password = $_POST["password"];
    
    $result = mysqli_query($connect, "SELECT * FROM admin WHERE nama_admin = '$nama' AND password = '$password'");
    
    if(mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION["signIn"] = $row['nama_admin']; // Simpan nama admin ke dalam session
    if($row['sebagai'] == 'petugas') {
        $_SESSION["admin"] = true;
        header("Location: ../../petugas/index.php");
        exit;
    }
} else {
    $error = true; // Menandakan bahwa terjadi kesalahan saat sign in
}

}

// Penanganan notifikasi logout
$logoutMessage = isset($_GET['logout']) && $_GET['logout'] == 2 ? "Anda berhasil logout" : "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../assets/bootsrap/bootstrap.min.css" crossorigin="anonymous">
    <script src="../../assets/bootsrap/de8de52639.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Sign In || Admin</title>
    <link rel="stylesheet" href="../../assets/signpetugas.css">
</head>

<body>
    <!-- ... (your existing code for navigation) ... -->

    <div class="container mt-5">
        <h1 class="container text-center mb-3 header-text" style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff; position: relative;">
            <img src="../../assets/logourl.png" alt="User Logo" style="width: 24px; height: auto; position: absolute; top: 50%; transform: translateY(-50%); left: 5px;">
            <span style="position: relative; top: 50%; transform: translateY(-50%); margin-left: 30px;">HALAMAN LOGIN PETUGAS</span>
        </h1>
        <?php if (!empty($logoutMessage)) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $logoutMessage ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
        <div class="card">
            <h1 class="pt-3 card-header text-center fw-bold">Sign In </h1>
            
            <form action="" method="post" class="row g-3 p-1 needs-validation text-light" novalidate>
            <?php if (isset($error) && $error) : ?>
        <div class="alert alert-danger" role="alert">
            Password atau nama pengguna salah.
        </div>
    <?php endif; ?>
                <label for="validationCustom01" class="form-label " style="font-family: 'Comic Sans MS', sans-serif; font-weight: lite; color: dark;">Nama Lengkap</label>
                <div class="input-group mt-0">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                    <input type="text" class="form-control" name="nama_admin" id="validationCustom01" required>
                    <div class="invalid-feedback">
                        Masukkan Nama anda!
                    </div>
                </div>
                <label for="validationCustom02" class="form-label" style="font-family: 'Comic Sans MS', sans-serif; font-weight: lite; color: dark;">Password</label>
                <div class="input-group mt-0">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" class="form-control" id="validationCustom02" name="password" required>
                    <div class="invalid-feedback">
                        Masukkan Password anda!
                    </div>
                </div>
                <div class="btn-container">
                  <button class="btn btn-primary" type="submit" name="signIn">Sign In</button>
                    <a class="btn btn-success" href="../index.php">Batal</a>
                    
                </div>
                <div class="bottom-line"></div>
            </form>
        </div>
    </div>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
