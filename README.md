# LAPORAN UAS BASIS DATA
## PERANCANGAN DATABASE DAN APLIKASI CURD
### SISTEM INFORMASI AKADEMIK SEKOLAH

---

### A. Pemilihan Topik
Topik yang dipilih untuk pengerjaan tugas UAS Basis Data ini adalah **C. Sistem Informasi Akademik di Sekolah**. Sistem ini dirancang untuk menangani kebutuhan operasional akademik sekolah mulai dari pengelolaan data induk kesiswaan, inventarisasi tenaga pendidik (guru), manajemen kurikulum mata pelajaran, hingga proses rekapitulasi penilaian akhir ujian siswa beserta penentuan otomatis status kelulusan berdasarkan kriteria KKM.

---

### B. Proses Bisnis dan Penentuan Modul Sistem
Alur operasional akademik pada sistem ini didefinisikan ke dalam empat modul utama berikut:
1. **Modul Siswa (Kesiswaan):** Siswa baru didaftarkan ke dalam sistem dengan mencantumkan data pribadi (NIS, nama lengkap, tanggal lahir, dan alamat). Data ini disimpan ke dalam database untuk keperluan pelacakan rekam akademis selama masa sekolah.
2. **Modul Guru (Tenaga Pendidik):** Menginventarisasi data seluruh guru yang aktif mengajar di sekolah (ID Guru, nama lengkap, dan nomor telepon) untuk kemudian dipetakan sebagai penilai atau pengampu mata pelajaran tertentu.
3. **Modul Mata Pelajaran (Kurikulum):** Mengelola master data mata pelajaran yang tersedia di sekolah, meliputi ID mata pelajaran, nama pelajaran, serta ambang batas Nilai Kriteria Ketuntasan Minimal (KKM).
4. **Modul Penilaian (Akademik):** Guru memproses penginputan nilai asli yang diperoleh siswa. Sistem secara dinamis akan mencatat nilai tersebut, menampilkan guru yang memberikan nilai, serta menyajikan status kelulusan siswa secara otomatis.

---

### C. Aktor yang Terlibat dalam Tiap Modul
Pengguna sistem terbagi menjadi dua aktor utama:
1. **Siswa (Peserta Didik):** Aktor eksternal yang memberikan data pribadi untuk didaftarkan, mengikuti proses evaluasi pelajaran, serta menerima laporan rekapitulasi nilai akhir.
2. **Admin / Guru / Operator Sekolah:** Aktor internal yang memiliki hak akses untuk mengelola data master kesiswaan, memperbarui master mata pelajaran, memasukkan parameter KKM, menginput nilai asli siswa, serta menerbitkan laporan evaluasi belajar.

---

### D. Desain Entity Relationship Diagram (ERD)
Berikut adalah visualisasi rancangan database ERD relasional yang merepresentasikan struktur tabel fisik pada sistem akademik sekolah menggunakan sintaks Mermaid 

```mermaid
erDiagram
    GURU ||--o{ MAPEL : "mengampu"
    SISWA ||--o{ PENILAIAN : "menerima"
    MAPEL ||--o{ PENILAIAN : "diujikan dalam"

    SISWA {
        int id_siswa PK "Auto Increment"
        varchar nis "Nomor Induk Siswa (Unik)"
        varchar nama_siswa "Nama Lengkap Siswa"
        date tanggal_lahir "Tanggal Lahir"
    }
    GURU {
        int id_guru PK "Auto Increment"
        varchar kode_guru "Kode Guru (Unik)"
        varchar nama_guru "Nama Lengkap Guru"
        varchar no_telp "Nomor Telepon"
    }
    MAPEL {
        int id_mapel PK "Auto Increment"
        varchar kode_mapel "Kode Mapel (Unik)"
        varchar nama_pelajaran "Nama Mata Pelajaran"
        int kkm "Nilai Batas Minimum"
        int id_guru FK "Relasi ke GURU"
    }
    PENILAIAN {
        int id_penilaian PK "Auto Increment"
        int id_siswa FK "Relasi ke SISWA"
        int id_mapel FK "Relasi ke MAPEL"
        float nilai_asli "Skor Nilai Siswa"
    }
```
Deskripsi Entitas dan Atribut:
- Siswa (Master): Menyimpan data diri peserta didik. PK: id_siswa. Atribut: nis (unik), nama siswa, dan tanggal lahir.

- Guru (Master): Menyimpan data diri tenaga pendidik. PK: id_guru. Atribut: kode guru (unik), nama_guru, dan no telp.

- Mata Pelajaran (Master): Menyimpan daftar kurikulum pelajaran. PK: id_mapel. FK: id_guru. Atribut: kode_mapel (unik), nama_pelajaran, dan kkm.

- Penilaian (Transaksi Utama): Mencatat lembar evaluasi belajar. PK: id_penilaian. FK: id_siswa dan id_mapel. Atribut: nilai_asli.

---

### E. Penentuan Kardinalitas Relasi
- Relasi Data Internal ($1:M$): Satu kode id_mapel yang sama dapat muncul berkali-kali di dalam tabel penilaian karena diambil oleh banyak siswa yang berbeda.
- Relasi Penilai ($1:M$): Satu orang guru (dinilai_oleh) dapat melakukan penginputan nilai berkali-kali untuk banyak siswa dan mata pelajaran yang berbeda.

---

### F. Proses Normalisasi Database
Proses normalisasi dilakukan secara bertahap untuk menghilangkan redundansi data serta mencegah terjadinya anomali data (insert, update, delete anomaly).

a) Bentuk Tidak Ternormalisasi (UNF) & 1NF (First Normal Form)
Memastikan seluruh kolom bernilai atomik tunggal tanpa adanya repeating groups:

| Nama Kolom | Jenis Kunci | Keterangan |
|------------|-------------|------------|
| **id_penelitian** | Primary Key (PK) | ID unik rekam nilai |
| **nis** | - | Nomor Induk Siswa |
| **nama siswa** |	- | Nama lengkap siswa |
| **kode_mapel** |	- |	Kode unik mata pelajaran |
| **nama_pelajaran** | - |	Nama mata pelajaran |
| **kkm** |	- |	Standar kelulusan minimum |
| **nilai asli** |	- |	Nilai mentah hasil ujian siswa |
| **kode_guru**| - | Kode identitas guru |
| **nama guru** | - | Nama lengkap guru penilai |

b) Bentuk Normal Kedua (2NF)
Memecah tabel induk agar seluruh atribut non-key bergantung penuh secara fungsional (fully functionally dependent) pada Primary Key tabel masing-masing:

- Tabel Master Siswa: id_siswa (PK), nis, nama siswa, tanggal lahir.

- Tabel Master Guru: id_guru (PK), kode_guru, nama_guru, no_telp.

- Tabel Master Mapel: id_mapel (PK), id_guru (FK), kode_mapel, nama_pelajaran, kkm.

- Tabel Transaksi Penilaian: id_penilaian (PK), id_siswa (FK), id_mapel (FK), nilai_asli.

c) Bentuk Normal Ketiga (3NF)
Seluruh tabel hasil pecahan 2NF di atas telah memenuhi kriteria Bentuk Normal Ketiga (3NF) karena tidak lagi memiliki ketergantungan transitif (transitive dependency) di mana atribut non-key bergantung pada atribut non-key lainnya.

---

### G. Implementasi Desain ke DBMS MySQL/MariaDB
Script DDL (Data Definition Language) SQL untuk menyusun struktur database secara aman di MySQL:

```sql
CREATE DATABASE uas_akademik_sekolah;
USE uas_akademik_sekolah;

-- Membuat Tabel Guru
CREATE TABLE guru (
    id_guru INT AUTO_INCREMENT PRIMARY KEY,
    kode_guru VARCHAR(10) NOT NULL UNIQUE,
    nama_guru VARCHAR(100) NOT NULL,
    no_telp VARCHAR(15) NOT NULL
);

-- Membuat Tabel Siswa
CREATE TABLE siswa (
    id_siswa INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) NOT NULL UNIQUE,
    nama_siswa VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL
);

-- Membuat Tabel Mata Pelajaran
CREATE TABLE mapel (
    id_mapel INT AUTO_INCREMENT PRIMARY KEY,
    kode_mapel VARCHAR(10) NOT NULL UNIQUE,
    nama_pelajaran VARCHAR(100) NOT NULL,
    kkm INT NOT NULL,
    id_guru INT,
    FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE SET NULL
);

-- Membuat Tabel Transaksi Penilaian
CREATE TABLE penilaian (
    id_penilaian INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT NOT NULL,
    id_mapel INT NOT NULL,
    nilai_asli FLOAT NOT NULL,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_mapel) REFERENCES mapel(id_mapel) ON DELETE CASCADE
);
```

---

### H. Manipulasi Data Menggunakan SQL
Berikut perintah DML (Data Manipulation Language) SQL untuk menguji fungsionalitas manipulasi data:

```sql
-- 1. Perintah INSERT (Menambahkan Data Nilai)
INSERT INTO penilaian_siswa (id_mapel, nama_pelajaran, siswa, kkm, nilai_asli, dinilai_oleh) 
VALUES ('M01', 'Matematika Dasar', 'Hilbram', 75, 85.5, 'Budi Santoso, S.Pd');

-- 2. Perintah UPDATE (Mengubah Nilai Asli Siswa)
UPDATE penilaian_siswa 
SET nilai_asli = 90.0 
WHERE id_mapel = 'M01' AND siswa = 'Hilbram';

-- 3. Perintah DELETE (Menghapus Rekam Data)
DELETE FROM penilaian_siswa 
WHERE id_mapel = 'M01' AND siswa = 'Hilbram';
```

---

### I.Kode Program Python
Program CLI Python interaktif yang diimplementasikan menggunakan library mysql.connector:

```py
import mysql.connector

def get_koneksi():
    return mysql.connector.connect(host="localhost", user="root", password="", database="akademik_sekolah")

def tambah_guru():
    db = get_koneksi(); cursor = db.cursor()
    id_guru = input("ID Guru: ")
    nama = input("Nama Guru: ")
    telp = input("No. Telp: ")
    cursor.execute("INSERT INTO guru (id_guru, nama_guru, no_telp) VALUES (%s, %s, %s)", (id_guru, nama, telp))
    db.commit(); db.close()
    print("-> Data berhasil ditambahkan!")

def lihat_guru():
    db = get_koneksi(); cursor = db.cursor()
    cursor.execute("SELECT * FROM guru")
    print("\n  ID':<10)   'Nama Guru: <25] | [No. Telepon  ")
    print("-" * 55)
    for row in cursor.fetchall():
        print(f"{row[0]:<10} | {row[1]:<25} | {row[2]}")
    db.close()

def ubah_guru():
    db = get_get_koneksi(); cursor = db.cursor()
    id_guru = input("Masukkan ID Guru yang akan diubah: ")
    nama = input("Nama Baru: ")
    telp = input("No Telp Baru: ")
    cursor.execute("UPDATE guru SET nama_guru=%s, no_telp=%s WHERE id_guru=%s", (nama, telp, id_guru))
    db.commit(); db.close()
    print("-> Data berhasil diubah!")

def hapus_guru():
    db = get_koneksi(); cursor = db.cursor()
    id_guru = input("Masukkan ID Guru yang dihapus: ")
    cursor.execute("DELETE FROM guru WHERE id_guru=%s", (id_guru,))
    db.commit(); db.close()
    print("-> Data berhasil dihapus ")

while True:
    print("\n--- KELOLA DATA GURU ---")
    print("1. Tambah 2. Lihat 3. Ubah | 4. Hapus 5. Keluar")
    pilih = input("Pilih menu: ")
    if pilih == '1': tambah_guru()
    elif pilih == '2': lihat_guru()
    elif pilih == '3': ubah_guru()
    elif pilih == '4': hapus_guru()
    elif pilih == '5': break
```

---

### J. Kode Program PHP
Aplikasi web terpadu (index.php) yang digunakan untuk kelola data dan rekapitulasi penilaian secara dinamis:

```php
<?php
$conn = new mysqli("localhost", "root", "", "akademik_sekolah");
if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }

if(isset($_POST['tambah'])) {
    $id_mapel = $_POST['id_mapel'];
    $nama_pelajaran = $_POST['nama_pelajaran'];
    $siswa = $_POST['siswa'];
    $kkm = $_POST['kkm'];
    $nilai_asli = $_POST['nilai_asli'];
    $dinilai_oleh = $_POST['dinilai_oleh'];
    
    $conn->query("INSERT INTO penilaian_siswa (id_mapel, nama_pelajaran, siswa, kkm, nilai_asli, dinilai_oleh) 
                  VALUES ('$id_mapel', '$nama_pelajaran', '$siswa', '$kkm', '$nilai_asli', '$dinilai_oleh')");
    header("Location: " . $_SERVER['PHP_SELF']);
}

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
        h2 { text-align: center; color: #333; }
        .form-group { display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; }
        .form-group input { flex: 1; min-width: 140px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-tambah { background-color: #28a745; color: white; border: none; padding: 10px 15px; width: 100%; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-hapus { background-color: #dc3545; color: white; text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 14px; }
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
```
