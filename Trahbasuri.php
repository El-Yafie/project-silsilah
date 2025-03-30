<?php
$host = "sf77o.h.filess.io";
$username = "SilsilahTrahBasuri_bottomfact";
$password = "yafie2005";
$database = "SilsilahTrahBasuri_bottomfact";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $tahun_lahir = $_POST['tahun_lahir'];
    $alamat = $_POST['alamat'];
    $posisi = $_POST['posisi'];

    $stmt = $koneksi->prepare("INSERT INTO keluarga (nama, tahunlahir, alamat, posisi) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $tahun_lahir, $alamat, $posisi);

    if ($stmt->execute()) {
        header("Location: trahbasuri.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$sql = "SELECT * FROM keluarga";
$result = mysqli_query($koneksi, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tahunlahir']) . "</td>";
        echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
        echo "<td>" . htmlspecialchars($row['posisi']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Tidak ada data keluarga.</td></tr>";
}

mysqli_close($koneksi);
?>
