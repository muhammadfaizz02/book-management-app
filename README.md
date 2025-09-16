Book Management App
Aplikasi manajemen buku dan peminjaman berbasis Laravel dengan API RESTful dan fitur autentikasi.

📋 Fitur

✅ CRUD Manajemen Buku - Create, Read, Update, Delete buku

✅ Sistem Peminjaman Buku - User dapat meminjam dan mengembalikan buku

✅ API RESTful - Endpoint API untuk semua operasi

✅ Autentikasi dengan Laravel Sanctum - Token-based authentication

✅ Search & Filter - Pencarian dan filter buku berdasarkan judul, penulis, tahun

✅ Queue & Jobs - Notifikasi email menggunakan queue system

✅ Unit Testing - Test coverage untuk fitur utama

✅ API Resources - Response API yang konsisten dan terstruktur

✅ Database Seeding - Data dummy untuk testing dan development

🛠️ Teknologi yang Digunakan
Laravel 10+

Laravel Sanctum (API Authentication)

MySQL Database

PHP 8.1+

Composer

Laravel Queue System

📦 Instalasi
Prerequisites
Pastikan Anda telah menginstall:

PHP 8.1 atau lebih baru

Composer

MySQL Server

Node.js (opsional, untuk frontend)

Langkah-langkah Instalasi
Clone atau download project

Install dependencies

bash
composer install
Setup environment

bash
cp .env.example .env
Generate application key

bash
php artisan key:generate
Konfigurasi database
Edit file .env dan sesuaikan dengan konfigurasi database Anda:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_management
DB_USERNAME=root
DB_PASSWORD=
Jalankan migrations dan seeders

bash
php artisan migrate
php artisan db:seed
Install Laravel Sanctum

bash
php artisan sanctum:install
php artisan migrate
Jalankan aplikasi

bash
php artisan serve
Jalankan queue worker (di terminal terpisah)

bash
php artisan queue:work
Aplikasi akan berjalan di http://localhost:8000

🌐 API Endpoints

Authentication
POST /api/register - Mendaftar user baru

POST /api/login - Login user

POST /api/logout - Logout user (memerlukan authentication)

Books
GET /api/books - Daftar buku dengan pagination, search, dan filter

POST /api/books - Tambah buku baru (memerlukan authentication)

GET /api/books/{id} - Detail buku

PUT /api/books/{id} - Update buku (memerlukan authentication)

DELETE /api/books/{id} - Hapus buku (memerlukan authentication)

Loans
POST /api/loans - Meminjam buku (memerlukan authentication)

GET /api/loans/{user_id} - Daftar buku yang dipinjam user (memerlukan authentication)

Query Parameters untuk Books
?search=keyword - Pencarian berdasarkan judul buku

?author=name - Filter berdasarkan penulis

?year=2023 - Filter berdasarkan tahun terbit

?page=2 - Pagination

📖 Contoh Penggunaan API

1. Register User
bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
  }'
2. Login
bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password"
  }'
Response akan memberikan token authentication:

json
{
  "access_token": "1|abc123...",
  "token_type": "Bearer"
}
3. Get Books dengan Filter
bash
curl -X GET "http://localhost:8000/api/books?author=J.K.%20Rowling&year=1997" \
  -H "Authorization: Bearer your_token_here"
4. Pinjam Buku
bash
curl -X POST http://localhost:8000/api/loans \
  -H "Authorization: Bearer your_token_here" \
  -H "Content-Type: application/json" \
  -d '{
    "book_id": 1
  }'
5. Lihat Buku yang Dipinjam
bash
curl -X GET http://localhost:8000/api/loans/1 \
  -H "Authorization: Bearer your_token_here"
👥 Data Default

Setelah menjalankan seeder, akan tersedia:

Users
Admin: admin@example.com / password

10 Regular Users: user1@example.com hingga user10@example.com / password

Books
30 buku dummy dengan data acak

🧪 Testing

Jalankan test suite dengan perintah:

bash
php artisan test
Test mencakup:

✅ Menambah buku baru

✅ Validasi input buku

✅ Meminjam buku

✅ Validasi stok buku

✅ Autentikasi user

⚡ Queue & Notifications

Aplikasi menggunakan Laravel Queue untuk mengirim notifikasi email ketika user meminjam buku. Untuk testing, notifikasi akan dicatat di file log:

bash
tail -f storage/logs/laravel.log
🗃️ Struktur Database

Tables
users - Tabel user

books - Data buku (title, author, year, isbn, stock)

book_loans - Data peminjaman buku (relasi many-to-many)

personal_access_tokens - Token authentication untuk Sanctum

Relations
User dapat meminjam banyak Book

Book dapat dipinjam banyak User

Relasi many-to-many melalui tabel pivot book_loans

✅ Validasi
Book Validation

✅ Title: required, string, max:255

✅ Author: required, string, max:255

✅ Published Year: required, digits:4, min:1900, max:tahun sekarang

✅ ISBN: required, string, unique

✅ Stock: required, integer, min:0

Loan Validation
✅ Book harus tersedia (stock > 0)

✅ User tidak dapat meminjam buku yang sama dua kali tanpa mengembalikan

🔧 Troubleshooting

Error 404 pada API
Pastikan route sudah terdaftar:

bash
php artisan route:list
Error Authentication
Pastikan header Authorization sudah benar:

http
Authorization: Bearer your_token_here
Error Database
Pastikan konfigurasi database di .env sudah benar dan migration sudah dijalankan.

Error Queue
Pastikan queue worker sedang berjalan:

bash
php artisan queue:work
🚀 Development

Menambah Fitur Baru
Buat migration jika perlu

Buat model dan controller

Definisikan route di routes/api.php

Buat test untuk fitur baru

Jalankan test untuk memastikan tidak ada regression

Code Style
Project mengikuti PSR-12 coding standard.

🌐 Deployment

Requirements untuk Production
PHP 8.1+

MySQL 5.7+

Composer

Queue Worker (Supervisor recommended)

Steps
Clone repository

composer install --optimize-autoloader --no-dev

Setup .env file

php artisan key:generate

php artisan migrate --force

php artisan storage:link

Setup queue worker

Setup web server (Nginx/Apache)
