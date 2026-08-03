# Jarviscamp Praktikum 2026 - Web Developer

Repository ini berisi kumpulan tugas praktikum dan proyek dari bootcamp **Jarviscamp Web Developer 2026**. Proyek utama yang dibangun adalah aplikasi manajemen komik berbasis Laravel.

## Deskripsi Proyek

Proyek ini dibangun menggunakan framework Laravel dan akan terus berkembang seiring dengan materi bootcamp tiap minggunya. Beberapa fitur awal mencakup manajemen entitas seperti Kategori dan Komik.

## Persyaratan (Requirements)

- PHP >= 8.2
- Composer
- MySQL / MariaDB atau database lain yang didukung Laravel
- Node.js & NPM

## Cara Menjalankan Proyek Secara Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di mesin lokal Anda:

1. **Clone repository ini**

    ```bash
    git clone https://github.com/Febrian1202/jarviscamp-praktikum-2026.git
    cd jarviscamp-praktikum-2026
    ```

2. **Install dependency PHP (Composer)**

    ```bash
    composer install
    ```

3. **Install dependency frontend (NPM)**

    ```bash
    npm install
    npm run build
    ```

4. **Siapkan Environment Variables**
   Salin file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

    Lalu buka file `.env` dan sesuaikan konfigurasi database (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

5. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

6. **Jalankan Migrasi dan Seeder**
   Untuk membuat tabel database beserta data dummy (Kategori, Komik, dll):

    ```bash
    php artisan migrate:fresh --seed
    ```

7. **Jalankan Server Development**
    ```bash
    php artisan serve
    ```
    Aplikasi dapat diakses di `http://localhost:8000`.

## Progres Mingguan

- **Inisialisasi Awal**: Setup Laravel, model, migration, factory, dan seeder untuk `Kategori` dan `Komik`.
- **Week 2**: Migration, Factory & Seeder.
- **Week 3**: Controller, Route, dan CRUD untuk `Kategori`, `Komik`, dan `Anggota`.
- **Week 4**: Form Request, API Resource, dan Custom Exception Handling untuk `Anggota`.
- _(Akan diupdate seiring berjalannya praktikum)_

## Dokumentasi & Hasil Tugas (Kriteria Penilaian)

Bagian ini berisi tangkapan layar (screenshot) sebagai bukti penyelesaian tugas mingguan.

### Week 2: Migration, Factory & Seeder (Tabel Anggota)

- **Hasil Artisan**
      <!-- Ganti link gambar di bawah dengan path gambar screenshot Anda -->
    ![Hasil Artisan](.github/docs/artisan.png)
- **Hasil Migration:**
      <!-- Ganti link gambar di bawah dengan path gambar screenshot Anda -->

    ![Hasil Migration](.github/docs/migration.png)

- **Hasil Database:**
      <!-- Ganti link gambar di bawah dengan path gambar screenshot Anda -->
    ![Hasil Database](.github/docs/db.png)

### Week 3: Controller, Route, dan CRUD untuk Anggota

- **Hasil Unit Test**
  ![Hasil Unit Test](.github/docs/unit-test.png)
- **Hasil Artisan Route List:**
  ![Hasil Artisan Route List](.github/docs/route-list.png)
- **Hasil Test Api (index anggota):**
  ![Hasil Index Anggota](.github/docs/anggota-index.png)
- **Hasil Test Api (show anggota):**
  ![Hasil Show Anggota](.github/docs/anggota-show.png)
- **Hasil Test Api (store anggota):**
  ![Hasil Store Anggota](.github/docs/anggota-store.png)
- **Hasil Test Api (update anggota):**
  ![Hasil Update Anggota](.github/docs/anggota-update.png)
- **Hasil Test Api (destroy anggota):**
  ![Hasil Destroy Anggota](.github/docs/anggota-destroy.png)

### Week 4: Form Request, API Resource, dan Custom Exception Handling

- **Hasil Test Validasi Gagal (422 Unprocessable Entity):**
  ![Hasil Validasi Gagal 422](.github/docs/422.png)
- **Hasil Test Store Sukses dengan API Resource:**
  ![Hasil Store Sukses](.github/docs/store-success.png)
- **Hasil Test Custom Exception Handling (404 Not Found):**
  ![Hasil Exception 404](.github/docs/404.png)

## Lisensi

Proyek ini adalah bagian dari pembelajaran di Jarviscamp dan bersifat _open-source_ di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).
