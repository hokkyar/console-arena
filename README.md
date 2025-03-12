# 🎮 Console Arena - Sistem Booking Rental PS  

Sistem ini adalah aplikasi booking rental PlayStation yang dibangun menggunakan **Laravel** dengan **Vite**, serta mendukung autentikasi Google dan pembayaran melalui Midtrans.  

---

## 🚀 **Fitur Utama**
- 🔹 **Booking Rental PS** (PS4 & PS5) dengan tampilan kalender interaktif  
- 🔹 **Pembayaran via Midtrans (Sandbox Mode)**  

---

## 🛠 **Instalasi & Setup**
```sh
git clone https://github.com/hokkyar/console-arena.git
cd console-arena

composer install
npm install

cp .env.example .env

php artisan key:generate
php artisan migrate --seed

npm run dev
php artisan serve

