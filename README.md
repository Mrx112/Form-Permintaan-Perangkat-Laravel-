<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Project notes (From_Permintaan)



	1. Set `QUEUE_CONNECTION=database` (or redis) in your `.env`.
	2. Run the queue worker: `php artisan queue:work` or use a process manager.

	If no queue is configured, the app falls back to sending mail synchronously and logs failures rather than throwing.


# Sistem Permintaan (From_Permintaan)

Sistem Permintaan adalah aplikasi internal berbasis Laravel yang berfungsi untuk membuat, menyimpan, dan mengelola permintaan internal (Permintaan). Aplikasi ini mencakup manajemen pengguna (admin/user), proses persetujuan akun, unggah lampiran, autosave form, laporan, dan ekspor data.

Pembuat: Adi Susilo

---

## Ringkasan fitur

- Autentikasi: Registrasi, Login, Logout
- Peran: `admin` dan `user` (admin dapat menyetujui akun, melihat semua permintaan, mengekspor laporan)
- CRUD Permintaan dengan autosave dan lampiran file
- Hapus lampiran dari permintaan (file dihapus dari disk)
- Laporan: filter rentang tanggal, tampilkan hasil, ekspor CSV
- Profil pengguna: unggah avatar dengan resizing sederhana
- Notifikasi email untuk aktivasi/approval (bisa di-queue)

---

## Persyaratan

- PHP 8.1 atau 8.2 disarankan (PHP 8.4 dapat berjalan tapi mungkin menunjukkan E_DEPRECATED)
- Composer
- MySQL / MariaDB (atau DB lain yang kompatibel)
- Node.js + npm (opsional untuk build aset)
- (Opsional) Redis atau koneksi queue lain untuk antrian email

---

## Instalasi cepat (Local / Development)

1. Clone repository dan masuk ke folder:

```bash
git clone <repo-url> From_Permintaan
cd From_Permintaan
```

2. Install dependency PHP:

```bash
composer install
```

3. Buat file lingkungan dan generate app key:

```bash
cp .env.example .env
php artisan key:generate
# kemudian edit .env untuk mengatur DB_*, MAIL_*, APP_URL dll.
```

4. Jalankan migrasi dan seeder demo:

```bash
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder
```

Seeder akan membuat akun demo (admin dan user). Bila `APP_DEBUG=true` ada route dev quick-login untuk admin: `/dev-login/admin`.

5. (Opsional) Build aset frontend:

```bash
npm install
npm run dev
```

6. Jalankan server lokal:

```bash
php artisan serve
# Buka http://127.0.0.1:8000
```

---

## Instalasi produksi (Sistem kompleks)

Berikut panduan ringkas untuk menjalankan aplikasi pada infra produksi yang lebih kompleks.

1. Infrastruktur yang disarankan:
	- Web server (Nginx) + PHP-FPM
	- Database terpisah (MySQL/MariaDB)
	- Load balancer (jika memiliki beberapa instance)
	- Storage terpusat (S3 / NFS) untuk file unggahan
	- Redis untuk cache/session/queue
	- Process manager untuk queue workers (supervisord / systemd)

2. Deployment pipeline (CI/CD):
	- Checkout code → composer install → npm ci & build → migrate & seed (jika perlu) → restart PHP-FPM / queue workers

3. Konfigurasi queue & worker:
	- Set `QUEUE_CONNECTION=redis` (atau `database`) di `.env`.
	- Jalankan worker via supervisor/systemd:

```ini
[program:permintaan-queue]
command=php /path/to/your/app/artisan queue:work --sleep=3 --tries=3 --timeout=90
process_name=%(program_name)s_%(process_num)02d
numprocs=2
autostart=true
autorestart=true
user=www-data
stdout_logfile=/var/log/permintaan/queue.log
stderr_logfile=/var/log/permintaan/queue_err.log
```

4. Nginx (singkat):
	- Arahkan `root` ke folder `public/` pada project dan pastikan konfigurasi fastcgi untuk PHP-FPM benar.

5. File upload & storage:
	- Untuk produksi, gunakan S3 (aturlah `FILESYSTEM_DRIVER=s3` dan set `AWS_*` di `.env`) atau gunakan storage terpusat.
	- Pastikan permission `storage/` dan `public/uploader` dapat ditulisi.

6. Keamanan & monitoring:
	- Gunakan HTTPS, nonaktifkan `APP_DEBUG` di produksi
	- Pasang logging & monitoring (Sentry, Prometheus, Grafana)
	- Backup database dan storage rutin

7. Migrasi pada pipeline:

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Penggunaan

- Halaman utama: `/` (landing)
- Register: `/register` — setelah mendaftar, admin perlu menyetujui akun
- Login: `/login` — setelah login akan diarahkan ke `dashboard`
- Permintaan: buat/edit/hapus permintaan, unggah lampiran, dan manfaatkan autosave
- Laporan: `Admin -> Reports` untuk memfilter rentang tanggal dan mengekspor CSV
- Profil: unggah avatar, ubah info profil

---

## Akun demo

Seeder membuat akun demo. Contoh akun (periksa `database/seeders/DatabaseSeeder.php` untuk detail):
- Admin: `devilarm207@gmail.com` (role: `admin`)
- User: `user@example.com` (role: `user`)

Jika perlu, saya bisa mereset password menjadi `admin`/`admin` dan `user`/`user` untuk keperluan demo.

---

## Troubleshooting

- Deprecation notices pada PHP 8.4: non-blocking, disarankan gunakan PHP 8.1/8.2 untuk pengembangan.
- Email gagal terkirim: verifikasi `MAIL_*` di `.env` dan lihat log (`storage/logs/laravel.log`).
- Permission upload: pastikan `storage/` dan `public/uploader` ditulisi oleh user webserver.

---

## Pengembangan & kontribusi

- Ikuti alur git: buat fitur di branch, buat PR, sertakan test bila perlu.
- Untuk ekspor XLSX, gunakan paket `maatwebsite/excel`.

---

## Hak Cipta & Atribusi

Sistem ini dibuat oleh Adi Susilo. Silakan gunakan dan modifikasi untuk kebutuhan internal. Jika didistribusikan, harap sertakan atribusi.

---

Jika Anda memerlukan dokumentasi tambahan (mis. Docker Compose, konfigurasi Kubernetes, manifests supervisor), beri tahu saya dan saya akan menyiapkannya.


