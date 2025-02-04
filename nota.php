<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "ecommerce");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembelian</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'menu.php'; ?>

<section class="kontent">
    <div class="container">

    <h2>Detail Pembelian</h2>

    <?php
    // Periksa apakah id ada dalam URL
    if (isset($_GET['id'])) {
        $id_pembelian = $_GET['id'];

        // Query untuk mengambil detail pembelian
        $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan=pelanggan.id_pelanggan WHERE pembelian.id_pembelian='$id_pembelian'");

        // Cek apakah data ditemukan
        if ($ambil->num_rows > 0) {
            $detail = $ambil->fetch_assoc();
        } else {
            echo "<p>Pembelian tidak ditemukan!</p>";
            exit;
        }
    } else {
        echo "<p>Id Pembelian tidak valid!</p>";
        exit;
    }
    ?>

    <strong><?php echo $detail['nama_pelanggan']; ?></strong> <br>
    <p>
        <?php echo $detail['telepon_pelanggan']; ?> <br>
        <?php echo $detail['email_pelanggan']; ?> 
    </p>

    <p>
        Tanggal : <?php echo $detail['tanggal_pembelian']; ?> <br>
        Total : Rp. <?php echo number_format($detail['total_pembelian'], 0, ',', '.'); ?> 
    </p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = 1;
            // Query untuk mengambil produk yang dibeli
            $ambil = $koneksi->query("SELECT * FROM pembelian_produk JOIN produk ON pembelian_produk.id_produk = produk.id_produk WHERE pembelian_produk.id_pembelian='$id_pembelian'");
            
            // Cek apakah ada produk yang dibeli
            if ($ambil->num_rows > 0) {
                while ($pecah = $ambil->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo $pecah['nama_produk']; ?></td>
                <td>Rp. <?php echo number_format($pecah['harga_produk'], 0, ',', '.'); ?></td>
                <td><?php echo $pecah['jumlah']; ?></td>
                <td>Rp. <?php echo number_format($pecah['harga_produk'] * $pecah['jumlah'], 0, ',', '.'); ?></td>
            </tr>
            <?php 
                $nomor++; 
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada produk yang ditemukan.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-7">
            <div class="alert alert-info">
                <p>
                    Silakan melakukan pembayaran sebesar Rp. <?php echo number_format($detail['total_pembelian'], 0, ',', '.'); ?> ke <br>
                    <strong>BANK BNI 057837823 AN. Yasril Imam</strong>
                </p>
            </div>
        </div>
    </div>
</section>

</body>
</html>
