@extends('layouts.app')

@section('content')
<style>
    .privacy-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        color: white;
        padding: 40px;
        border-radius: 20px;
        text-align: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(30,58,95,0.15);
        position: relative;
        overflow: hidden;
    }
    .privacy-header::before {
        content: '\f023';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        font-size: 120px;
        position: absolute;
        right: 20px;
        top: -10px;
        opacity: 0.05;
        transform: rotate(15deg);
    }
    .privacy-header h2 {
        font-weight: 800;
        margin-bottom: 10px;
        font-size: 28px;
    }
    .privacy-header p {
        opacity: 0.8;
        font-size: 15px;
        margin: 0;
    }
    .privacy-content {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        color: #334155;
        line-height: 1.8;
    }
    .privacy-section {
        margin-bottom: 30px;
    }
    .privacy-section h4 {
        color: #1e3a5f;
        font-weight: 700;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .privacy-section h4 i {
        color: #e67e22;
        font-size: 20px;
    }
    .privacy-section p {
        margin-bottom: 10px;
        font-size: 14px;
    }
    .privacy-section ul {
        padding-left: 20px;
        font-size: 14px;
    }
    .privacy-section ul li {
        margin-bottom: 8px;
    }
</style>

<div class="container-fluid px-0 max-w-4xl mx-auto" style="max-width: 900px;">
    
    <div class="privacy-header">
        <h2>Kebijakan Privasi</h2>
        <p>Resto App - Komitmen Kami Terhadap Keamanan Data Anda</p>
    </div>

    <div class="privacy-content">
        <div class="privacy-section">
            <p>Selamat datang di <strong>Resto App</strong>! Kami sangat menghargai privasi Anda. Halaman ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat menggunakan layanan reservasi dan manajemen restoran kami.</p>
        </div>

        <div class="privacy-section">
            <h4><i class="fas fa-clipboard-list"></i> 1. Informasi yang Kami Kumpulkan</h4>
            <p>Untuk memberikan pelayanan terbaik dalam proses reservasi dan pesanan, kami mengumpulkan beberapa informasi dasar saat Anda mendaftar atau membuat pesanan, antara lain:</p>
            <ul>
                <li><strong>Data Profil:</strong> Nama lengkap dan alamat email.</li>
                <li><strong>Data Reservasi:</strong> Nomor telepon (WhatsApp) agar kami bisa mengonfirmasi kehadiran atau memberikan info terkait meja Anda.</li>
                <li><strong>Riwayat Pesanan:</strong> Data transaksi, waktu booking, dan meja yang Anda pilih untuk meningkatkan pelayanan di masa mendatang.</li>
            </ul>
        </div>

        <div class="privacy-section">
            <h4><i class="fas fa-hand-holding-heart"></i> 2. Penggunaan Informasi</h4>
            <p>Data yang kami kumpulkan semata-mata digunakan untuk kepentingan operasional restoran, yaitu:</p>
            <ul>
                <li>Memproses reservasi meja dan memastikan ketersediaan tempat Anda.</li>
                <li>Mengirimkan notifikasi atau pembaruan terkait status booking melalui WhatsApp.</li>
                <li>Meningkatkan pengalaman pengguna dalam menggunakan sistem Resto App.</li>
            </ul>
        </div>

        <div class="privacy-section">
            <h4><i class="fas fa-shield-alt"></i> 3. Perlindungan & Keamanan Data</h4>
            <p>Kami berkomitmen untuk <strong>tidak pernah menjual, menukar, atau membagikan</strong> informasi pribadi Anda kepada pihak ketiga untuk kepentingan komersial. Data Anda tersimpan secara aman di dalam database sistem tertutup kami yang hanya dapat diakses oleh staf berwenang (Admin dan Dapur).</p>
        </div>

        <div class="privacy-section">
            <h4><i class="fas fa-headset"></i> 4. Hubungi Kami</h4>
            <p>Jika Anda memiliki pertanyaan lebih lanjut terkait kebijakan privasi ini atau ingin meminta penghapusan data akun Anda, jangan ragu untuk menghubungi tim admin kami melalui kontak di bawah ini:</p>
            <div class="d-flex gap-3 mt-3">
                <a href="https://wa.me/6282181976863" target="_blank" class="btn text-white" style="background: #25D366; font-weight: 600; border-radius: 10px;">
                    <i class="fab fa-whatsapp me-1"></i> WhatsApp
                </a>
                <a href="https://www.instagram.com/dwntie01?igsh=ZXg4aG91djh2eHYx" target="_blank" class="btn text-white" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); font-weight: 600; border-radius: 10px;">
                    <i class="fab fa-instagram me-1"></i> Instagram
                </a>
            </div>
        </div>
        
        <hr class="my-4" style="border-color: #e2e8f0;">
        <p class="text-center text-muted mb-0" style="font-size: 12px;">Terakhir diperbarui: {{ date('d F Y') }}</p>
    </div>

</div>

@endsection
