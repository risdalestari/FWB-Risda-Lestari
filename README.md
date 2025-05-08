## <p align="center" style="margin-top: 0;">SISTEM PENCARIAN LOWONGAN MAGANG UNTUK MAHASISWA</p>

<p align="center">
  <img src="/public/LogoUnsulbar.png" width="300" alt="LogoUnsulbar" />
</p>

### <p align="center">Risda Lestari</p>

### <p align="center">D022054</p></br>

### <p align="center">FRAMEWORK WEB BASED</p>

### <p align="center">2025</p>

## 🧑‍🤝‍🧑 Role dan Hak Akses

| Role         | Akses                                                                              |
|--------------|-----------------------------------------------------------------------------------|
| *Admin*      | Mengelola semua data (user, mahasiswa, perusahaan, lowongan magang), menambah/mengedit/menghapus data, melihat laporan, mengatur sistem |
| *Company*    | Membuat dan mengelola lowongan magang, melihat lamaran, mengubah status lamaran, mengelola profil perusahaan |
| *Student*    | Mencari lowongan magang, mengajukan lamaran, menyimpan lowongan favorit, mengelola profil dan dokumen |

---

## 🗃 Struktur Database

### 1. Tabel users (User Utama)

| Field               | Tipe Data        | Keterangan                                |
|---------------------|------------------|-------------------------------------------|
| id                  | bigint (PK)      | ID unik user                              |
| name                | varchar          | Nama lengkap                              |
| email               | varchar (unique) | Alamat email                              |
| password            | varchar          | Password terenkripsi                      |
| role                | enum             | student, company, admin                   |
| profile_picture     | varchar          | URL foto profil (nullable)                |
| email_verified_at   | timestamp        | Waktu verifikasi email                    |
| remember_token      | varchar          | Token untuk remember me                   |
| created_at          | timestamp        | Tanggal dibuat                            |
| updated_at          | timestamp        | Tanggal update                            |

### 2. Tabel students (Data Mahasiswa)

| Field           | Tipe Data   | Keterangan                     |
|-----------------|-------------|--------------------------------|
| id              | bigint (PK) | ID mahasiswa                   |
| user_id         | bigint (FK) | Relasi ke users                |
| nim             | varchar     | NIM mahasiswa (unique)         |
| university      | varchar     | Nama universitas               |
| faculty         | varchar     | Fakultas                       |
| study_program   | varchar     | Program studi                  |
| semester        | integer     | Semester saat ini              |
| skills          | text        | Daftar skill (nullable)        |
| portfolio_url   | text        | URL portfolio (nullable)       |
| cv_url          | text        | URL CV (nullable)              |
| created_at      | timestamp   | Tanggal dibuat                 |
| updated_at      | timestamp   | Tanggal update                 |

### 3. Tabel companies (Data Perusahaan)

| Field           | Tipe Data   | Keterangan                     |
|-----------------|-------------|--------------------------------|
| id              | bigint (PK) | ID perusahaan                  |
| user_id         | bigint (FK) | Relasi ke users                |
| company_name    | varchar     | Nama perusahaan                |
| industry        | varchar     | Industri perusahaan            |
| description     | text        | Deskripsi perusahaan           |
| website_url     | varchar     | URL website (nullable)         |
| logo_url        | varchar     | URL logo (nullable)            |
| address         | varchar     | Alamat perusahaan              |
| phone           | varchar     | Nomor telepon                  |
| created_at      | timestamp   | Tanggal dibuat                 |
| updated_at      | timestamp   | Tanggal update                 |

### 4. Tabel internships (Lowongan Magang)

| Field               | Tipe Data   | Keterangan                     |
|---------------------|-------------|--------------------------------|
| id                  | bigint (PK) | ID lowongan                    |
| company_id          | bigint (FK) | Relasi ke companies            |
| title               | varchar     | Judul lowongan                 |
| description         | text        | Deskripsi lengkap              |
| requirements        | text        | Persyaratan                    |
| benefits            | text        | Benefit magang (nullable)      |
| location            | varchar     | Lokasi magang                  |
| type                | enum        | onsite/remote/hybrid           |
| duration_unit       | enum        | week/month                     |
| duration_value      | integer     | Nilai durasi                   |
| start_date          | date        | Tanggal mulai                  |
| end_date            | date        | Tanggal selesai                |
| application_deadline| date        | Batas pendaftaran              |
| status              | enum        | open/closed                    |
| slot                | integer     | Jumlah kuota                   |
| created_at          | timestamp   | Tanggal dibuat                 |
| updated_at          | timestamp   | Tanggal update                 |

### 5. Tabel applications (Lamaran Magang)

| Field           | Tipe Data   | Keterangan                     |
|-----------------|-------------|--------------------------------|
| id              | bigint (PK) | ID lamaran                     |
| student_id      | bigint (FK) | Relasi ke students             |
| internship_id   | bigint (FK) | Relasi ke internships          |
| cover_letter    | text        | Surat lamaran (nullable)       |
| status          | enum        | Status lamaran                 |
| feedback        | text        | Feedback (nullable)            |
| created_at      | timestamp   | Tanggal dibuat                 |
| updated_at      | timestamp   | Tanggal update                 |

---

## 🔗 Relasi Antar Tabel

| Tabel Asal      | Tabel Tujuan     | Relasi          | Penjelasan                                  |
|-----------------|------------------|-----------------|----------------------------------------------|
| users           | students         | one-to-one      | Satu user student memiliki satu data student |
| users           | companies        | one-to-one      | Satu user company memiliki satu data company |
| companies       | internships      | one-to-many     | Satu perusahaan bisa memiliki banyak lowongan|
| students        | applications     | one-to-many     | Satu mahasiswa bisa melamar ke banyak lowongan|
| internships     | applications     | one-to-many     | Satu lowongan bisa menerima banyak lamaran  |
| students        | saved_internships| many-to-many    | Banyak mahasiswa bisa menyimpan banyak lowongan|

## 🛠 Cara Instalasi

1. Clone repository
2. Jalankan `composer install`
3. Buat file `.env` dan sesuaikan dengan konfigurasi database
4. Jalankan migrasi: `php artisan migrate`
5. Jalankan seeder (jika ada): `php artisan db:seed`
6. Jalankan server: `php artisan serve`