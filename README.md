# HRPortal

## Deskripsi
HRPortal adalah aplikasi berbasis web untuk pengelolaan database kepegawaian, dengan fitur utama pencatatan kontrak kerja, status karyawan, dan peringatan untuk kontrak yang hampir habis.

## Teknologi yang Digunakan
- **Backend:** Laravel 11
- **Frontend:** Tailwind CSS
- **Database:** MySQL
- **Tools Tambahan:** PHPMyAdmin, GitHub

## Fitur Aplikasi
### Admin
- Dashboard dengan ringkasan data pegawai dan kontrak
- CRUD data pegawai (termasuk pembuatan akun login)
- CRUD data kontrak kerja

### Karyawan
- Dashboard dengan informasi pegawai dan kontrak
- Melihat profil dan memperbarui informasi pribadi
- Melihat kontrak aktif dan riwayat kontrak

## Instalasi
1. Clone repository:
   ```bash
   git clone https://github.com/mcnemy001/hrportal.git
   cd hrportal
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database.
   ```bash
   cp .env.example .env
   ```
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Migrasi database:
   ```bash
   php artisan migrate --seed
   ```
6. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

## Struktur Database
Lihat file `database_dump/aziyusman_IF-10_Kepegawaian.sql` untuk skema lengkap database.

## Link Repository
[GitHub Repository](https://github.com/username/repository)
