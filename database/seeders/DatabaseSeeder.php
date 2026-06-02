<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\TrainerProfile;
use App\Models\TrainerPackage;
use App\Models\TrainerAvailability;
use App\Models\PackagePurchase;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $categories = [
            ['name' => 'Weight Training', 'slug' => 'weight-training', 'description' => 'Latihan beban untuk membentuk dan memperkuat otot', 'icon' => '🏋️'],
            ['name' => 'Cardio & HIIT', 'slug' => 'cardio-hiit', 'description' => 'Latihan kardiovaskular dan High Intensity Interval Training', 'icon' => '🏃'],
            ['name' => 'Yoga & Flexibility', 'slug' => 'yoga-flexibility', 'description' => 'Latihan kelenturan, keseimbangan, dan mindfulness', 'icon' => '🧘'],
            ['name' => 'Functional Training', 'slug' => 'functional-training', 'description' => 'Latihan gerakan fungsional untuk aktivitas sehari-hari', 'icon' => '💪'],
            ['name' => 'Boxing & Martial Arts', 'slug' => 'boxing-martial-arts', 'description' => 'Latihan tinju dan bela diri untuk kebugaran', 'icon' => '🥊'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Admin
        User::create([
            'name' => 'Admin MyLoRa',
            'email' => 'admin@mylora.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);
        // Clean Demo Member Account (No active packages/bookings)
        User::create([
            'name' => 'Demo User',
            'email' => 'demo@mylora.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '08999999999',
        ]);

        // 15 Members for unique reviews (Normal Names), role is ghost so they don't show up in Admin Panel
        $m1 = User::create(['name' => 'Raka', 'email' => 'm1@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08111111111']);
        $m2 = User::create(['name' => 'Dinda', 'email' => 'm2@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08222222222']);
        $m3 = User::create(['name' => 'Alif Rahman', 'email' => 'm3@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08333333333']);
        $m4 = User::create(['name' => 'Nisa', 'email' => 'm4@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08444444444']);
        $m5 = User::create(['name' => 'Farhan', 'email' => 'm5@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08555555555']);
        $m6 = User::create(['name' => 'Fadhil', 'email' => 'm6@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08666666666']);
        $m7 = User::create(['name' => 'Maya', 'email' => 'm7@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08777777777']);
        $m8 = User::create(['name' => 'Rizky', 'email' => 'm8@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08888888888']);
        $m9 = User::create(['name' => 'Salsa', 'email' => 'm9@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08999999999']);
        $m10 = User::create(['name' => 'Bayu', 'email' => 'm10@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08101010101']);
        $m11 = User::create(['name' => 'Vira', 'email' => 'm11@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08112112112']);
        $m12 = User::create(['name' => 'Iqbal', 'email' => 'm12@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08123123123']);
        $m13 = User::create(['name' => 'Dina', 'email' => 'm13@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08134134134']);
        $m14 = User::create(['name' => 'Rio', 'email' => 'm14@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08145145145']);
        $m15 = User::create(['name' => 'Tiara', 'email' => 'm15@mylora.com', 'password' => Hash::make('password'), 'role' => 'ghost', 'phone' => '08156156156']);

        // === TRAINER 1: Coach Helmi (Champion Gym Jepara) ===
        // Termahal, sertifikasi Rai Institute
        $trainer1 = User::create([
            'name' => 'Coach Helmi',
            'email' => 'trainer1@mylora.com',
            'password' => Hash::make('password'),
            'role' => 'trainer',
            'phone' => '082241643580',
            'avatar' => 'helmi.png',
        ]);
        $profile1 = TrainerProfile::create([
            'user_id' => $trainer1->id,
            'category_id' => 1,
            'bio' => 'Certified personal trainer dengan pengalaman lebih dari 7 tahun. Spesialisasi dalam program bulking, cutting, dan strength training. Telah membantu ratusan klien mencapai target body goals mereka.',
            'specialization' => 'Weight Training & Bodybuilding',
            'experience_years' => 7,
            'price_per_session' => 250000,
            'session_duration' => 60,
            'location' => 'Kauman, Jepara',
            'gym_name' => 'Champion Gym Jepara',
            'certifications' => 'Rai Institute Certified Personal Trainer',
            'phone' => '082241643580',
            'is_approved' => true,
        ]);
        $benefits1 = 'Penyusunan jadwal latihan,Pemantauan body fat,Konsultasi pola diet makanan dll,Pengatasan kalau ada cidera';
        $pkgHelmi1 = TrainerPackage::create(['trainer_profile_id' => $profile1->id, 'name' => 'Single Session', 'session_count' => 1, 'validity_days' => 14, 'price' => 250000, 'description' => 'Sesi uji coba personal training.', 'benefits' => $benefits1, 'is_active' => true]);
        $pkgHelmi8 = TrainerPackage::create(['trainer_profile_id' => $profile1->id, 'name' => 'Paket 8 Sesi', 'session_count' => 8, 'validity_days' => 30, 'price' => 1200000, 'description' => 'Paket bulanan 2x seminggu.', 'benefits' => $benefits1, 'is_active' => true]);
        $pkgHelmi10 = TrainerPackage::create(['trainer_profile_id' => $profile1->id, 'name' => 'Paket 10 Sesi', 'session_count' => 10, 'validity_days' => 45, 'price' => 1400000, 'description' => 'Paket hemat 10 sesi.', 'benefits' => $benefits1, 'is_active' => true]);
        $pkgHelmi12 = TrainerPackage::create(['trainer_profile_id' => $profile1->id, 'name' => 'Paket 12 Sesi', 'session_count' => 12, 'validity_days' => 45, 'price' => 1500000, 'description' => 'Paket bulanan 3x seminggu.', 'benefits' => $benefits1, 'is_active' => true]);
        $pkgHelmi16 = TrainerPackage::create(['trainer_profile_id' => $profile1->id, 'name' => 'Paket 16 Sesi', 'session_count' => 16, 'validity_days' => 60, 'price' => 1850000, 'description' => 'Paket transformasi total.', 'benefits' => $benefits1, 'is_active' => true]);
        TrainerPackage::create(['trainer_profile_id' => $profile1->id, 'name' => 'Paket 20 Sesi', 'session_count' => 20, 'validity_days' => 60, 'price' => 2200000, 'description' => 'Paket dedikasi penuh.', 'benefits' => $benefits1, 'is_active' => true]);

        foreach ([1,2,3,4,5,6] as $day) {
            TrainerAvailability::create(['trainer_profile_id' => $profile1->id, 'day_of_week' => $day, 'start_hour' => '08:00', 'end_hour' => '21:00', 'is_available' => true]);
        }

        // === TRAINER 2: Coach Akbar (Sasana Gym Jepara) ===
        // Rate middle
        $trainer2 = User::create([
            'name' => 'Coach Akbar',
            'email' => 'trainer2@mylora.com',
            'password' => Hash::make('password'),
            'role' => 'trainer',
            'phone' => '08884022837',
            'avatar' => 'akbar.png',
        ]);
        $profile2 = TrainerProfile::create([
            'user_id' => $trainer2->id,
            'category_id' => 4,
            'bio' => 'Pelatih yang fokus pada functional training, calisthenic (bodyweight workout), dan perbaikan postur tubuh. Memanfaatkan fasilitas khusus calisthenic di Sasana Gym.',
            'specialization' => 'Functional Training & Calisthenic',
            'experience_years' => 2,
            'price_per_session' => 30000,
            'session_duration' => 60,
            'location' => 'Panggang, Jepara',
            'gym_name' => 'Sasana Gym Jepara',
            'certifications' => null,
            'phone' => '08884022837',
            'is_approved' => true,
        ]);
        $benefits2 = 'Penyusunan jadwal latihan,Pemantauan body fat,Konsultasi pola diet makanan';
        $pkgAkbar1 = TrainerPackage::create(['trainer_profile_id' => $profile2->id, 'name' => 'Single Session', 'session_count' => 1, 'validity_days' => 14, 'price' => 30000, 'benefits' => $benefits2, 'is_active' => true]);
        $pkgAkbar4 = TrainerPackage::create(['trainer_profile_id' => $profile2->id, 'name' => 'Paket 4 Sesi', 'session_count' => 4, 'validity_days' => 20, 'price' => 110000, 'benefits' => $benefits2, 'is_active' => true]);
        $pkgAkbar8 = TrainerPackage::create(['trainer_profile_id' => $profile2->id, 'name' => 'Paket 8 Sesi', 'session_count' => 8, 'validity_days' => 30, 'price' => 200000, 'benefits' => $benefits2, 'is_active' => true]);
        $pkgAkbar12 = TrainerPackage::create(['trainer_profile_id' => $profile2->id, 'name' => 'Paket 12 Sesi', 'session_count' => 12, 'validity_days' => 45, 'price' => 280000, 'benefits' => $benefits2, 'is_active' => true]);
        $pkgAkbar16 = TrainerPackage::create(['trainer_profile_id' => $profile2->id, 'name' => 'Paket 16 Sesi', 'session_count' => 16, 'validity_days' => 60, 'price' => 350000, 'benefits' => $benefits2, 'is_active' => true]);

        foreach ([1,2,3,4,5,6] as $day) {
            TrainerAvailability::create(['trainer_profile_id' => $profile2->id, 'day_of_week' => $day, 'start_hour' => '07:00', 'end_hour' => '20:00', 'is_available' => true]);
        }

        // === TRAINER 3: Coach Ega (Osman 2 Gym Jepara) ===
        // Murah
        $trainer3 = User::create([
            'name' => 'Coach Ega',
            'email' => 'trainer3@mylora.com',
            'password' => Hash::make('password'),
            'role' => 'trainer',
            'phone' => '08976965272',
            'avatar' => 'ega.png',
        ]);
        $profile3 = TrainerProfile::create([
            'user_id' => $trainer3->id,
            'category_id' => 2,
            'bio' => 'Pelatih muda yang energik. Spesialisasi dalam Cardio & HIIT untuk fat loss yang cepat dan efektif. Harga terjangkau untuk mahasiswa.',
            'specialization' => 'Cardio & HIIT',
            'experience_years' => 4,
            'price_per_session' => 50000,
            'session_duration' => 60,
            'location' => 'Ujungbatu, Jepara',
            'gym_name' => 'Osman 2 Gym Jepara',
            'certifications' => null,
            'phone' => '08976965272',
            'is_approved' => true,
        ]);
        $benefits3 = 'Penyusunan jadwal latihan,Konsultasi pola diet makanan';
        $pkgEga1 = TrainerPackage::create(['trainer_profile_id' => $profile3->id, 'name' => 'Single Session', 'session_count' => 1, 'validity_days' => 14, 'price' => 50000, 'benefits' => $benefits3, 'is_active' => true]);
        $pkgEga4 = TrainerPackage::create(['trainer_profile_id' => $profile3->id, 'name' => 'Paket 4 Sesi', 'session_count' => 4, 'validity_days' => 20, 'price' => 180000, 'benefits' => $benefits3, 'is_active' => true]);
        $pkgEga8 = TrainerPackage::create(['trainer_profile_id' => $profile3->id, 'name' => 'Paket 8 Sesi', 'session_count' => 8, 'validity_days' => 30, 'price' => 350000, 'benefits' => $benefits3, 'is_active' => true]);
        $pkgEga12 = TrainerPackage::create(['trainer_profile_id' => $profile3->id, 'name' => 'Paket 12 Sesi', 'session_count' => 12, 'validity_days' => 45, 'price' => 500000, 'benefits' => $benefits3, 'is_active' => true]);
        $pkgEga16 = TrainerPackage::create(['trainer_profile_id' => $profile3->id, 'name' => 'Paket 16 Sesi', 'session_count' => 16, 'validity_days' => 60, 'price' => 650000, 'benefits' => $benefits3, 'is_active' => true]);

        foreach ([1,2,3,4,5,6] as $day) {
            TrainerAvailability::create(['trainer_profile_id' => $profile3->id, 'day_of_week' => $day, 'start_hour' => '08:00', 'end_hour' => '22:00', 'is_available' => true]);
        }

        // === DUMMY TRANSACTIONS & BOOKINGS & REVIEWS ===
        
        // Helper function for dummy data
        $createDummyFlow = function($member, $profile, $pkg, $rating, $comment, $dateStr) {
            $reviewDate = Carbon::parse($dateStr);
            $purchase = PackagePurchase::create([
                'user_id' => $member->id,
                'trainer_package_id' => $pkg->id,
                'trainer_profile_id' => $profile->id,
                'sessions_total' => 1,
                'sessions_used' => 1,
                'status' => 'completed',
                'created_at' => $reviewDate->copy()->subDays(3),
                'updated_at' => $reviewDate->copy()->subDays(3),
            ]);
            Transaction::create([
                'package_purchase_id' => $purchase->id,
                'user_id' => $member->id,
                'amount' => $pkg->price,
                'platform_fee' => $pkg->price * 0.1,
                'status' => 'success',
                'midtrans_order_id' => 'MYLORA-' . strtoupper(uniqid()),
                'paid_at' => $reviewDate->copy()->subDays(3),
                'created_at' => $reviewDate->copy()->subDays(3),
                'updated_at' => $reviewDate->copy()->subDays(3),
            ]);
            $booking = Booking::create([
                'user_id' => $member->id,
                'trainer_profile_id' => $profile->id,
                'package_purchase_id' => $purchase->id,
                'session_date' => $reviewDate->copy()->subDays(1)->format('Y-m-d'),
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'status' => 'completed',
                'created_at' => $reviewDate->copy()->subDays(2),
                'updated_at' => $reviewDate->copy()->subDays(1),
            ]);
            Review::insert([
                'user_id' => $member->id,
                'trainer_profile_id' => $profile->id,
                'booking_id' => $booking->id,
                'rating' => $rating,
                'comment' => $comment,
                'created_at' => $reviewDate,
                'updated_at' => $reviewDate,
            ]);
        };
        $createMultiSessionFlow = function($member, $profile, $pkg, $rating, $comment, $sessions) {
            $purchaseDate = Carbon::parse($sessions[0]['date'])->subDays(2);
            $purchase = PackagePurchase::create([
                'user_id' => $member->id,
                'trainer_package_id' => $pkg->id,
                'trainer_profile_id' => $profile->id,
                'sessions_total' => $pkg->session_count,
                'sessions_used' => count($sessions),
                'status' => count($sessions) >= $pkg->session_count ? 'completed' : 'active',
                'created_at' => $purchaseDate,
                'updated_at' => $purchaseDate,
            ]);
            Transaction::create([
                'package_purchase_id' => $purchase->id,
                'user_id' => $member->id,
                'amount' => $pkg->price,
                'platform_fee' => $pkg->price * 0.1,
                'status' => 'success',
                'midtrans_order_id' => 'MYLORA-MULTI-' . strtoupper(uniqid()),
                'paid_at' => $purchaseDate,
                'created_at' => $purchaseDate,
                'updated_at' => $purchaseDate,
            ]);
            
            $lastBooking = null;
            foreach ($sessions as $i => $sess) {
                // Determine status based on whether the session date is in the past or future relative to 'now'
                $sessionDateObj = Carbon::parse($sess['date'] . ' ' . $sess['time']);
                $status = $sessionDateObj->isPast() ? 'completed' : 'confirmed';
                
                $lastBooking = Booking::create([
                    'user_id' => $member->id,
                    'trainer_profile_id' => $profile->id,
                    'package_purchase_id' => $purchase->id,
                    'session_date' => $sess['date'],
                    'start_time' => $sess['time'],
                    'end_time' => Carbon::parse($sess['time'])->addMinutes($profile->session_duration)->format('H:i:s'),
                    'status' => $status,
                    'created_at' => $purchaseDate->copy()->addDays($i),
                    'updated_at' => $purchaseDate->copy()->addDays($i),
                ]);
            }
            
            if ($rating && $comment && $lastBooking) {
                Review::insert([
                    'user_id' => $member->id,
                    'trainer_profile_id' => $profile->id,
                    'booking_id' => $lastBooking->id,
                    'rating' => $rating,
                    'comment' => $comment,
                    'created_at' => Carbon::parse($lastBooking->session_date)->addDays(1),
                    'updated_at' => Carbon::parse($lastBooking->session_date)->addDays(1),
                ]);
            }
        };

        // Coach Helmi 5 Active Members Scenarios
        // m1 (Raka): Paket 8 Sesi. Jam selalu sama (10:00), hari bervariasi.
        $createMultiSessionFlow($m1, $profile1, $pkgHelmi8, 5, 'Jadwal fleksibel banget, materi dapet semua.', [
            ['date' => '2026-05-27', 'time' => '10:00:00'],
            ['date' => '2026-05-30', 'time' => '10:00:00'],
            ['date' => '2026-06-02', 'time' => '10:00:00'], // Demo Slot
            ['date' => '2026-06-05', 'time' => '10:00:00'],
            ['date' => '2026-06-09', 'time' => '10:00:00'],
            ['date' => '2026-06-12', 'time' => '10:00:00'],
            ['date' => '2026-06-16', 'time' => '10:00:00'],
            ['date' => '2026-06-19', 'time' => '10:00:00'],
        ]);

        // m2 (Dinda): Paket 10 Sesi. Rutin tiap Selasa & Jumat jam 16:00.
        $createMultiSessionFlow($m2, $profile1, $pkgHelmi10, 5, 'Rutin latihan sore sepulang kerja, badan makin bugar!', [
            ['date' => '2026-05-19', 'time' => '16:00:00'],
            ['date' => '2026-05-22', 'time' => '16:00:00'],
            ['date' => '2026-05-26', 'time' => '16:00:00'],
            ['date' => '2026-05-29', 'time' => '16:00:00'],
            ['date' => '2026-06-02', 'time' => '16:00:00'], // Demo Slot
            ['date' => '2026-06-05', 'time' => '16:00:00'],
            ['date' => '2026-06-09', 'time' => '16:00:00'],
            ['date' => '2026-06-12', 'time' => '16:00:00'],
            ['date' => '2026-06-16', 'time' => '16:00:00'],
            ['date' => '2026-06-19', 'time' => '16:00:00'],
        ]);

        // m3 (Alif): Paket 12 Sesi. Pagi hari (08:00) 3x seminggu.
        $createMultiSessionFlow($m3, $profile1, $pkgHelmi12, 5, 'Program 12 sesi beneran ngubah pola hidup saya dari pagi.', [
            ['date' => '2026-05-20', 'time' => '08:00:00'],
            ['date' => '2026-05-23', 'time' => '08:00:00'],
            ['date' => '2026-05-25', 'time' => '08:00:00'],
            ['date' => '2026-05-27', 'time' => '08:00:00'],
            ['date' => '2026-05-30', 'time' => '08:00:00'],
            ['date' => '2026-06-01', 'time' => '08:00:00'],
            ['date' => '2026-06-03', 'time' => '08:00:00'],
            ['date' => '2026-06-06', 'time' => '08:00:00'],
            ['date' => '2026-06-08', 'time' => '08:00:00'],
            ['date' => '2026-06-10', 'time' => '08:00:00'],
            ['date' => '2026-06-13', 'time' => '08:00:00'],
            ['date' => '2026-06-15', 'time' => '08:00:00'],
        ]);

        // m4 (Nisa): Paket 8 Sesi. Jam dan hari sangat acak (Sore/Malam).
        $createMultiSessionFlow($m4, $profile1, $pkgHelmi8, 4, 'Bisa disesuaikan dengan jadwal shift kerja yang ga menentu.', [
            ['date' => '2026-05-21', 'time' => '18:00:00'],
            ['date' => '2026-05-25', 'time' => '19:00:00'],
            ['date' => '2026-05-29', 'time' => '17:00:00'],
            ['date' => '2026-06-02', 'time' => '19:00:00'], // Demo Slot
            ['date' => '2026-06-06', 'time' => '18:00:00'],
            ['date' => '2026-06-09', 'time' => '19:00:00'],
            ['date' => '2026-06-13', 'time' => '17:00:00'],
            ['date' => '2026-06-17', 'time' => '18:00:00'],
        ]);

        // m5 (Farhan): Paket 16 Sesi. Intensif 4x seminggu di jam 14:00.
        $createMultiSessionFlow($m5, $profile1, $pkgHelmi16, 5, 'Paket 16 sesi benar-benar transformasi total, dilatih intensif.', [
            ['date' => '2026-05-18', 'time' => '14:00:00'],
            ['date' => '2026-05-19', 'time' => '14:00:00'],
            ['date' => '2026-05-21', 'time' => '14:00:00'],
            ['date' => '2026-05-22', 'time' => '14:00:00'],
            ['date' => '2026-05-25', 'time' => '14:00:00'],
            ['date' => '2026-05-26', 'time' => '14:00:00'],
            ['date' => '2026-05-28', 'time' => '14:00:00'],
            ['date' => '2026-05-29', 'time' => '14:00:00'],
            ['date' => '2026-06-01', 'time' => '14:00:00'],
            ['date' => '2026-06-02', 'time' => '14:00:00'], // Demo Slot
            ['date' => '2026-06-04', 'time' => '14:00:00'],
            ['date' => '2026-06-05', 'time' => '14:00:00'],
            ['date' => '2026-06-08', 'time' => '14:00:00'],
            ['date' => '2026-06-09', 'time' => '14:00:00'],
            ['date' => '2026-06-11', 'time' => '14:00:00'],
            ['date' => '2026-06-12', 'time' => '14:00:00'],
        ]);

        // Coach Akbar 5 Active Members Scenarios
        // m6 (Fadhil): Paket 8 Sesi. Jam selalu sama (08:00).
        $createMultiSessionFlow($m6, $profile2, $pkgAkbar8, 5, 'Latihan pagi bikin seger seharian, postur makin bagus!', [
            ['date' => '2026-05-27', 'time' => '08:00:00'],
            ['date' => '2026-05-30', 'time' => '08:00:00'],
            ['date' => '2026-06-02', 'time' => '08:00:00'], // Demo Slot
            ['date' => '2026-06-05', 'time' => '08:00:00'],
            ['date' => '2026-06-09', 'time' => '08:00:00'],
            ['date' => '2026-06-12', 'time' => '08:00:00'],
            ['date' => '2026-06-16', 'time' => '08:00:00'],
            ['date' => '2026-06-19', 'time' => '08:00:00'],
        ]);

        // m7 (Maya): Paket 8 Sesi. Rutin tiap Senin & Rabu jam 16:00.
        $createMultiSessionFlow($m7, $profile2, $pkgAkbar8, 5, 'Latihan sore sepulang kerja, asik banget.', [
            ['date' => '2026-05-18', 'time' => '16:00:00'],
            ['date' => '2026-05-20', 'time' => '16:00:00'],
            ['date' => '2026-05-25', 'time' => '16:00:00'],
            ['date' => '2026-05-27', 'time' => '16:00:00'],
            ['date' => '2026-06-01', 'time' => '16:00:00'],
            ['date' => '2026-06-03', 'time' => '16:00:00'],
            ['date' => '2026-06-08', 'time' => '16:00:00'],
            ['date' => '2026-06-10', 'time' => '16:00:00'],
        ]);

        // m8 (Rizky): Paket 12 Sesi. Tiap Selasa, Kamis, Sabtu jam 19:00.
        $createMultiSessionFlow($m8, $profile2, $pkgAkbar12, 5, 'Capek tapi nagih, pelatihnya asik parah.', [
            ['date' => '2026-05-19', 'time' => '19:00:00'],
            ['date' => '2026-05-21', 'time' => '19:00:00'],
            ['date' => '2026-05-23', 'time' => '19:00:00'],
            ['date' => '2026-05-26', 'time' => '19:00:00'],
            ['date' => '2026-05-28', 'time' => '19:00:00'],
            ['date' => '2026-05-30', 'time' => '19:00:00'],
            ['date' => '2026-06-02', 'time' => '19:00:00'], // Demo Slot
            ['date' => '2026-06-04', 'time' => '19:00:00'],
            ['date' => '2026-06-06', 'time' => '19:00:00'],
            ['date' => '2026-06-09', 'time' => '19:00:00'],
            ['date' => '2026-06-11', 'time' => '19:00:00'],
            ['date' => '2026-06-13', 'time' => '19:00:00'],
        ]);

        // m9 (Salsa): Paket 8 Sesi. Jam dan hari sangat acak.
        $createMultiSessionFlow($m9, $profile2, $pkgAkbar8, 4, 'Bisa nyesuain jadwal, calisthenic seru.', [
            ['date' => '2026-05-21', 'time' => '18:00:00'],
            ['date' => '2026-05-25', 'time' => '19:00:00'],
            ['date' => '2026-05-29', 'time' => '17:00:00'],
            ['date' => '2026-06-02', 'time' => '16:00:00'], // Demo Slot
            ['date' => '2026-06-06', 'time' => '18:00:00'],
            ['date' => '2026-06-09', 'time' => '19:00:00'],
            ['date' => '2026-06-13', 'time' => '17:00:00'],
            ['date' => '2026-06-17', 'time' => '18:00:00'],
        ]);

        // m10 (Bayu): Paket 16 Sesi. Intensif 4x seminggu di jam 14:00.
        $createMultiSessionFlow($m10, $profile2, $pkgAkbar16, 5, 'Intensif calisthenic bikin badan kuat banget.', [
            ['date' => '2026-05-18', 'time' => '14:00:00'],
            ['date' => '2026-05-19', 'time' => '14:00:00'],
            ['date' => '2026-05-21', 'time' => '14:00:00'],
            ['date' => '2026-05-22', 'time' => '14:00:00'],
            ['date' => '2026-05-25', 'time' => '14:00:00'],
            ['date' => '2026-05-26', 'time' => '14:00:00'],
            ['date' => '2026-05-28', 'time' => '14:00:00'],
            ['date' => '2026-05-29', 'time' => '14:00:00'],
            ['date' => '2026-06-01', 'time' => '14:00:00'],
            ['date' => '2026-06-02', 'time' => '14:00:00'], // Demo Slot
            ['date' => '2026-06-04', 'time' => '14:00:00'],
            ['date' => '2026-06-05', 'time' => '14:00:00'],
            ['date' => '2026-06-08', 'time' => '14:00:00'],
            ['date' => '2026-06-09', 'time' => '14:00:00'],
            ['date' => '2026-06-11', 'time' => '14:00:00'],
            ['date' => '2026-06-12', 'time' => '14:00:00'],
        ]);

        // Coach Ega 5 Active Members Scenarios
        // m11 (Vira): Paket 8 Sesi. Jam selalu sama (08:00).
        $createMultiSessionFlow($m11, $profile3, $pkgEga8, 5, 'Latihan pagi bikin seger seharian, Cardio mantap!', [
            ['date' => '2026-05-27', 'time' => '08:00:00'],
            ['date' => '2026-05-30', 'time' => '08:00:00'],
            ['date' => '2026-06-02', 'time' => '08:00:00'], // Demo Slot
            ['date' => '2026-06-05', 'time' => '08:00:00'],
            ['date' => '2026-06-09', 'time' => '08:00:00'],
            ['date' => '2026-06-12', 'time' => '08:00:00'],
            ['date' => '2026-06-16', 'time' => '08:00:00'],
            ['date' => '2026-06-19', 'time' => '08:00:00'],
        ]);

        // m12 (Iqbal): Paket 8 Sesi. Rutin tiap Senin & Rabu jam 16:00.
        $createMultiSessionFlow($m12, $profile3, $pkgEga8, 5, 'Cardio sore sebelum pulang, asik banget.', [
            ['date' => '2026-05-18', 'time' => '16:00:00'],
            ['date' => '2026-05-20', 'time' => '16:00:00'],
            ['date' => '2026-05-25', 'time' => '16:00:00'],
            ['date' => '2026-05-27', 'time' => '16:00:00'],
            ['date' => '2026-06-01', 'time' => '16:00:00'],
            ['date' => '2026-06-03', 'time' => '16:00:00'],
            ['date' => '2026-06-08', 'time' => '16:00:00'],
            ['date' => '2026-06-10', 'time' => '16:00:00'],
        ]);

        // m13 (Dina): Paket 12 Sesi. Tiap Selasa, Kamis, Sabtu jam 19:00.
        $createMultiSessionFlow($m13, $profile3, $pkgEga12, 5, 'Capek tapi nagih, pelatihnya asik.', [
            ['date' => '2026-05-19', 'time' => '19:00:00'],
            ['date' => '2026-05-21', 'time' => '19:00:00'],
            ['date' => '2026-05-23', 'time' => '19:00:00'],
            ['date' => '2026-05-26', 'time' => '19:00:00'],
            ['date' => '2026-05-28', 'time' => '19:00:00'],
            ['date' => '2026-05-30', 'time' => '19:00:00'],
            ['date' => '2026-06-02', 'time' => '19:00:00'], // Demo Slot
            ['date' => '2026-06-04', 'time' => '19:00:00'],
            ['date' => '2026-06-06', 'time' => '19:00:00'],
            ['date' => '2026-06-09', 'time' => '19:00:00'],
            ['date' => '2026-06-11', 'time' => '19:00:00'],
            ['date' => '2026-06-13', 'time' => '19:00:00'],
        ]);

        // m14 (Rio): Paket 8 Sesi. Jam dan hari sangat acak.
        $createMultiSessionFlow($m14, $profile3, $pkgEga8, 4, 'Bisa nyesuain jadwal kuliah, mantap coach!', [
            ['date' => '2026-05-21', 'time' => '18:00:00'],
            ['date' => '2026-05-25', 'time' => '19:00:00'],
            ['date' => '2026-05-29', 'time' => '17:00:00'],
            ['date' => '2026-06-02', 'time' => '16:00:00'], // Demo Slot
            ['date' => '2026-06-06', 'time' => '18:00:00'],
            ['date' => '2026-06-09', 'time' => '19:00:00'],
            ['date' => '2026-06-13', 'time' => '17:00:00'],
            ['date' => '2026-06-17', 'time' => '18:00:00'],
        ]);

        // m15 (Tiara): Paket 16 Sesi. Intensif 4x seminggu di jam 14:00.
        $createMultiSessionFlow($m15, $profile3, $pkgEga16, 5, 'Paket 16 sesi benar-benar terasa perubahannya.', [
            ['date' => '2026-05-18', 'time' => '14:00:00'],
            ['date' => '2026-05-19', 'time' => '14:00:00'],
            ['date' => '2026-05-21', 'time' => '14:00:00'],
            ['date' => '2026-05-22', 'time' => '14:00:00'],
            ['date' => '2026-05-25', 'time' => '14:00:00'],
            ['date' => '2026-05-26', 'time' => '14:00:00'],
            ['date' => '2026-05-28', 'time' => '14:00:00'],
            ['date' => '2026-05-29', 'time' => '14:00:00'],
            ['date' => '2026-06-01', 'time' => '14:00:00'],
            ['date' => '2026-06-02', 'time' => '14:00:00'], // Demo Slot
            ['date' => '2026-06-04', 'time' => '14:00:00'],
            ['date' => '2026-06-05', 'time' => '14:00:00'],
            ['date' => '2026-06-08', 'time' => '14:00:00'],
            ['date' => '2026-06-09', 'time' => '14:00:00'],
            ['date' => '2026-06-11', 'time' => '14:00:00'],
            ['date' => '2026-06-12', 'time' => '14:00:00'],
        ]);

    }
}
