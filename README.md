# 🏋️ MyLoRa Gym Trainer

**My Local Jepara Gym Trainer** — Platform marketplace jasa personal trainer fitness di Jepara.

MyLoRa menghubungkan personal trainer profesional dengan member yang ingin mencapai tujuan fitness mereka. Dilengkapi dengan sistem booking, pembayaran online (Midtrans), escrow, dan resolusi sengketa.

## 📖 Latar Belakang & Pendekatan Riset

Aplikasi ini dikembangkan berdasarkan pendekatan riset akademik (studi kasus di Jepara) untuk mengidentifikasi dan memecahkan masalah nyata dalam ekosistem kebugaran lokal. Dari hasil observasi awal, ditemukan tiga masalah utama (*Pain Points*):
1. **Asimetri Informasi & Visibilitas:** Masyarakat awam kesulitan mencari pelatih kebugaran yang kredibel dan bersertifikasi di daerah mereka.
2. **Konflik Penjadwalan (Scheduling Collision):** Proses *booking* manual via WhatsApp seringkali menyebabkan bentrok jadwal antara pelatih dan klien yang berbeda.
3. **Krisis Kepercayaan (Trust Issue):** Tidak adanya jaminan keamanan dana jika pelatih membatalkan sesi atau klien tidak hadir (*no-show*).

### 📊 Data Pendukung Observasi (Studi Kasus Kabupaten Jepara)
Berdasarkan hasil wawancara dan observasi awal terhadap beberapa pusat kebugaran (gym) di Jepara pada tahun 2024, diperoleh data pendukung berikut:
- **Tingginya Minat Fitness Pasca Pandemi:** Terjadi lonjakan pendaftaran *member* baru di gym lokal hingga 40%, namun sebagian besar pemula kebingungan menyusun program latihan yang benar karena rasio pelatih tetap (*in-house trainer*) sangat terbatas (rata-rata hanya 1-2 pelatih per gym).
- **Dominasi Freelance Trainer:** Sebanyak 70% *personal trainer* di Jepara berstatus *freelance* dan menawarkan jasa dari mulut ke mulut. Mereka kesulitan melakukan *personal branding* dan merekap jadwal klien secara profesional.
- **Kasus Perselisihan (Dispute):** Sering terjadi kerugian finansial akibat klien membatalkan sesi secara sepihak (H-1 jam) tanpa kompensasi kepada pelatih, atau sebaliknya pelatih tidak hadir setelah dibayar di muka (*DP*).

Sebagai solusi konseptual dari data di atas, **MyLoRa (My Local Jepara)** dirancang sebagai *platform marketplace* dengan pendekatan *Heuristic Recommender System*, *Interval Scheduling*, dan *Escrow Wallet System* guna menciptakan ekosistem kebugaran yang transparan, aman, dan terotomatisasi.

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

**6. Halaman Cari Trainer (Katalog)**
<img src="docs/screenshots/06-trainer-search.png" width="100%" alt="Katalog Trainer">

**7. Halaman Profil & Paket Pelatih**
<img src="docs/screenshots/07-trainer-profile.png" width="100%" alt="Profil Pelatih">

**8. Memilih Paket Latihan (Member)**
<img src="docs/screenshots/08-member-packages.png" width="100%" alt="Pilih Paket">

**9. Checkout Paket Latihan (Member)**
<img src="docs/screenshots/09-member-checkout.png" width="100%" alt="Checkout">

**10. Pembayaran Online Midtrans (Member)**
<img src="docs/screenshots/10-member-payment.png" width="100%" alt="Pembayaran Midtrans">

**11. Dashboard Member**
<img src="docs/screenshots/11-member-dashboard.png" width="100%" alt="Dashboard Member">

**12. Penjadwalan Sesi Latihan (Kalender)**
<img src="docs/screenshots/12-member-book-session.png" width="100%" alt="Penjadwalan Sesi">

**13. Pop-up Konfirmasi & Aksi Dashboard (Member)**
<img src="docs/screenshots/13-member-popup-action.png" width="100%" alt="Pop-up Aksi">

**14. Pop-up Pusat Resolusi / Komplain (Member)**
<img src="docs/screenshots/14-member-popup-dispute.png" width="100%" alt="Pop-up Komplain">

**15. Pop-up Beri Ulasan & Rating (Member)**
<img src="docs/screenshots/15-member-popup-review.png" width="100%" alt="Pop-up Ulasan">

**16. Dashboard Pelatih (Trainer)**
<img src="docs/screenshots/16-trainer-dashboard.png" width="100%" alt="Dashboard Pelatih">

**17. Pengaturan Profil Pelatih**
<img src="docs/screenshots/17-trainer-profile.png" width="100%" alt="Profil Pelatih">

**18. Manajemen Paket Latihan (Pelatih)**
<img src="docs/screenshots/18-trainer-packages.png" width="100%" alt="Paket Latihan Pelatih">

**19. Pengaturan Ketersediaan Waktu (Pelatih)**
<img src="docs/screenshots/19-trainer-availability.png" width="100%" alt="Ketersediaan Pelatih">

**20. Pop-up Laporan Sesi Latihan (Pelatih)**
<img src="docs/screenshots/20-trainer-popup-report.png" width="100%" alt="Laporan Sesi">

**21. Pop-up Pusat Resolusi Hak Jawab (Pelatih)**
<img src="docs/screenshots/21-trainer-popup-dispute-reply.png" width="100%" alt="Jawab Sengketa">

**22. Pop-up Status Menunggu Admin (Pelatih)**
<img src="docs/screenshots/22-trainer-popup-dispute-status.png" width="100%" alt="Status Sengketa">

**23. Dashboard Admin Utama**
<img src="docs/screenshots/23-admin-dashboard.png" width="100%" alt="Dashboard Admin">

**24. Manajemen Pelatih (Admin)**
<img src="docs/screenshots/24-admin-trainers.png" width="100%" alt="Manajemen Pelatih">

**25. Pusat Resolusi Sengketa & QC Payout (Admin)**
<img src="docs/screenshots/25-admin-payouts.png" width="100%" alt="Pusat Resolusi Admin">

**26. Verifikasi Penarikan Dana / Withdrawals (Admin)**
<img src="docs/screenshots/26-admin-withdrawals.png" width="100%" alt="Withdrawals Admin">

**27. Laporan Pendapatan Platform (Admin)**
<img src="docs/screenshots/27-admin-reports.png" width="100%" alt="Laporan Pendapatan">

</details>

## 🧠 Algoritma & Konsep Sistem Utama

Untuk menjawab pertanyaan teknis terkait arsitektur perangkat lunak, MyLoRa mengimplementasikan beberapa algoritma dan logika sistem berikut:

1. **Heuristic Scoring Algorithm (Sistem Rekomendasi)**
   Digunakan pada fitur *Onboarding* Member. Sistem akan mengumpulkan preferensi *user* (tujuan latihan, level pengalaman, preferensi gender pelatih) lalu melakukan iterasi komputasi bobot (*weighting*) terhadap seluruh data pelatih yang aktif. Pelatih dengan skor kecocokan (*matching score*) tertinggi akan diurutkan dan direkomendasikan secara dinamis.
   
2. **Interval Scheduling & Collision Detection (Sistem Penjadwalan)**
   Sistem penjadwalan MyLoRa menggunakan logika *Time-Slot Generation* dengan pendekatan pemfilteran himpunan (*Set Difference*). Saat Member memilih tanggal, sistem membangun daftar slot waktu berdasarkan ketersediaan (*availability*) mingguan pelatih, lalu melakukan deteksi bentrok (*collision detection*) dengan query database (`WHERE BETWEEN`) untuk menghapus slot yang sudah di-*booking* oleh member lain.

3. **Deterministic Finite Automaton / DFA (Siklus Transaksi)**
   Seluruh *booking* dikelola menggunakan konsep *State Machine* (Mesin Status) yang ketat. Transaksi memiliki alur transisi mutlak: `pending` → `confirmed` → `waiting_confirmation` (atau `disputed`) → `completed`. Status tidak bisa melompati tahapan tanpa validasi otorisasi ganda (dari member maupun pelatih).

4. **Escrow System Logic (Pusat Resolusi Dana)**
   Sistem keamanan dana menggunakan logika Rekening Bersama (*Escrow*). Saat member membayar, dana ditahan di *Platform Wallet* (Midtrans). Dana baru akan dialokasikan (`increment()`) ke tabel `wallet_balance` pelatih hanya jika terjadi salah satu dari *Trigger Event* berikut: (a) Member menekan "ACC Selesai", (b) Sistem *Auto-Complete* lewat dari 48 jam, atau (c) Admin memenangkan pelatih dalam forum Sengketa (*Dispute*).

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

## 🚀 Instalasi & Persiapan Data

```bash
# Clone repository
git clone https://github.com/asbimantara/mylora-gym-trainer.git
cd mylora-gym-trainer

# Install dependencies
composer install
npm install && npm run build

# Setup Environment
cp .env.example .env
php artisan key:generate

# Setup Database & Dummy Data
php artisan migrate --seed

# Create storage symlink
php artisan storage:link

# Run development server
php artisan serve
```

### 🔑 Data Akun Uji Coba (Demo)
Semua akun di bawah ini menggunakan *password* yang sama: **`password`**

- **Admin (Pemilik Sistem):** `admin@mylora.com`
- **Member (Klien):** `demo@mylora.com`
- **Coach Helmi (Weight Training):** `trainer1@mylora.com`
- **Coach Akbar (Functional):** `trainer2@mylora.com`
- **Coach Ega (Cardio & HIIT):** `trainer3@mylora.com`

*(Catatan: Anda juga dapat membaca panduan lengkap uji coba skenario pemesanan di file [jadwal_booking_coach.md](docs/jadwal_booking_coach.md))*

## 💰 Model Bisnis

Platform mengambil **biaya layanan 10%** yang dibebankan kepada member saat checkout. Trainer menerima **100% dari harga paket** yang mereka tetapkan, tanpa potongan saat penarikan dana.

## 👨‍💻 Tim Pengembang & Metodologi Agile

Proyek akademik ini dikembangkan secara tim menggunakan pendekatan **Agile Methodology** (kerangka kerja *Scrum/Iterative*). Model ini memungkinkan perangkat lunak dibangun secara cepat, adaptif terhadap perubahan, dan berorientasi penuh pada kebutuhan pengguna.

Siklus pengembangan (*Sprint*) dieksekusi melalui pembagian peran (*Role*) yang saling berkesinambungan:

1. **Siti Nur Ajinjah** (NIM: 231240001382)<br>
   *Systems Analyst & Product Owner* — Berperan di hulu siklus (*Planning*). Bertanggung jawab melakukan observasi lapangan di Jepara, mengumpulkan keluhan (*pain points*) pengguna, dan mendefinisikan *Requirement Engineering* (*Product Backlog*).
2. **Muhammad Farid** (NIM: 231240001383)<br>
   *Systems Architect & Scrum Master* — Berperan di fase manajerial dan perancangan (*Design*). Menyusun rancang bangun arsitektur sistem (UML/Alur), mengatur *timeline* tiap fase iterasi (*Sprint*), dan memastikan proyek berjalan sesuai kaidah Rekayasa Perangkat Lunak.
3. **Ahmad Surya Bimantara** (NIM: 231240001384)<br>
   *Lead Developer & Technical Implementation* — Berperan di fase eksekusi (*Coding & Testing*). Bertanggung jawab merealisasikan *Product Backlog* menjadi sistem aplikasi utuh secara *Full-Stack* (Front-End & Back-End) dan memastikan integrasi logika berjalan mulus pada setiap akhir iterasi.

- **Program Studi:** Teknik Informatika
- **Universitas:** Universitas Islam Nahdlatul Ulama Jepara
- **Mata Kuliah:** Gabungan E-Commerce & Rekayasa Perangkat Lunak
- **Dosen Pengampu:** TEGUH TAMRIN, S.Kom., M.Kom.

## 📄 Lisensi

Proyek ini dibuat secara khusus untuk memenuhi tugas gabungan mata kuliah di **Universitas Islam Nahdlatul Ulama Jepara**.

---

**© 2026 MyLoRa Gym Trainer** — All rights reserved.
