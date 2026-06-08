<?php
$conn = new mysqli("localhost", "root", "", "akademik_sekolah",3307);
if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }

// Proses Tambah Data
if(isset($_POST['tambah'])) {
    $id_mapel = $_POST['id_mapel'];
    $nama_pelajaran = $_POST['nama_pelajaran'];
    $siswa = $_POST['siswa'];
    $kkm = $_POST['kkm'];
    $nilai_asli = $_POST['nilai_asli'];
    $dinilai_oleh = $_POST['dinilai_oleh'];
    
    $sql = "INSERT INTO penilaian_siswa (id_mapel, nama_pelajaran, siswa, kkm, nilai_asli, dinilai_oleh) 
            VALUES ('$id_mapel', '$nama_pelajaran', '$siswa', '$kkm', '$nilai_asli', '$dinilai_oleh')";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']);
}

// Proses Hapus Data
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM penilaian_siswa WHERE id='$id'");
    header("Location: " . $_SERVER['PHP_SELF']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Penilaian Akademik Vokasi</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #0056b3; }
        .form-group { display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; }
        .form-group input { flex: 1; min-width: 140px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-tambah { background-color: #28a745; color: white; border: none; padding: 10px 15px; width: 100%; border-radius: 4px; cursor: pointer; font-weight: bold;}
        .btn-hapus { background-color: #dc3545; color: white; text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 14px;}
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px 8px; text-align: center; }
        th { background-color: #343a40; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>
<div class="container">
    <h2>Data Penilaian Akademik</h2>
    <form method="POST" action="">
        <div class="form-group">
            <input type="text" name="id_mapel" placeholder="Id Mapel" required>
            <input type="text" name="nama_pelajaran" placeholder="Nama Pelajaran" required>
            <input type="text" name="siswa" placeholder="Nama Siswa" required>
        </div>
        <div class="form-group">
            <input type="number" name="kkm" placeholder="Nilai KKM" required>
            <input type="number" name="nilai_asli" placeholder="Nilai Asli" required step="0.1">
            <input type="text" name="dinilai_oleh" placeholder="Dinilai Oleh" required>
        </div>
        <button type="submit" name="tambah" class="btn-tambah">Simpan Data</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Id Mapel</th><th>Nama Pelajaran</th><th>Siswa</th><th>kkm</th><th>Nilai Asli</th><th>Dinilai Oleh</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT * FROM penilaian_siswa ORDER BY id DESC");
            while($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_mapel']}</td>
                        <td>{$row['nama_pelajaran']}</td>
                        <td>{$row['siswa']}</td>
                        <td>{$row['kkm']}</td>
                        <td><strong>{$row['nilai_asli']}</strong></td>
                        <td>{$row['dinilai_oleh']}</td>
                        <td><a href='?hapus={$row['id']}' class='btn-hapus' onclick='return confirm(\"Hapus data?\")'>Hapus</a></td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>