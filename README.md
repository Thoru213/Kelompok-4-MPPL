# Kelompok-4-MPPL
Forum Diskusi Pembuatan Aplikasi Sederhana Untuk Toko Bahan Bangunan "Go-Block"

Anggota tim:

Anggraini Wijayanti    |   23106050010

Herdin Thorik N        |   23106050060

Djanu Akbar S          |   23106050062

Ryocera Purna K        |   23106050086








# Panduan Setup Proyek GO-BLOCK

Berikut adalah langkah-langkah yang diperlukan untuk menginstal dan menjalankan proyek GO-BLOCK.

---

**1. Meng-Clone Repositori**
   Clone proyek dari GitHub dan masuk ke direktori proyek.
   
   *git clone [URL_REPOSITORI_ANDA]*

---

**2. Menginstal Dependensi PHP (Composer)**
   Instal semua dependensi backend yang terdaftar di composer.json.
   
   *composer install*

---

**3. Mengatur File Environment (.env)**
   Salin file .env.example dan atur konfigurasi dasar aplikasi dan database.
   
   copy *.env.example* ke *.env*

   *php artisan key:generate*

   *Buka file .env dan sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD dengan konfigurasi MySQL lokal Anda.*

---

**4. Mengatur Database**
   Buat database MySQL dan jalankan migrasi untuk membuat tabel-tabel proyek.
   
   Buat database MySQL secara manual *(misal: goblock_db)*

   *php artisan migrate*
   **Untuk reset dan seed data awal: *php artisan migrate:fresh --seed***

---

**5. Menginstal npm**
   Instal semua dependensi frontend yang terdaftar di package.json (Vite, Tailwind CSS, dll.).
   
   *npm install*

---

**6. Menghubungkan Folder Penyimpanan Publik (Opsional)**
   Buat symlink untuk akses publik ke folder penyimpanan file yang diunggah.
   
   *php artisan storage:link*
