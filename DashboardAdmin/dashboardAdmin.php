<?php
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../sign/admin/sign_in.php");
  exit;
}

// Isi halaman dashboard admin di sini
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/bootsrap/bootstrap.min.css">
<script src="../assets/bootsrap/de8de52639.js"></script>
<script src="../assets/bootsrap/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
    <h5 class="container text-left" style="font-family: 'Comic Sans MS', sans-serif; font-weight: bold; color: dark;">
      sastra mesin<img src="../assets/header.png" alt="Logo" style="width: 40px; height: 40px; border-radius: 50%; margin-left: 10px;">
    </h5>

    <!-- Move dropdown button inside the navbar -->
    <div class="navbar-nav dropdown">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-light rounded-circle" onclick="showDropdownMenu()">
        <img src="../assets/memberLogo.png" alt="memberLogo" width="30px">
      </button>
    </div>

    <!-- Modal -->
    <div id="dropdownMenu" class="modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: 1px solid black;">
          <div class="modal-header" style="border-bottom: 1px solid black; border-radius: 10px; margin-top: -10px;">
            <button type="button" class="btn-close " onclick="hideDropdownMenu()" aria-label="Close"></button>
            <div class="container text-center text-dark" style="font-family: 'times new roman', sans-serif; font-size: 1.5rem;margin-top: 20px;">Menu Pilihan</div>
          </div>
          <div class="modal-body">
            <!-- Dropdown menu items -->
            <a href="member/member.php" class="btn btn-primary w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Member</a>
            <a href="buku/tambahBuku.php" class="btn btn-info w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Tambah Buku</a>
            <a href="petugas.php" class="btn btn-warning w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Admin</a>
            <a class="btn btn-danger w-100 text-light rounded-3" href="signOut.php" style="font-family: 'Comic Sans MS', sans-serif;">Kembali</a>
          </div>
        </div>
      </div>
    </div>
</div>
</nav>

<br>
    <?php
    require "../config/config.php";
    // query read semua buku
    $buku = queryReadData("SELECT * FROM buku ORDER BY id_buku DESC");
    //search buku
    if (isset($_POST["search"])) {
        $buku = search($_POST["keyword"]);
    }
    //read buku informatika
    if (isset($_POST["informatika"])) {
        $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'informatika'");
    }
    //read buku bisnis
    if (isset($_POST["bisnis"])) {
        $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'bisnis'");
    }
    //read buku filsafat
    if (isset($_POST["filsafat"])) {
        $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'filsafat'");
    }
    //read buku novel
    if (isset($_POST["novel"])) {
        $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'novel'");
    }
    //read buku sains
    if (isset($_POST["sains"])) {
        $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'sains'");
    }
    ?>
    <!-- Btn filter data kategori buku -->
    <section id="homeSection" class="p-5">
        <h1 class="container text-center mb-3 header-text"
            style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff;">DAFTAR
            BUKU PERPUSTAKAAN</h1>

        <!-- Form and Buttons -->
        <!-- Tombol Kategori -->
        <form action="" method="post">
            <div class="container kategori-buttons text-dark"
                style="font-family: 'Comic Sans MS', sans-serif; font-weight: bold; color: dark;">
                <button class="btn btn-light text-dark border-dark" type="submit">Semua</button>
                <button type="submit" name="informatika" class="border-dark btn btn-light">Informatika</button>
                <button type="submit" name="bisnis" class="btn btn-light border-dark">Bisnis</button>
                <button type="submit" name="filsafat" class="btn btn-light border-dark">Filsafat</button>
                <button type="submit" name="novel" class="btn btn-light border-dark">Novel</button>
                <button type="submit" name="sains" class="btn btn-light border-dark">Sains</button>
            </div>
        </form>

        <!-- Card buku -->
        <div class="container custom-container">
  <form action="" method="post">
    <?php
    $bukuCount = count($buku); // Inisialisasi delay
    ?>
    <div class="layout-card-custom" style="overflow-x: hidden; white-space: nowrap;">
      <?php foreach ($buku as $item) : ?>
        <div class="card border-dark d-flex" style="width: 14rem; margin-right: 1.5rem;">
  <a href="sign/link_login.html">
    <img src="../imgDB/<?= $item["cover"]; ?>" class="card-img-top" alt="coverBuku" style="object-fit: cover; height: 200px;">
  </a>
  <div class="card-body d-flex flex-column justify-content-between align-items-center" style="height: 100%;">
    <h6 class="card-title text-dark" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;"><?= $item["judul"]; ?></h6>
    <ul align="center" style="font-family: 'Comic Sans MS', sans-serif; color: dark;" class="list-group list-group-flush">
      <li class="list-group-item text-dark">Kategori : <?= $item["kategori"]; ?></li>
    </ul>
    <div class="d-flex justify-content-between w-100">
    <a class="btn btn-success" href="buku/updateBuku.php?idReview=<?= $item["id_buku"]; ?>" id="review">Edit</a>
      <a class="btn btn-danger" href="buku/deleteBuku.php?id=<?= $item["id_buku"]; ?>" onclick="return confirm('Yakin ingin menghapus data buku ? ');">Delete</a>
    </div>
  </div>
</div>  <?php endforeach; ?>
                </div>
            </form>
        </div>
        <footer id="footer" class="p-1 bg-dark">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center mt-2">
                    <p class="text-light">Albert Einstein Pernah Kesini</p>
                </div>
            </div>
        </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
  document.addEventListener('DOMContentLoaded', function () {
    let cardContainer = document.querySelector('.layout-card-custom');

    cardContainer.addEventListener('mouseenter', function () {
      cardContainer.classList.add('scrolling-animation');
    });

    cardContainer.addEventListener('mouseleave', function () {
      cardContainer.classList.remove('scrolling-animation');
    });
  });
</script>
<script>
  function showDropdownMenu() {
    document.getElementById('dropdownMenu').style.display = 'block';
  }

  function hideDropdownMenu() {
    document.getElementById('dropdownMenu').style.display = 'none';
  }
</script>  </body>
</html>