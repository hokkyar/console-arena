# 🎮 Console Arena - Sistem Booking Rental PS  

Sistem ini adalah aplikasi booking rental PlayStation yang dibangun menggunakan **Laravel** dengan **Vite**, memiliki fitur utama tampilan calendar interaktif dan pembayaran yang terintegrasi melalui payment gateway Midtrans.  

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

