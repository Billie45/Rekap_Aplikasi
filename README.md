# 📋 Rekap Aplikasi

Sistem manajemen rekapitulasi aplikasi berbasis Laravel, digunakan oleh berbagai role pengguna (`admin`, `opd`, dan `user`) untuk mencatat, mengelola, dan memverifikasi informasi aplikasi dari proses assessment hingga selesai.

---

## 🧭 Alur Kerja Pengguna

### 👨‍💼 Admin

1. **Login ke sistem sebagai admin.**
2. **Melihat daftar aplikasi** yang telah diajukan oleh OPD.
3. **Memverifikasi pengajuan assessment**:
   - Meninjau detail aplikasi.
   - Menyetujui atau menolak pengajuan.
4. **Membuat undangan meeting**:
   - Membuat link Zoom meeting.
   - Menentukan waktu pelaksanaan Zoom meeting.
5. **Melakukan penilaian assessment**:
   - Menyetujui, meminta perbaikan, atau menolak hasil assessment.
6. **Melakukan perubahan data** jika diperlukan melalui form edit.
7. **Menutup akses server** jika aplikasi dinyatakan selesai (opsional).

---

### 🏢 OPD

1. **Login ke sistem sebagai OPD.**
2. **Melihat daftar aplikasi** milik instansinya.
3. **Mengajukan aplikasi baru untuk assessment**:
   - Menyimpan data aplikasi.
4. **Melihat status pengajuan** (menunggu verifikasi admin).
5. **Melakukan perbaikan assessment** terhadap data aplikasi.
6. **Melihat hasil verifikasi** dan menindaklanjuti jika disetujui.

---

## 📦 Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/username/rekap-aplikasi.git
   cd rekap-aplikasi
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Copy environment file dan generate key**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Atur database di file `.env`**
   ```env
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Migrasi dan seeding**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

---
