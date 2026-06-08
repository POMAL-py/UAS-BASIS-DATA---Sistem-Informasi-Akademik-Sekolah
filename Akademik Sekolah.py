import mysql.connector

def get_koneksi():
    return mysql.connector.connect(
        host="localhost", user="root", password="", database="akademik_sekolah"
    )

def tambah_data():
    db = get_koneksi(); cursor = db.cursor()
    print("\n--- TAMBAH DATA PENILAIAN ---")
    id_mapel = input("Id Mapel        : ")
    nama_pelajaran = input("Nama Pelajaran  : ")
    siswa = input("Nama Siswa      : ")
    kkm = input("Nilai KKM       : ")
    nilai_asli = input("Nilai Asli      : ")
    dinilai_oleh = input("Dinilai Oleh    : ")
    
    sql = """INSERT INTO penilaian_siswa (id_mapel, nama_pelajaran, siswa, kkm, nilai_asli, dinilai_oleh) 
             VALUES (%s, %s, %s, %s, %s, %s)"""
    cursor.execute(sql, (id_mapel, nama_pelajaran, siswa, kkm, nilai_asli, dinilai_oleh))
    db.commit(); db.close()
    print("=> Data berhasil disimpan!")

def lihat_data():
    db = get_koneksi(); cursor = db.cursor()
    cursor.execute("SELECT id_mapel, nama_pelajaran, siswa, kkm, nilai_asli, dinilai_oleh FROM penilaian_siswa")
    print(f"\n{'ID Mapel':<10} | {'Nama Pelajaran':<20} | {'Siswa':<15} | {'KKM':<5} | {'Nilai':<6} | {'Dinilai Oleh'}")
    print("-" * 85)
    for row in cursor.fetchall():
        print(f"{row[0]:<10} | {row[1]:<20} | {row[2]:<15} | {row[3]:<5} | {row[4]:<6} | {row[5]}")
    db.close()

def hapus_data():
    db = get_koneksi(); cursor = db.cursor()
    id_mapel = input("\nMasukkan ID Mapel data yang ingin dihapus: ")
    cursor.execute("DELETE FROM penilaian_siswa WHERE id_mapel=%s", (id_mapel,))
    db.commit(); db.close()
    print("=> Data berhasil dihapus!")

while True:
    print("\n=== APLIKASI PENILAIAN AKADEMIK (PYTHON) ===")
    print("1. Tambah Data | 2. Lihat Data | 3. Hapus Data | 4. Keluar")
    pilihan = input("Pilih menu (1-4): ")
    if pilihan == '1': tambah_data()
    elif pilihan == '2': lihat_data()
    elif pilihan == '3': hapus_data()
    elif pilihan == '4': break