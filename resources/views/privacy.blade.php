<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi (Privacy Policy) | BGPortal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: system-ui, -apple-system, sans-serif; color: #333; }
        .privacy-card { background: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 40px; margin-top: 40px; margin-bottom: 40px; }
        h1 { color: #e60023; font-weight: 700; }
        h4 { color: #212529; font-weight: 600; margin-top: 24px; margin-bottom: 12px; }
        p, li { line-height: 1.7; color: #495057; }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="privacy-card">
                    <div class="text-center mb-4">
                        <h1 class="display-6">Kebijakan Privasi (Privacy Policy)</h1>
                        <p class="text-muted">Terakhir diperbarui: {{ date('d F Y') }} | BGPortal System</p>
                    </div>
                    <hr class="mb-4">

                    <h4>1. Pendahuluan</h4>
                    <p>Selamat datang di <strong>BGPortal System</strong> (<code>bgportal.web.id</code>). Kami sangat menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi serta akses API pengguna kami. Dokumen Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi saat Anda menggunakan aplikasi dan layanan kami.</p>

                    <h4>2. Informasi yang Kami Kumpulkan</h4>
                    <p>Kami mengumpulkan informasi yang diperlukan untuk mengoperasikan sistem otomasi posting dan manajemen aplikasi central, meliputi:</p>
                    <ul>
                        <li><strong>Informasi Akun Pengguna:</strong> Nama, alamat email, dan kredensial login akun BGPortal.</li>
                        <li><strong>Token & Integrasi Pihak Ketiga:</strong> Access Token Pinterest API, Username, dan Board Target ID yang Anda berikan secara sukarela untuk mengintegrasikan layanan Pinterest.</li>
                        <li><strong>Data Tautan Affiliate & Konten:</strong> URL produk Shopee, tautan affiliate, judul, dan gambar promosi yang diunggah atau diproses oleh sistem.</li>
                    </ul>

                    <h4>3. Penggunaan Informasi</h4>
                    <p>Informasi yang kami kumpulkan digunakan semata-mata untuk:</p>
                    <ul>
                        <li>Mengotomasikan pembuatan dan publikasi Pin promo affiliate ke akun Pinterest terhubung milik Anda.</li>
                        <li>Memvalidasi kategori produk dan antrean posting sesuai preferensi pengaturan pengguna.</li>
                        <li>Menampilkan statistik dan log riwayat eksekusi posting pada dashboard aplikasi.</li>
                        <li>Kami <strong>tidak pernah menjual, menyewakan, atau membagikan</strong> Access Token atau data pribadi Anda kepada pihak ketiga mana pun.</li>
                    </ul>

                    <h4>4. Akses API Pinterest & Perlindungan Data Token</h4>
                    <p>Aplikasi kami menggunakan Pinterest API sesuai dengan panduan pengembang resmi Pinterest. Access Token yang dimasukkan disimpan secara aman di database server kami yang terenkripsi dan hanya digunakan untuk meminta izin pembuatan Pin atas nama pengguna yang berwenang.</p>

                    <h4>5. Keamanan Data</h4>
                    <p>Kami menerapkan standar keamanan teknis terkini, termasuk penggunaan enkripsi SSL (HTTPS) dan protokol database yang aman untuk mencegah akses tidak sah, pengungkapan, atau modifikasi data pengguna.</p>

                    <h4>6. Hak Pengguna & Penghapusan Data</h4>
                    <p>Pengguna memiliki hak penuh untuk mengubah, melepaskan integrasi akun Pinterest, atau menghapus Access Token kapan saja melalui menu <em>Manajemen Akun Pinterest</em> di portal kami.</p>

                    <h4>7. Kontak Kami</h4>
                    <p>Jika Anda memiliki pertanyaan mengenai Kebijakan Privasi ini, silakan hubungi tim dukungan kami di:</p>
                    <p><strong>Email:</strong> admin@bgportal.web.id<br>
                    <strong>Website:</strong> <a href="https://bgportal.web.id">https://bgportal.web.id</a></p>

                    <div class="text-center mt-5 pt-3 border-top">
                        <small class="text-muted">&copy; {{ date('Y') }} BGPortal System. All rights reserved.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
