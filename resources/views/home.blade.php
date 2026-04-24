@extends('layouts.app')
@section('title', 'Azaila Premstore')
@section('content')

<section class="hero-section">

    <div class="blob blob-purple" style="width:500px;height:500px;top:-100px;left:-150px;"></div>
    <div class="blob blob-pink"   style="width:400px;height:400px;top:50px;right:-100px;"></div>
    <div class="blob blob-blue"  style="width:300px;height:300px;bottom:-50px;left:30%;"></div>

    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
        <div class="float-icon" style="top: 15%; left: 10%; width: 70px; height: 70px; background: linear-gradient(135deg, #fbbf24, #f59e0b); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; box-shadow: 0 8px 24px rgba(251, 191, 36, 0.3);">
            <i class="fa-solid fa-crown"></i>
        </div>
        <div class="float-icon" style="top: 70%; right: 8%; width: 60px; height: 60px; background: linear-gradient(135deg, #ec4899, #f43f5e); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; box-shadow: 0 8px 24px rgba(244, 63, 94, 0.3);">
            <i class="fa-solid fa-diamond"></i>
        </div>
        <div class="float-icon" style="top: 35%; right: 5%; width: 65px; height: 65px; background: linear-gradient(135deg, #60c3f5, #38bdf8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 30px; box-shadow: 0 8px 24px rgba(96, 195, 245, 0.3);">
            <i class="fa-solid fa-star"></i>
        </div>
        <div class="float-icon" style="top: 55%; left: 5%; width: 55px; height: 55px; background: linear-gradient(135deg, #a78bfa, #c084fc); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 26px; box-shadow: 0 8px 24px rgba(167, 139, 250, 0.3);">
            <i class="fa-solid fa-gem"></i>
        </div>
    </div>

    <div style="max-width: 1100px; margin: 0 auto; position: relative; z-index: 10;">

        <div style="display:flex; justify-content:center; margin-bottom:28px;">
            <span class="badge">
                <i class="fa-solid fa-shield-heart"></i>
                <span style="font-size:0.75rem;">TERPERCAYA SEJAK 2023</span>
            </span>
        </div>

        <h1 style="text-align:center; font-size: clamp(2.4rem, 6vw, 4rem); font-weight:800; color:#111827; line-height:1.15; letter-spacing:-1.5px; margin-bottom:24px;">
            Akun Premium<br>
            <span class="gradient-text">Paling Cepat</span>
        </h1>

        <p style="text-align:center; color:#6b7280; font-size:1.125rem; max-width:560px; margin:0 auto 40px; line-height:1.7;">
            Bayar sekali, akun langsung aktif. Tanpa daftar, tanpa ribet.
            Proses otomatis dalam hitungan detik. 
        </p>

        <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap; margin-bottom:60px;">
            <a href="#produk" class="btn-primary" style="font-size:1rem; padding:14px 36px;">
                <i class="fa-solid fa-fire"></i>
                Lihat Produk
            </a>
            <a href="#cara-beli" class="btn-outline" style="font-size:1rem; padding:14px 36px;">
                <i class="fa-solid fa-book"></i>
                Cara Beli
            </a>
        </div>

        <div style="display:flex; justify-content:center; gap:24px; flex-wrap:wrap; max-width:700px; margin:0 auto;">
            @foreach([['100+','Transaksi'], ['99%','Puas'], ['< 5 Detik','Akun Aktif']] as $stat)
            <div class="stat-box">
                <p class="stat-number">{{ $stat[0] }}</p>
                <p style="font-size:0.75rem; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin:0;">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section id="produk" style="padding: 60px 24px 80px; background: linear-gradient(180deg, #f8fafc 0%, #f0f9ff 50%, transparent 100%);">
    <div style="max-width: 1100px; margin: 0 auto;">

        <div class="section-title">
            <p class="section-title-tag"><i class="fa-solid fa-sparkles"></i> KOLEKSI EKSKLUSIF</p>
            <h2 class="section-title-main">
                Produk Premium Pilihan 
            </h2>
        </div>

        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:24px;">
            @forelse($products as $product)
            <div class="card" style="padding:0; overflow:hidden; position: relative;">
                
                @if($product->available_stock > 0)
                    <div class="premium-badge" style="position: absolute; top: 12px; right: 12px; z-index: 10;">
                        <i class="fa-solid fa-fire"></i>
                        <span>PREMIUM</span>
                    </div>
                @endif

                <div style="position: relative; overflow: hidden; height: 160px; background: linear-gradient(135deg, rgba(96, 195, 245, 0.1), rgba(244, 63, 94, 0.1));">
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/'.$product->thumbnail) }}"
                             style="width:100%; height:100%; object-fit:cover; transition: transform 0.3s ease;">
                    @else
                        <div style="width: 100%; height: 100%; display:flex; align-items:center; justify-content:center;">
                            <span style="font-size:3.5rem; color: #60c3f5;">
                                <i class="fa-solid fa-zap"></i>
                            </span>
                        </div>
                    @endif
                </div>

                <div style="padding:20px;">
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:12px; gap: 8px;">
                        <h3 style="font-size:1rem; font-weight:700; color:#111827; margin:0; flex:1;">
                            {{ $product->name }}
                        </h3>
                    </div>

                    @if($product->description)
                    <p style="color:#6b7280; font-size:0.8rem; line-height:1.5; margin-bottom:16px;">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                    @endif

                    <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-top:auto; gap: 8px;">
                        <div>
                            <p style="font-size:0.7rem; color:#9ca3af; margin:0 0 4px; text-transform: uppercase; font-weight: 600;">Harga</p>
                            <p style="font-size:1.3rem; font-weight:800; letter-spacing:-0.5px; margin:0; color: #60c3f5;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        @if($product->available_stock > 0)
                        <a href="{{ route('checkout.index', $product->slug) }}" class="btn-primary"
                           style="padding:10px 20px; font-size:0.8rem; white-space: nowrap;">
                            <i class="fa-solid fa-shopping-cart"></i>
                            Beli
                        </a>
                        @else
                        <span class="btn-primary" style="padding:10px 20px; font-size:0.8rem; opacity: 0.6; cursor: not-allowed;">
                            <i class="fa-solid fa-ban"></i>
                            Habis
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:80px 20px; color:#9ca3af;">
                <p style="font-size:4rem; margin-bottom:16px;"><i class="fa-solid fa-inbox"></i></p>
                <p style="font-weight:600; font-size: 1.1rem;">Belum ada produk tersedia.</p>
                <p style="font-size: 0.9rem; margin-top: 8px;">Cek kembali nanti ya! </p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<section id="cara-beli" style="padding:60px 24px 80px; background: linear-gradient(180deg, rgba(96, 195, 245, 0.03) 0%, rgba(244, 63, 94, 0.03) 50%, rgba(167, 139, 250, 0.03) 100%);">
    <div style="max-width: 1100px; margin: 0 auto;">

        <div class="section-title">
            <p class="section-title-tag"><i class="fa-solid fa-rocket"></i> MUDAH & CEPAT</p>
            <h2 class="section-title-main">Cara Beli dalam 4 Langkah</h2>
        </div>

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:20px;">
            @foreach([
                ['01','Pilih Produk','Pilih akun premium yang kamu butuhkan dari daftar produk kami.','#60c3f5'],
                ['02','Isi Data','Masukkan nama dan nomor telepon kamu. Tanpa perlu daftar akun.','#f43f5e'],
                ['03','Bayar','Bayar via berbagai metode pembayaran yang tersedia di Midtrans.','#a78bfa'],
                ['04','Akun Aktif','Akun langsung muncul otomatis. Simpan halamannya!','#fbbf24'],
            ] as $i => $step)
            <div class="card" style="padding:24px; text-align: center; animation-delay: {{ ($i * 0.1) }}s;">
                <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,{{ $step[3] }},{{ $step[3] }}dd);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 8px 24px rgba(0,0,0,0.12); transition: all 0.3s ease;" class="step-icon">
                    <span style="color:white;font-weight:800;font-size:1.3rem;">{{ $step[0] }}</span>
                </div>
                <h3 style="font-size:1.05rem;font-weight:700;color:#111827;margin:0 0 8px;">{{ $step[1] }}</h3>
                <p style="color:#6b7280;font-size:0.85rem;line-height:1.6;margin:0;">{{ $step[2] }}</p>
            </div>
            @endforeach
        </div>

        <div style="display:none; lg:display: flex; justify-content:center; gap:0; align-items:center; margin-top:40px;">
            @for($i = 0; $i < 3; $i++)
            <div style="flex:1;"></div>
            <div style="color:#60c3f5; font-size:1.5rem; animation: bounce-in 0.6s ease-out;">
                <i class="fa-solid fa-arrow-right"></i>
            </div>
            @endfor
        </div>
    </div>
</section>

<section id="faq" style="padding:60px 24px 80px;" x-data="{ open: null }">
    <div style="max-width:700px; margin:0 auto;">

        <div class="section-title">
            <p class="section-title-tag"><i class="fa-solid fa-circle-question"></i> FAQ</p>
            <h2 class="section-title-main">Pertanyaan Umum</h2>
        </div>

        @foreach([
            ['Apakah aman beli di sini?','Ya, super aman! Kamu tidak perlu daftar akun dan data pribadimu tidak disimpan oleh sistem kami. Checkout dengan aman!'],
            ['Berapa lama akun aktif setelah bayar?','Akun langsung aktif dalam hitungan detik setelah pembayaran dikonfirmasi. Tidak perlu tunggu lama!'],
            ['Bagaimana cara cek pesanan saya?','Simpan link halaman pesananmu. Akun akan muncul otomatis di halaman tersebut setelah bayar. Gampang!'],
            ['Apa yang terjadi jika stok habis?','Kami akan segera menambah stok. Kamu bisa cek kembali dalam beberapa jam. Jangan khawatir!'],
        ] as $i => $faq)
        <div class="card" style="margin-bottom:12px; padding:0; overflow:hidden; cursor: pointer; transition: all 0.3s ease;"
             @click="open = open === {{ $i }} ? null : {{ $i }}"
             :style="open === {{ $i }} ? 'box-shadow: 0 12px 32px rgba(96, 195, 245, 0.2)' : ''">
            <div style="padding:22px 24px; display:flex; justify-content:space-between; align-items:center;">
                <p style="font-weight:600; color:#111827; margin:0; font-size:0.95rem;">{{ $faq[0] }}</p>
                <span style="color:#60c3f5; font-size:1.4rem; transition:transform 0.3s ease; display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: rgba(96, 195, 245, 0.1); border-radius: 50%;"
                      :style="open === {{ $i }} ? 'transform:rotate(90deg); background: rgba(96, 195, 245, 0.2)' : ''">
                    <i class="fa-solid fa-chevron-down" style="font-size: 0.85rem;"></i>
                </span>
            </div>
            <div x-show="open === {{ $i }}" x-collapse
                 style="padding:0 24px 20px; color:#6b7280; font-size:0.875rem; line-height:1.7; border-top:1px solid rgba(96, 195, 245, 0.1);">
                <div style="padding-top:14px; animation: slide-up 0.3s ease;">{{ $faq[1] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section style="padding:80px 24px 120px; background: linear-gradient(180deg, rgba(96, 195, 245, 0.05) 0%, rgba(244, 63, 94, 0.05) 100%);">
    <div style="max-width:1100px; margin:0 auto; text-align:center;">
        <h2 style="font-size:clamp(1.8rem, 5vw, 2.2rem);font-weight:800;color:#111827;letter-spacing:-1px;margin:0 0 16px;">
            Siap mulai? 
        </h2>
        <h2 style="font-size:clamp(1.8rem, 5vw, 2.2rem);font-weight:800;letter-spacing:-1px;margin:0 0 20px;">
            <span class="gradient-text">Pilih produkmu sekarang!</span>
        </h2>
        <p style="color:#6b7280;margin:0 0 40px; font-size: 1.05rem; max-width: 500px; margin-left: auto; margin-right: auto;">
            Puluhan pelanggan sudah puas. Giliran kamu sekarang untuk nikmati kemudahan berbelanja akun premium! ✨
        </p>
        <a href="#produk" class="btn-primary" style="font-size:1.05rem; padding:16px 48px;">
            <i class="fa-solid fa-arrow-right"></i>
            Lihat Semua Produk
        </a>
    </div>
</section>

@endsection