<div align="center">
  <h1>Donation Hub</h1>
  <p><em>Aplikasi donasi berbasis web dengan stack <b>VILT</b> (Vue, Inertia, Laravel, TailwindCSS)</em></p>

  <img src="https://img.shields.io/badge/Laravel-12-red?logo=laravel" alt="Laravel" />
  <img src="https://img.shields.io/badge/Vue-3-42b883?logo=vue.js" alt="Vue" />
  <img src="https://img.shields.io/badge/TailwindCSS-3-38bdf8?logo=tailwindcss" alt="TailwindCSS" />
  <img src="https://img.shields.io/badge/Inertia.js-1.0-8a4d76?logo=inertia" alt="Inertia.js" />
</div>

---

## Fitur Utama

-   Donatur bisa memilih campaign & berdonasi
-   Requester bisa ajukan proyek bantuan
-   Admin bisa verifikasi dan kelola donasi
-   Dashboard dinamis sesuai role
-   Frontend interaktif pakai Vue 3 + Vite

---

## Cara Menjalankan (Dockerized)

1. **Clone project**

    ```bash
    git clone https://github.com/username/donation-hub.git
    cd donation-hub
    ```

2. **Jalankan docker**
    ```bash
    docker-compose up -d --build
    ```

Ini akan otomatis:

-   Menyalin `.env.example` ke `.env` (jika belum ada)
-   Menjalankan `composer install`
-   Generate `APP_KEY`
-   Jalankan `migrate` dan `db:seed` (DatabaseSeeder)

---

## Akun Default dari Seeder

| Role      | Email                 | Password |
| --------- | --------------------- | -------- |
| Admin     | admin@example.com     | password |
| Donor     | donor@example.com     | password |
| Requester | requester@example.com | password |

> -   5 user dummy lainnya dengan role acak (`donor` / `requester`)

---

## Akses Aplikasi

-   Laravel backend: [http://localhost:8000](http://localhost)
-   phpMyAdmin: [http://localhost:8080](http://localhost:8080)
-   Adminer: [http://localhost:9090](http://localhost:9090)
-   Mailpit: [http://localhost:8025](http://localhost:8025)

---

## Stack Teknologi

<ul>
  <li><b>Laravel 12</b></li>
  <li><b>Vue 3 + Vite</b></li>
  <li><b>Inertia.js</b></li>
  <li><b>TailwindCSS</b></li>
  <li><b>MySQL 8</b></li>
  <li><b>Docker & Docker Compose</b></li>
</ul>

---

## Kontribusi

Proyek ini masih dikembangkan. Kamu bisa bantu lewat <b>fork</b>, <b>pull request</b>, atau diskusi di <b>issue</b>.

---

## Lisensi

MIT License – Silakan gunakan dan modifikasi dengan bijak.
