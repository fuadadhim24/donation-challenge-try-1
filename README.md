<div align="center">
  <h1>Donation Hub</h1>
  <p><em>Aplikasi donasi berbasis web dengan stack <b>VILT</b> (Vue, Inertia, Laravel, TailwindCSS)</em></p>
  
  <img src="https://img.shields.io/badge/Laravel-12-red?logo=laravel" alt="Laravel" />
  <img src="https://img.shields.io/badge/Vue-3-42b883?logo=vue.js" alt="Vue" />
  <img src="https://img.shields.io/badge/TailwindCSS-3-38bdf8?logo=tailwindcss" alt="TailwindCSS" />
  <img src="https://img.shields.io/badge/Inertia.js-1.0-8a4d76?logo=inertia" alt="Inertia.js" />
</div>

## ✨ Fitur Utama

-   Donatur bisa memilih campaign & berdonasi
-   Requester bisa ajukan proyek bantuan
-   Admin bisa verifikasi dan kelola donasi
-   Dashboard dinamis sesuai role
-   Frontend interaktif pakai Vue 3 + Vite

---

## 🚀 Cara Menjalankan (Dockerized)

1. **Clone project:**
    ```bash
    git clone https://github.com/username/donation-hub.git
    cd donation-hub
    ```
2. **Salin file env:**
    ```bash
    cp .env.example .env
    ```
3. **Ubah konfigurasi database di `.env` jika perlu:**
    ```env
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=donation_hub
    DB_USERNAME=root
    DB_PASSWORD=root
    ```
4. **Jalankan docker:**
    ```bash
    docker-compose up -d --build
    ```
5. **Masuk ke container app:**
    ```bash
    docker exec -it donation-app bash
    ```
6. **Generate key & migrasi + seed:**
    ```bash
    php artisan key:generate
    php artisan migrate
    php artisan db:seed --class=DatabaseSeeder
    ```

---

## 🌐 Akses Aplikasi

-   Laravel backend: [http://localhost:8000](http://localhost:8000)
-   Vite dev server: [http://localhost:5173](http://localhost:5173)

---

## 🛠️ Stack Teknologi

<ul>
  <li><b>Laravel 12</b></li>
  <li><b>Vue 3 + Vite</b></li>
  <li><b>Inertia.js</b></li>
  <li><b>TailwindCSS</b></li>
  <li><b>MySQL</b></li>
</ul>

---

## 🤝 Kontribusi

Proyek ini masih dikembangkan. Kamu bisa bantu lewat <b>fork</b>, <b>pull request</b>, atau diskusi <b>issue</b>.

---

## 📄 Lisensi

MIT License – Silakan gunakan dan modifikasi dengan bijak.
