<?php
error_reporting(0);

require_once 'koneksi.php';

$no = 0;
// 
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'kasir', 'owner'])) {
    header('Location: login.php');
    exit();
}
// 
$laporan = array();

$result = mysqli_query($conn, "SELECT nama FROM tb_member");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $laporan[] = $row;
    }
    mysqli_free_result($result);
} else {
    die("Gagal mengambil data transaksi: " . mysqli_error($conn));
}

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// 
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM tb_laporan WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
// 
$query = "SELECT * FROM tb_paket";
$result = $conn->query($query);

// Tutup koneksi
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Generate | Alif Laundry</title>
    <link rel="stylesheet" href="assets/style.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" />

</head>

<body>
    <div class="container">
        <h1>Daftar Transaksi | Generate Laporan</h1><br>

        <div class="btn-aksi">
            <a href="entri_transaksi.php">Kembali ke entri transaksi</a>
            <a href="dashboard.php">Kembali ke Dashboard</a>
        </div>

        <section class="attendance">
            <div class="attendance-list">

                <table class="1 table" id="laporan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Pesanan</th>
                            <th>Tanggal Bayar</th>
                            <th>Jumlah Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($laporan as $lp) : ?>
                            <tr style="text-transform:capitalize;">
                                <td><?php echo ++$no ?></td>
                                <td><?php echo $lp['nama']?></td>
                                <td><?php echo $lp['nama_paket']?></td>
                                <td><?php echo $lp['id_outlet']?></td>
                                <td><?php echo $lp['nama']?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </section>
        <br><br><br>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#laporan').DataTable();
        });
    </script>

</body>

</html>