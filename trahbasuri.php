<?php
$host = "sf77o.h.filess.io"; // Ganti dengan host database Anda
$username = "SilsilahTrahBasuri_bottomfact"; // Ganti dengan username database Anda
$password = "yafie2005"; // Ganti dengan password database Anda
$database = "SilsilahTrahBasuri_bottomfact"; // Ganti dengan nama database Anda

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Keluarga Trah Basuri</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 25px;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            color: #555;
            margin-top: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        @media (max-width: 600px) {
            input[type="text"],
            input[type="number"],
            input[type="submit"] {
                width: 100%;
            }
        }
    </style>
<center>
<body>
    <h1>Data Keluarga Trah Basuri</h1>

    <h2>Input Data Keluarga</h2>
    <form method="post" action="">
        Nama: <input type="text" name="nama" required><br><br>
        Tahun Lahir: <input type="number" name="tahun_lahir" required><br><br>
        Alamat: <input type="text" name="alamat" required><br><br>
        Posisi: <input type="text" name="posisi" required><br><br>
        <input type="submit" value="Simpan">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari form
        $nama = $_POST['nama'];
        $tahun_lahir = $_POST['tahun_lahir'];
        $alamat = $_POST['alamat'];
        $posisi = $_POST['posisi'];

        // Gunakan prepared statement untuk menghindari SQL injection
        $stmt = $koneksi->prepare("INSERT INTO keluarga (nama, tahunlahir, alamat, posisi) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $tahun_lahir, $alamat, $posisi);

        if ($stmt->execute()) {
            header("Location: trahbasuri.php"); // Redirect kembali ke halaman utama
            exit(); // Pastikan untuk menghentikan eksekusi script setelah redirect
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>

    <h2>Data Keluarga</h2>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Tahun Lahir</th>
            <th>Alamat</th>
            <th>Posisi</th>
        </tr>
        <?php
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
    </table>
</body>
</center>
</html>
