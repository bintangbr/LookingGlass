# Looking Glass


Looking Glass adalah alat berbasis web yang memungkinkan Anda untuk menguji koneksi jaringan menggunakan perintah **Ping** atau **Traceroute**. Proyek ini dikembangkan untuk membantu pengguna memantau dan menganalisis jaringan dengan mudah dan aman.

---

## 🎯 Fitur

- **Ping**: Mengirim permintaan ICMP untuk mengukur latensi antara server dan host tertentu.
- **Traceroute**: Menampilkan jalur rute paket ke host tertentu melalui jaringan.
- Mendukung protokol **IPv4** dan **IPv6**.
- Menampilkan informasi jaringan seperti lokasi server, IP publik, dan organisasi pemilik IP.
- Tautan untuk mengunduh file uji (100MB dan 1000MB).

---

## 🛠️ bahasa dan tool yang Digunakan

- **PHP**: Logika backend untuk menjalankan perintah jaringan dengan keamanan dasar.
- **HTML, CSS, Bootstrap**: Membuat antarmuka pengguna yang responsif dan modern.
- **JavaScript**: Validasi form dan peningkatan pengalaman pengguna.
- **ipinfo.io API**: Mendapatkan informasi IP pengguna, termasuk organisasi pemilik IP.

---

## 📋 Install

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi ini di server lokal atau hosting, disarankan menggunakan server sendiri atau VPS.

### 1. Clone Repository
```bash
git clone https://github.com/bintangbr/LookingGlass.git
```

### 2. Masuk ke Direktori Proyek
```bash
cd LookingGlass
```

### 3. Konfigurasi
- **PHP**: Pastikan server Anda memiliki PHP versi 8.1 atau lebih tinggi.
- **API Key**: Ganti API key untuk `ipinfo.io` pada bagian berikut di file `index.php`:
    ```php
    $apiKey = '[TOKEN-IPINFO-KAMUU]'; // Ganti dengan API key ipinfo.io Anda
    ```
- **Hak Akses**: Pastikan server dapat menjalankan perintah `ping` dan `traceroute`.

### 4. Jalankan di Server Lokal
Gunakan server lokal seperti **XAMPP** atau **Laragon**, atau jalankan PHP built-in server:
```bash
php -S localhost:8000
```

### 5. Akses Aplikasi
Buka browser Anda dan akses:
```
http://localhost:8000
```

---

## 🚀 Penggunaan

1. Pilih perintah yang ingin dijalankan: **Ping** atau **Traceroute**.
2. Pilih protokol: **IPv4** atau **IPv6**.
3. Masukkan alamat IP atau hostname target.
4. Klik tombol **Jalankan** untuk melihat hasilnya.

---

## 📂 Struktur Project

```
looking-glass/
├── index.php          # File utama aplikasi
├── 100MB.test         # File uji (100MB)
├── 1000MB.test        # File uji (1000MB)
├── README.md          
```

---

## 📑 Catatan Keamanan

- Pastikan hanya perintah yang diizinkan (seperti `ping` dan `traceroute`) yang dapat dijalankan oleh aplikasi.
- Parameter yang dimasukkan oleh pengguna telah di-*sanitize* menggunakan fungsi `escapeshellarg()` untuk mencegah serangan injeksi perintah.
- Jangan lupa mengganti API key ipinfo.io Anda dengan yang valid.

---

## ✨ Kontributor

Proyek ini dikembangkan oleh **Linkbit Inovasi Teknologi** untuk membantu memonitor jaringan.

- **Nama Developer**: Bintanggg
- **GitHub**: [bintangbr](https://github.com/bintangbr)

---

## 🌐 Lisensi

Proyek ini dirilis di bawah lisensi **MIT**. Silakan baca file [LICENSE](LICENSE) untuk informasi lebih lanjut.

---

## 💬 Dukungan

Jika Anda memiliki pertanyaan atau ingin melaporkan bug, silakan buka *issue* di [GitHub Issue Tracker](https://github.com/bintangbr/looking-glass/issues) atau hubungi kami di [Linkbit Inovasi Teknologi](https://linkbit.net.id).

## TERIMA KASIIII :)
