# 🚀 SIPPIU
## Sistem Informasi Peer-to-Peer Investasi UMKM

Prototype aplikasi web berbasis PHP Native yang dikembangkan sebagai media penghubung antara **Investor** dan **Pelaku UMKM (Borrower)** dalam proses pendanaan usaha secara digital dengan mekanisme Peer-to-Peer (P2P) Lending.

---

## 📖 Deskripsi

SIPPIU (Sistem Informasi Peer-to-Peer Investasi UMKM) merupakan prototype platform pendanaan digital yang mempertemukan investor dengan pelaku UMKM.

Melalui aplikasi ini, pelaku UMKM dapat mengajukan pinjaman usaha, sedangkan investor dapat memilih proposal yang ingin didanai. Sistem juga menyediakan proses credit scoring, pencairan dana, pembayaran cicilan, wallet digital, serta riwayat transaksi.

Prototype ini dikembangkan sebagai tugas mata kuliah Rekayasa Perangkat Lunak Universitas Dian Nusantara.

---

# ✨ Fitur

## 👨‍💼 Admin

- Login
- Dashboard Admin
- Review Proposal Pinjaman
- Detail Proposal
- Credit Scoring
- Persetujuan Proposal
- Penolakan Proposal
- Pencairan Dana

---

## 👤 Borrower

- Register
- Login
- Dashboard
- Kelola Profil
- Ajukan Pinjaman
- Melihat Status Pinjaman
- Melihat Jadwal Cicilan
- Konfirmasi Pembayaran Cicilan
- Riwayat Transaksi

---

## 💰 Investor

- Register
- Login
- Dashboard
- Kelola Profil
- Top Up Wallet
- Melihat Proposal Pendanaan
- Pendanaan Proposal
- Riwayat Investasi

---

## 💳 Wallet

- Top Up Saldo
- Pemotongan Saldo Otomatis
- Distribusi Dana Investor
- Riwayat Transaksi

---

# 🏗 Arsitektur

Aplikasi dikembangkan menggunakan pola arsitektur

MVC (Model View Controller)

```
Controller
│
├── Authentication
├── Loan
├── Investment
├── Wallet
├── Profile
├── Credit Score
└── Disbursement

↓

Model

↓

Database

↓

View
```

---

# 💻 Teknologi

| Teknologi | Keterangan |
|------------|------------|
| PHP Native | Backend |
| Bootstrap 5 | User Interface |
| HTML5 | Frontend |
| CSS3 | Styling |
| JavaScript | Interaksi |
| MySQL / MariaDB | Database |
| XAMPP | Web Server |
| Git & GitHub | Version Control |

---

# 📂 Struktur Folder

```
SIPPIU/
│
├── admin/
├── borrower/
├── investor/
│
├── assets/
│   ├── css/
│   └── images/
│
├── config/
├── controllers/
├── includes/
├── models/
├── uploads/
│
├── login.php
├── register.php
├── profile.php
├── logout.php
│
├── database.sql
├── README.md
└── .gitignore
```

---

# ⚙ Persyaratan Sistem

Minimal spesifikasi:

- PHP 8.x
- Apache Web Server
- MySQL / MariaDB
- XAMPP
- Browser Modern
  - Google Chrome
  - Microsoft Edge
  - Mozilla Firefox

---

# 🔧 Cara Instalasi

## 1 Clone Repository

```bash
git clone https://github.com/username/SIPPIU.git
```

atau download ZIP.

---

## 2 Pindahkan Project

Salin folder project ke

```
xampp/htdocs/
```

---

## 3 Buat Database

Buka

```
http://localhost/phpmyadmin
```

buat database

```
sippiu
```

---

## 4 Import Database

Import file

```
database.sql
```

---

## 5 Jalankan Server

Aktifkan

- Apache
- MySQL

melalui XAMPP.

---

## 6 Buka Aplikasi

```
http://localhost/SIPPIU
```

atau

```
http://localhost/P2P-Lending-UMKM
```

(sesuaikan nama folder project)

---

# 👥 Role Pengguna

## Admin

- Melakukan review proposal
- Melakukan credit scoring
- Menyetujui proposal
- Menolak proposal
- Mencairkan dana

---

## Borrower

- Mengajukan pinjaman
- Membayar cicilan
- Mengelola profil

---

## Investor

- Top Up Wallet
- Memilih proposal
- Memberikan pendanaan
- Melihat investasi

---

# 📊 Modul yang Diimplementasikan

- Authentication
- Profile Management
- Wallet
- Transaction
- Loan Application
- Investment
- Credit Scoring
- Installment
- Disbursement

---

# 📸 Screenshot

Tambahkan screenshot berikut sebelum presentasi.

- Login
- Register
- Dashboard Admin
- Dashboard Borrower
- Dashboard Investor
- Proposal Pendanaan
- Wallet
- Credit Scoring

---

# 👨‍🎓 Developer

Proyek ini dikembangkan oleh Kelompok __

Program Studi Informatika

Universitas Dian Nusantara

---

# 📄 Lisensi

Prototype ini dibuat untuk keperluan akademik dan pembelajaran pada mata kuliah Rekayasa Perangkat Lunak.