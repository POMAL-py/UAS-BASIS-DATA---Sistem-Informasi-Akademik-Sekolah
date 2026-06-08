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
