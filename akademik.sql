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