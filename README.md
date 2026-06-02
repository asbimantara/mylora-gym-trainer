# 🏋️ MyLoRa Gym Trainer

**My Local Jepara Gym Trainer** — Platform marketplace jasa personal trainer fitness di Jepara.

MyLoRa menghubungkan personal trainer profesional dengan member yang ingin mencapai tujuan fitness mereka. Dilengkapi dengan sistem booking, pembayaran online (Midtrans), escrow, dan resolusi sengketa.

## 📱 App Preview

<details>
<summary><b>Klik untuk melihat tampilan aplikasi</b></summary>
<br>

**1. Halaman Beranda (Home)**
<img src="docs/screenshots/01-home.png" width="100%" alt="Beranda MyLoRa">

**2. Halaman Login**
<img src="docs/screenshots/03-login.png" width="100%" alt="Login">

**3. Halaman Register**
<img src="docs/screenshots/02-register.png" width="100%" alt="Register">

**4. Onboarding Member Baru**
<img src="docs/screenshots/04-onboarding.png" width="100%" alt="Onboarding">

**5. Rekomendasi Pelatih (Hasil Onboarding)**
<img src="docs/screenshots/05-recommendation.png" width="100%" alt="Rekomendasi Pelatih">

</details>


## ✨ Fitur Utama

### 👤 Member (Customer)
- Pencarian & filter personal trainer berdasarkan kategori
- Pembelian paket latihan dengan pembayaran online (Midtrans Snap)
- Booking sesi latihan individu berdasarkan jadwal trainer
- Validasi bentrok jadwal real-time
- Pembatalan jadwal mandiri (H-2)
- Konfirmasi sesi selesai & sistem review/rating
- Dispute/komplain dengan sistem escrow

### 🏅 Trainer (Pelatih)
- Pendaftaran profil & verifikasi admin
- Manajemen paket latihan, jadwal ketersediaan
- Kalender mingguan interaktif
- Konfirmasi booking & laporan sesi + upload bukti foto
- Wallet & penarikan dana (withdraw)
- Hak jawab atas komplain member

### 🔧 Admin
- Dashboard statistik (pendapatan, transaksi, pengguna)
- Verifikasi & approval trainer
- Laporan keuangan (platform fee 10%)
- Pusat resolusi sengketa (dispute)
- Verifikasi bukti latihan (QC/Payout)
- Manajemen penarikan dana trainer

## 🛠️ Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Database:** SQLite (development) / MySQL (production)
- **Frontend:** Blade + Bootstrap 5 + Bootstrap Icons
- **Payment Gateway:** Midtrans Snap
- **Authentication:** Laravel Breeze
- **Confirmation Dialogs:** SweetAlert2

## 🚀 Instalasi

```bash
# Clone repository
git clone https://github.com/YOUR_USERNAME/mylora-gym-trainer.git
cd mylora-gym-trainer

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
touch database/database.sqlite
php artisan migrate --seed

# Create storage symlink
php artisan storage:link

# Run development server
php artisan serve
```

## 👥 Akun Demo

| Role    | Email              | Password |
|---------|--------------------|----------|
| Admin   | admin@mylora.com   | password |
| Member  | demo@mylora.com    | password |
| Trainer | trainer1@mylora.com| password |
| Trainer | trainer2@mylora.com| password |
| Trainer | trainer3@mylora.com| password |

## 💰 Model Bisnis

Platform mengambil **biaya layanan 10%** yang dibebankan kepada member saat checkout. Trainer menerima **100% dari harga paket** yang mereka tetapkan, tanpa potongan saat penarikan dana.

## 📄 Lisensi

Proyek ini dibuat untuk keperluan akademik/tugas akhir.

---

**© 2026 MyLoRa Gym Trainer** — All rights reserved.
