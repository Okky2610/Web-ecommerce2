<?php
session_start();
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "ecommerce");

// Cek koneksi ke database
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Ecommerce</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'menu.php'; ?>
<!-- Konten -->
<section class="konten">
    <div class="container">
        <h1>Produk Terbaru</h1>

        <div class="row">
            <?php 
            // Mengambil data produk dari database
            $ambil = $koneksi->query("SELECT * FROM produk"); 
            while($perproduk = $ambil->fetch_assoc()){ 
            ?>

            <div class="col-md-3">
                <div class="thumbnail parent_foto_produk">
                    <img id="foto_produk" src="foto_produk/<?php echo $perproduk['foto_produk'];?>" alt="">
                    <div class="caption">
                        <h3><?php echo $perproduk['nama_produk'];?></h3>
                        <h5>Rp. <?php echo number_format($perproduk['harga_produk']);?></h5>
                        <a href="beli.php?id=<?php echo $perproduk['id_produk'];?>" class="btn btn-primary">Beli</a>
                        <a href="detail.php?id=<?php echo $perproduk['id_produk'];?>" class="btn btn-default">Detail</a>
                    </div>
                </div>
            </div>

            <?php } ?>
        </div>
        
    </div>
</section>

</body>
</html>
