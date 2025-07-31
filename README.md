
# Kantin POS - Aplikasi Point of Sale Sederhana

Kantin POS adalah aplikasi Point of Sale (POS) berbasis web yang dirancang untuk mengelola pesanan dan transaksi di lingkungan seperti kantin perkantoran atau kafe. Aplikasi ini dibangun menggunakan **Laravel 12** dengan frontend **CSS murni** dan database **PostgreSQL**.

Aplikasi ini memiliki tiga peran pengguna yang berbeda dengan alur kerja yang jelas: **Divisi (pelanggan)**, **Outlet (penjual/dapur)**, dan **Admin (manajemen)**.

---

## Fitur Utama

### 1. Peran Admin
- **Dashboard Terpusat:** Melihat pesanan baru yang masuk dan memerlukan persetujuan.
- **Manajemen Pesanan:** Menyetujui pesanan dari Divisi untuk diteruskan ke Outlet.
- **Manajemen Keuangan:** Mencatat pembayaran untuk setiap pesanan dan melacak sisa tagihan.
- **Rekap Transaksi:** Melihat riwayat semua transaksi yang telah selesai, lengkap dengan detail item, kuantitas, dan harga.
- **Manajemen Master Data:**
  - CRUD (Create, Read, Update, Delete) untuk data Outlet (lokasi fisik).
  - CRUD untuk Akun Pengguna Outlet (kasir).
  - CRUD untuk Akun Pengguna Divisi (pelanggan).

### 2. Peran Outlet
- **Manajemen Menu:** CRUD penuh untuk produk/menu, termasuk kemampuan untuk mengunggah gambar produk.
- **Manajemen Stok:** Memperbarui jumlah stok harian untuk setiap menu.
- **Proses Pesanan:** Menerima pesanan yang telah disetujui oleh Admin dan menandainya sebagai "Selesai" setelah disiapkan.
- **Riwayat Transaksi:** Melihat daftar semua transaksi yang telah diselesaikan oleh outlet tersebut.
- **Profil Terisolasi:** Setiap akun Outlet hanya dapat melihat dan mengelola data yang relevan dengan outlet tempat mereka ditugaskan.

### 3. Peran Divisi
- **Katalog Produk Global:** Melihat semua menu yang tersedia dari semua outlet dalam satu tampilan kartu yang modern.
- **Pemesanan Mudah:** Menambahkan produk dari berbagai outlet ke dalam satu keranjang dan mengirimkan pesanan. Sistem akan secara otomatis memecahnya menjadi pesanan terpisah untuk setiap outlet.
- **Riwayat Pesanan:** Melihat riwayat semua pesanan yang pernah dibuat beserta statusnya (Pending, Approved, Completed).

---

## Fitur Umum
- **Manajemen Profil:** Semua pengguna dapat mengubah nama, username, dan password mereka sendiri dengan aman.
- **Sistem Login:** Otentikasi berbasis Username dan Password.

---

## Teknologi yang Digunakan
- **Backend:** Laravel 12
- **Frontend:** PHP Blade & CSS Murni (Tanpa framework JS/CSS)
- **Database:** PostgreSQL

---

## Panduan Instalasi

### 1. Clone Repositori
```bash
git clone https://github.com/username-anda/nama-repositori.git
cd nama-repositori
```

### 2. Install Dependensi
Pastikan Anda memiliki Composer terinstal.
```bash
composer install
```

### 3. Konfigurasi Lingkungan (.env)
Salin file `.env.example` menjadi `.env`.
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan konfigurasi database Anda, terutama:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=pos_laravel_app
DB_USERNAME=postgres
DB_PASSWORD=password_anda
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi & Seeding
Perintah ini akan membuat semua tabel database dan mengisinya dengan data awal (akun admin, outlet, dan divisi).
```bash
php artisan migrate:fresh --seed
```

### 6. Buat Symbolic Link untuk Storage
```bash
php artisan storage:link
```

### 7. Jalankan Server
```bash
php artisan serve
```
Aplikasi sekarang akan berjalan di [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## Akun Default
Anda dapat login menggunakan akun default yang dibuat oleh seeder:

**Admin:**
- Username: `admin`
- Password: `password`

**Outlet:**
- Username: `outletA`
- Password: `password`

**Divisi:**
- Username: `marketing`
- Password: `password`

---

Dibuat dengan ❤️ menggunakan Laravel.
