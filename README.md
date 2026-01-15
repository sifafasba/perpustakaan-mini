# 📚 Sistem Perpustakaan Mini - Laravel

Aplikasi web manajemen perpustakaan sederhana menggunakan Laravel dengan fitur peminjaman dan pengembalian buku.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat&logo=bootstrap&logoColor=white)

---

## 📋 Daftar Isi

- [Fitur Aplikasi](#-fitur-aplikasi)
- [Teknologi](#-teknologi-yang-digunakan)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Cara Install](#-cara-install)
- [Konfigurasi Database](#-konfigurasi-database)
- [Migrasi & Seeder](#-migrasi--seeder)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Akun Demo](#-akun-demo)
- [Struktur Database](#-struktur-database)
- [Troubleshooting](#-troubleshooting)
- [Dokumentasi Fitur](#-dokumentasi-fitur)

---

## ✨ Fitur Aplikasi

### 👨‍💼 Fitur Admin
- ✅ **Manajemen Buku** - CRUD (Create, Read, Update, Delete) buku
- ✅ **Manajemen User** - CRUD user, atur role (admin/user), lihat detail & riwayat peminjaman
- ✅ **Lihat Semua Transaksi** - Monitor seluruh aktivitas peminjaman
- ✅ **Kelola Status Transaksi** - Update status peminjaman/pengembalian
- ✅ **Dashboard Statistik** - Total buku, peminjaman, user, dll
- ✅ **Filter & Pencarian** - Filter berdasarkan status, kategori, judul, role

### 👤 Fitur User
- ✅ **Registrasi Akun** - Daftar akun baru tanpa perlu admin
- ✅ **Lihat Daftar Buku** - Browse koleksi buku perpustakaan
- ✅ **Pinjam Buku** - Maksimal 3 buku aktif per user
- ✅ **Kembalikan Buku** - Return buku yang dipinjam
- ✅ **Riwayat Peminjaman** - Lihat history transaksi pribadi
- ✅ **Dashboard Pribadi** - Info peminjaman aktif & deadline
- ✅ **Kelola Profil** - Update nama, email, dan password

### 🔐 Sistem Keamanan
- ✅ **Autentikasi Laravel** - Login/Logout/Register dengan session
- ✅ **Role-Based Access** - Admin & User memiliki akses berbeda
- ✅ **Middleware Protection** - Route dilindungi middleware auth & admin
- ✅ **Validasi Form** - Input validation untuk semua form
- ✅ **CSRF Protection** - Token CSRF untuk keamanan
- ✅ **Password Hashing** - Password di-hash dengan bcrypt

### 📊 Business Logic
- ✅ **Auto Calculate** - Tanggal pinjam & batas kembali otomatis (7 hari)
- ✅ **Stock Management** - Stok otomatis berkurang/bertambah
- ✅ **Borrowing Limit** - User maksimal 3 peminjaman aktif
- ✅ **Overdue Detection** - Deteksi keterlambatan pengembalian
- ✅ **Relasi Database** - Eloquent relationships (categories, books, borrowings)

---

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel 11
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0 / MariaDB
- **Frontend**: Blade Templates, Bootstrap 5.3
- **Icons**: Bootstrap Icons
- **Authentication**: Laravel Breeze / Custom Auth
- **ORM**: Eloquent
- **Validation**: Form Request Validation

---

## 💻 Persyaratan Sistem

Pastikan sistem Anda sudah memiliki:

- **PHP** >= 8.2
- **Composer** (latest version)
- **MySQL** >= 8.0 atau **MariaDB** >= 10.3
- **Node.js & NPM** (optional, untuk compile assets)
- **Git** (untuk clone repository)

### Ekstensi PHP yang Diperlukan:
```
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath
```

---

## 📥 Cara Install

### 1️⃣ Clone atau Download Project

**Opsi A: Clone Repository (jika ada)**
```bash
git clone https://github.com/username/perpustakaan-mini.git
cd perpustakaan-mini
```

**Opsi B: Buat Project Laravel Baru**
```bash
composer create-project laravel/laravel perpustakaan-mini
cd perpustakaan-mini
```

### 2️⃣ Install Dependencies

```bash
composer install
```

### 3️⃣ Copy Environment File

```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

### 4️⃣ Generate Application Key

```bash
php artisan key:generate
```

---

## 🗄️ Konfigurasi Database

### 1️⃣ Buat Database Baru

Buka MySQL/MariaDB:

```bash
mysql -u root -p
```

Jalankan perintah SQL:

```sql
CREATE DATABASE perpustakaan_db;
exit;
```

### 2️⃣ Konfigurasi File `.env`

Edit file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME="Perpustakaan Mini"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan_db
DB_USERNAME=root
DB_PASSWORD=
```

**Sesuaikan:**
- `DB_DATABASE` → Nama database yang dibuat
- `DB_USERNAME` → Username MySQL (default: `root`)
- `DB_PASSWORD` → Password MySQL (kosongkan jika tidak ada)

---

## 🚀 Migrasi & Seeder

### 1️⃣ Jalankan Migration

Migration akan membuat tabel-tabel di database:

```bash
php artisan migrate
```

**Tabel yang dibuat:**
- `users` - Data pengguna (admin & user)
- `categories` - Kategori buku
- `books` - Data buku
- `borrowings` - Transaksi peminjaman

### 2️⃣ Jalankan Seeder

Seeder akan mengisi database dengan data dummy:

```bash
php artisan db:seed
```

**Data yang di-seed:**
- 1 Admin
- 2 User
- 5 Kategori (Fiksi, Non-Fiksi, Teknologi, Sejarah, Sains)
- 6 Buku contoh

### 3️⃣ Migrate Fresh + Seed (Reset Database)

Untuk reset database dan isi ulang dengan data baru:

```bash
php artisan migrate:fresh --seed
```

⚠️ **Peringatan:** Command ini akan **menghapus semua data** di database!

---

## 🏃 Menjalankan Aplikasi

### 1️⃣ Start Development Server

```bash
php artisan serve
```

Server akan berjalan di: **http://127.0.0.1:8000** atau **http://localhost:8000**

### 2️⃣ Akses Aplikasi

Buka browser dan akses:

```
http://127.0.0.1:8000
```

atau

```
http://localhost:8000
```

Anda akan diarahkan ke halaman login.

### 3️⃣ Login dengan Akun Demo

Gunakan salah satu akun demo di bawah.

---

## 🔐 Akun Demo

### 👨‍💼 Admin
```
Email    : admin@perpus.com
Password : admin123
Role     : admin
```

**Akses Admin:**
- ✅ Semua fitur user
- ✅ Tambah/Edit/Hapus buku
- ✅ Tambah/Edit/Hapus user
- ✅ Atur role user (admin/user)
- ✅ Lihat semua transaksi
- ✅ Update status transaksi
- ✅ Lihat detail & riwayat peminjaman user
- ✅ Dashboard statistik lengkap

---

### 👤 User 1
```
Email    : budi@mail.com
Password : user123
Role     : user
```

### 👤 User 2
```
Email    : siti@mail.com
Password : user123
Role     : user
```

**Akses User:**
- ✅ Registrasi akun sendiri
- ✅ Lihat & cari buku
- ✅ Pinjam buku (max 3 aktif)
- ✅ Kembalikan buku
- ✅ Lihat riwayat pribadi
- ✅ Kelola profil (nama, email, password)

---

## 📊 Struktur Database

### Tabel: `users`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Nama lengkap |
| email | varchar | Email (unique) |
| password | varchar | Password (hashed) |
| role | enum | 'admin' atau 'user' |

### Tabel: `categories`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Nama kategori |
| description | text | Deskripsi kategori |

### Tabel: `books`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| title | varchar | Judul buku |
| author | varchar | Penulis |
| year | year | Tahun terbit |
| stock | integer | Jumlah stok |
| category_id | bigint | Foreign key ke categories |
| isbn | varchar | ISBN buku |
| description | text | Deskripsi buku |

### Tabel: `borrowings`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key ke users |
| book_id | bigint | Foreign key ke books |
| borrow_date | date | Tanggal pinjam |
| due_date | date | Batas pengembalian |
| return_date | date | Tanggal dikembalikan (nullable) |
| status | enum | 'BORROWED' atau 'RETURNED' |

### Relasi Database
```
users (1) ──→ (∞) borrowings
books (1) ──→ (∞) borrowings
categories (1) ──→ (∞) books
```

---

## 🐛 Troubleshooting

### Error: `Class not found`
```bash
composer dump-autoload
php artisan clear-compiled
```

### Error: `Session store not set`
```bash
php artisan config:clear
php artisan cache:clear
```

### Error: Migration Failed
```bash
# Pastikan database sudah dibuat
# Cek konfigurasi .env
# Drop semua tabel dan migrate ulang
php artisan migrate:fresh --seed
```

### Error: `404 Not Found` di Routes
```bash
php artisan route:clear
php artisan config:clear
php artisan serve
```

### Error: Permission Denied (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Clear All Cache
```bash
php artisan optimize:clear
# atau
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Port 8000 Already in Use
```bash
# Gunakan port lain
php artisan serve --port=8001
```

---

## 📱 Dokumentasi Fitur

### 🔐 Register (User Baru)
1. Akses `http://localhost:8000/register`
2. Isi form registrasi:
   - Nama Lengkap
   - Email (harus unique)
   - Password (minimal 8 karakter)
   - Konfirmasi Password
3. Klik tombol **"Daftar"**
4. Otomatis login dan masuk ke dashboard

### 🔐 Login
1. Akses `http://localhost:8000`
2. Masukkan email & password
3. Klik tombol "Masuk"

### 📊 Dashboard
- **Admin**: Lihat statistik total buku, peminjaman, user
- **User**: Lihat jumlah peminjaman aktif & deadline terdekat

### 👥 Manajemen User (Admin)
1. Klik menu **"Kelola User"** (hanya muncul untuk admin)
2. Fitur yang tersedia:
   - **Lihat Daftar User** - List semua user dengan info role & peminjaman aktif
   - **Tambah User** - Klik tombol "Tambah User", isi form (nama, email, password, role)
   - **Edit User** - Klik icon pensil, ubah data user (nama, email, role, password opsional)
   - **Hapus User** - Klik icon tempat sampah (tidak bisa hapus diri sendiri atau user dengan peminjaman aktif)
   - **Detail User** - Klik icon mata untuk lihat info lengkap & riwayat peminjaman user
   - **Search & Filter** - Cari berdasarkan nama/email, filter by role (admin/user)

**Validasi Manajemen User:**
- ✅ Email harus unique
- ✅ Password minimal 8 karakter
- ✅ Tidak bisa hapus diri sendiri
- ✅ Tidak bisa hapus user yang punya peminjaman aktif
- ✅ Role: admin atau user

### 📚 Manajemen Buku (Admin)
1. Klik menu **"Daftar Buku"**
2. Klik tombol **"Tambah Buku"**
3. Isi form (judul, penulis, tahun, stok, kategori)
4. Klik **"Simpan"**

**Edit Buku:**
- Klik icon pensil (✏️) pada buku yang ingin diedit

**Hapus Buku:**
- Klik icon tempat sampah (🗑️) pada buku yang ingin dihapus

### 📖 Pinjam Buku (User)
1. Klik menu **"Daftar Buku"**
2. Pilih buku yang ingin dipinjam
3. Klik tombol **"Pinjam"**
4. Sistem otomatis:
   - Set tanggal pinjam = hari ini
   - Set batas kembali = 7 hari dari sekarang
   - Kurangi stok buku

**Syarat Peminjaman:**
- Stok buku harus > 0
- User maksimal 3 peminjaman aktif

### 🔄 Kembalikan Buku
1. Klik menu **"Transaksi"**
2. Cari buku yang ingin dikembalikan
3. Klik tombol **"Kembalikan"**
4. Status berubah menjadi "RETURNED"
5. Stok buku otomatis bertambah

### 🔍 Pencarian & Filter
**Daftar Buku:**
- Cari berdasarkan judul atau penulis
- Filter berdasarkan kategori

**Transaksi (Admin):**
- Cari berdasarkan judul buku
- Filter berdasarkan status (BORROWED/RETURNED)

### 👤 Kelola Profil
1. Klik menu **"Profil"**
2. Edit nama, email, atau password
3. Klik **"Simpan Perubahan"**

### 🚪 Logout
1. Klik tombol **"Logout"** di sidebar
2. Anda akan diarahkan ke halaman login

---
## 🎯 Business Rules

### Peminjaman Buku
- ✅ Durasi peminjaman: **7 hari**
- ✅ Maksimal peminjaman aktif per user: **3 buku**
- ✅ Stok buku harus tersedia (> 0)
- ✅ Tanggal pinjam otomatis = hari ini
- ✅ Batas kembali otomatis = 7 hari dari sekarang

### Validasi Data
- ✅ Judul buku minimal 3 karakter
- ✅ Stok tidak boleh negatif
- ✅ Tahun terbit: 1900 - tahun sekarang
- ✅ ISBN harus unique (jika diisi)
- ✅ Email harus valid dan unique

### Stok Management
- ✅ Stok otomatis berkurang saat buku dipinjam
- ✅ Stok otomatis bertambah saat buku dikembalikan
- ✅ Admin dapat update stok manual via edit buku

---

## 📞 Support & Bantuan

### Dokumentasi Resmi
- Laravel: https://laravel.com/docs
- Bootstrap: https://getbootstrap.com/docs
- MySQL: https://dev.mysql.com/doc/

### Command Berguna

```bash
# Lihat semua routes
php artisan route:list

# Lihat struktur database
php artisan migrate:status

# Buat controller baru
php artisan make:controller NamaController

# Buat model baru
php artisan make:model NamaModel -m

# Rollback migration
php artisan migrate:rollback

# Seed ulang data
php artisan db:seed

# Cache optimize
php artisan optimize
```

---

## 👨‍💻 Author

**Nama**: Qorin Sifa Ekafasba, Moh. Atif Fauzan, Moh. Hasrul H.  
**NIM**: 2402310233, 2402310225, 2402310223  
**Kelas**: Informatika G24  
**Mata Kuliah**: Web Programming

---
