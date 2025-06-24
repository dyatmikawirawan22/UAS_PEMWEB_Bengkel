# Aplikasi Web Bengkel Motor - Punjung Rejeki Motor

Proyek ini merupakan aplikasi web bengkel motor bernama **Punjung Rejeki Motor** yang dibuat sebagai tugas UAS mata kuliah Pemrograman Web.

## Struktur Folder

```
/admin/
  └── admin_dashboard.php/
  └── booking_list.php/
  └── produk_edit.php/
  └── produk_tambah.php/
/auth/
  └── login.php/
  └── logout.php/
  └── register.php/
/includes/
  └── db.php/
/pages/
  └── booking/
      └── booking.php/
  └── chat/
      └── chat.php/
      └── kirim_pesan.php/
      └── load_chat.php/
  └── estimasi/
      └── estimasi_biaya.php/
  └── produk/
      └── produk_list.php/
  └── riwayat/
      └── riwayat_servis.php/
/profile/
  └── hapus_akun.php/
  └── profile.php/
  └── ubah_nama.php/
  └── ubah_password.php/
index.php
```

## Developer

- Nama: Aloisius Deardo Purba, Naufal Rahmadi Atha, Muhammad Bazwa Arigusna, Dyatmika Wirawan
- UPN "VETERAN" JAWA TIMUR

## Catatan

-Buat akun untuk admin: Buat akun sebagai pelanggan -> pada tabel user, ubah role menjadi admin

- Import database dari file `bengkel_sistem.sql`
- Koneksi database diatur pada `includes/db.php`:
  ```php
  $host = "localhost";
  $user = "root";
  $password = "";
  $database = "bengkel_sistem";
  ```
