@extends('layouts.app')
@section('title', 'Azaila Premstore')
@section('content')

{{-- ===== HERO ===== --}}
<section style="position: relative; overflow: hidden; padding: 80px 24px 100px;">

    {{-- Decorative blobs --}}
    <div class="blob blob-purple" style="width:500px;height:500px;top:-100px;left:-150px;"></div>
    <div class="blob blob-pink"   style="width:400px;height:400px;top:50px;right:-100px;"></div>
    <div class="blob blob-blue"  style="width:300px;height:300px;bottom:-50px;left:30%;"></div>

    <div style="max-width: 1100px; margin: 0 auto; position: relative;">

        {{-- Badge --}}
        <div style="display:flex; justify-content:center; margin-bottom:28px;">
            <span style="background: linear-gradient(135deg, rgba(109,40,217,0.1), rgba(236,72,153,0.1)); border: 1px solid rgba(109,40,217,0.2); color: #6d28d9; font-size:0.8rem; font-weight:700; padding:6px 16px; border-radius:999px; letter-spacing:0.5px;">
                <i class="fa-solid fa-shield-heart"></i> TERPERCAYA SEJAK 2023
            </span>
        </div>

        {{-- Headline --}}
        <h1 style="text-align:center; font-size: clamp(2.4rem, 6vw, 4rem); font-weight:800; color:#111827; line-height:1.15; letter-spacing:-1.5px; margin-bottom:24px;">
            Akun Premium<br>
            <span class="gradient-text">Instan & Terpercaya</span>
        </h1>

        <p style="text-align:center; color:#6b7280; font-size:1.125rem; max-width:560px; margin:0 auto 40px; line-height:1.7;">
            Bayar sekali, akun langsung aktif. Tanpa daftar, tanpa ribet.
            Proses otomatis dalam hitungan detik.
        </p>

        {{-- CTA Buttons --}}
        <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
            <a href="#produk" class="btn-primary" style="font-size:1rem; padding:14px 36px;">
                Lihat Produk ↓
            </a>
            <a href="#cara-beli" class="btn-outline" style="font-size:1rem; padding:14px 36px;">
                Cara Beli
            </a>
        </div>

        <div style="display:flex; justify-content:center; gap:48px; margin-top:60px; flex-wrap:wrap;">
            @foreach([['100+','Transaksi'], ['99%','Rate'], ['< 5 Detik','Proses Akun']] as $stat)
            <div style="text-align:center;">
                <p style="font-size:1.75rem; font-weight:800; letter-spacing:-1px;" class="gradient-text">{{ $stat[0] }}</p>
                <p style="font-size:0.8rem; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px;">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== PRODUK ===== --}}
<section id="produk" style="padding: 60px 24px 80px;">
    <div style="max-width: 1100px; margin: 0 auto;">

        <div style="text-align:center; margin-bottom:48px;">
            <p style="font-size:0.8rem; font-weight:700; color:#8b5cf6; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">PILIHAN PRODUK</p>
            <h2 style="font-size:2.2rem; font-weight:800; color:#111827; letter-spacing:-1px; margin:0;">
                Semua Produk Premium
            </h2>
        </div>

        {{-- Product Grid --}}
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:24px;">
            @forelse($products as $product)
            <div class="card" style="padding:0; overflow:hidden;">

                {{-- Thumbnail / Placeholder --}}
                @if($product->thumbnail)
                    <img src="{{ asset('storage/'.$product->thumbnail) }}"
                         style="width:100%; height:160px; object-fit:cover;">
                @else
                    <div style="height:140px; background: linear-gradient(135deg, rgba(109,40,217,0.08), rgba(236,72,153,0.08)); display:flex; align-items:center; justify-content:center;">
                        <span style="font-size:3rem;"><i class="fa-solid fa-bolt"></i></span>
                    </div>
                @endif

                <div style="padding:22px 24px 24px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                        <h3 style="font-size:1rem; font-weight:700; color:#111827; margin:0; flex:1;">
                            {{ $product->name }}
                        </h3>
                        @if($product->available_stock > 0)
                            <span class="badge-green">Stok: {{ $product->available_stock }}</span>
                        @else
                            <span class="badge-red">Habis</span>
                        @endif
                    </div>

                    @if($product->description)
                    <p style="color:#6b7280; font-size:0.85rem; line-height:1.6; margin-bottom:18px;">
                        {{ Str::limit($product->description, 90) }}
                    </p>
                    @endif

                    <div style="display:flex; align-items:center; justify-content:space-between; margin-top:auto;">
                        <div>
                            <p style="font-size:0.75rem; color:#9ca3af; margin:0 0 2px;">Harga</p>
                            <p style="font-size:1.4rem; font-weight:800; letter-spacing:-0.5px; margin:0;" class="gradient-text">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        @if($product->available_stock > 0)
                        <a href="{{ route('checkout.index', $product->slug) }}" class="btn-primary"
                           style="padding:10px 22px; font-size:0.875rem;">
                            Beli →
                        </a>
                        @else
                        <span class="btn-primary disabled" style="padding:10px 22px; font-size:0.875rem;">
                            Habis
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:60px; color:#9ca3af;">
                <p style="font-size:3rem; margin-bottom:16px;"><i class="fa-solid fa-box-open"></i></p>
                <p style="font-weight:600;">Belum ada produk tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ===== CARA BELI ===== --}}
<section id="cara-beli" style="padding:60px 24px 80px; background: linear-gradient(180deg, rgba(109,40,217,0.03) 0%, rgba(236,72,153,0.03) 100%);">
    <div style="max-width: 1100px; margin: 0 auto;">

        <div style="text-align:center; margin-bottom:48px;">
            <p style="font-size:0.8rem; font-weight:700; color:#ec4899; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">MUDAH & CEPAT</p>
            <h2 style="font-size:2.2rem; font-weight:800; color:#111827; letter-spacing:-1px; margin:0;">Cara Beli</h2>
        </div>

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:20px;">
            @foreach([
                ['01','Pilih Produk','Pilih akun premium yang kamu butuhkan dari daftar produk kami.','#6d28d9'],
                ['02','Isi Data','Masukkan nama dan nomor telepon kamu. Tanpa perlu daftar akun.','#8b5cf6'],
                ['03','Bayar','Bayar via berbagai metode pembayaran yang tersedia di Midtrans.','#a855f7'],
                ['04','Akun Aktif','Akun langsung muncul otomatis. Simpan halamannya!','#ec4899'],
            ] as $step)
            <div class="card" style="padding:28px 24px;">
                <div style="width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,{{ $step[3] }},#ec4899);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                    <span style="color:white;font-weight:800;font-size:0.9rem;">{{ $step[0] }}</span>
                </div>
                <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:0 0 8px;">{{ $step[1] }}</h3>
                <p style="color:#6b7280;font-size:0.875rem;line-height:1.6;margin:0;">{{ $step[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section style="padding:60px 24px 80px;">
    <div style="max-width:1100px; margin:0 auto;">
        <div style="background:linear-gradient(135deg,#6d28d9,#ec4899); border-radius:32px; padding:56px 48px; position:relative; overflow:hidden;">

            <div class="blob" style="background:white;opacity:0.05;width:400px;height:400px;top:-100px;right:-100px;"></div>

            <div style="text-align:center; position:relative;">
                <h2 style="font-size:2rem;font-weight:800;color:white;letter-spacing:-1px;margin:0 0 16px;">
                    Kenapa Pilih AzailaiestStore?
                </h2>
                <p style="color:rgba(255,255,255,0.75);font-size:1rem;margin:0 0 48px;">
                    Kami hadir untuk memudahkan hidupmu.
                </p>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;text-align:left;">
                    @foreach([
                        ['fa-solid fa-bolt','Instan','Akun aktif dalam hitungan detik setelah pembayaran.'],
                        ['fa-solid fa-shield-halved','Aman','Data kamu tidak disimpan, checkout tanpa daftar.'],
                        ['fa-solid fa-credit-card','Banyak Metode','Transfer, e-wallet, kartu kredit semua bisa.'],
                        ['fa-solid fa-headset','Support','Tim kami siap bantu jika ada kendala.'],
                    ] as $f)
                    <div style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:20px;padding:22px;">
                        <p style="font-size:1.5rem;margin:0 0 10px;"><i class="{{ $f[0] }}"></i></p>
                        <p style="font-size:0.95rem;font-weight:700;color:white;margin:0 0 6px;">{{ $f[1] }}</p>
                        <p style="font-size:0.825rem;color:rgba(255,255,255,0.7);margin:0;line-height:1.5;">{{ $f[2] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== FAQ ===== --}}
<section id="faq" style="padding:60px 24px 80px;" x-data="{ open: null }">
    <div style="max-width:700px; margin:0 auto;">

        <div style="text-align:center; margin-bottom:48px;">
            <p style="font-size:0.8rem; font-weight:700; color:#8b5cf6; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">FAQ</p>
            <h2 style="font-size:2.2rem; font-weight:800; color:#111827; letter-spacing:-1px; margin:0;">Pertanyaan Umum</h2>
        </div>

        @foreach([
            ['Apakah aman beli di sini?','Ya, sangat aman. Kamu tidak perlu daftar akun dan data pribadimu tidak disimpan oleh sistem kami.'],
            ['Berapa lama akun aktif setelah bayar?','Akun langsung aktif dalam hitungan detik setelah pembayaran dikonfirmasi secara otomatis.'],
            ['Bagaimana cara cek pesanan saya?','Simpan link halaman pesananmu. Akun akan muncul otomatis di halaman tersebut setelah bayar.'],
            ['Apa yang terjadi jika stok habis?','Kami akan segera menambah stok. Kamu bisa cek kembali dalam beberapa jam.'],
        ] as $i => $faq)
        <div class="card" style="margin-bottom:12px; padding:0; overflow:hidden;"
             @click="open = open === {{ $i }} ? null : {{ $i }}">
            <div style="padding:20px 24px; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                <p style="font-weight:600; color:#111827; margin:0; font-size:0.95rem;">{{ $faq[0] }}</p>
                <span style="color:#8b5cf6; font-size:1.2rem; transition:transform 0.2s;"
                      :style="open === {{ $i }} ? 'transform:rotate(45deg)' : ''">+</span>
            </div>
            <div x-show="open === {{ $i }}" x-collapse
                 style="padding:0 24px 20px; color:#6b7280; font-size:0.875rem; line-height:1.7; border-top:1px solid rgba(139,92,246,0.08);">
                <div style="padding-top:14px;">{{ $faq[1] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ===== CTA BOTTOM ===== --}}
<section style="padding:0 24px 80px;">
    <div style="max-width:1100px; margin:0 auto; text-align:center;">
        <h2 style="font-size:2rem;font-weight:800;color:#111827;letter-spacing:-1px;margin:0 0 12px;">
            Siap mulai? <span class="gradient-text">Pilih produkmu.</span>
        </h2>
        <p style="color:#6b7280;margin:0 0 32px;">Ratusan pelanggan sudah puas. Giliran kamu sekarang.</p>
        <a href="#produk" class="btn-primary" style="font-size:1rem; padding:14px 40px;">
            Lihat Semua Produk →
        </a>
    </div>
</section>

@endsection