@extends('layouts.app')
@section('title', 'Checkout — '.$product->name)
@section('content')

<div style="max-width:960px; margin:40px auto; padding:0 24px; display:grid; grid-template-columns:1fr 380px; gap:28px; align-items:start;">

    <div>
        <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;color:#8b5cf6;font-size:0.875rem;font-weight:600;text-decoration:none;margin-bottom:28px;">
            ← Kembali
        </a>

        <h1 style="font-size:1.75rem;font-weight:800;color:#111827;letter-spacing:-0.5px;margin:0 0 8px;">Checkout</h1>
        <p style="color:#6b7280;font-size:0.9rem;margin:0 0 32px;">Isi data diri kamu untuk melanjutkan pembayaran.</p>

        <div class="card" style="padding:32px;" x-data="{ loading: false }">
            <form method="POST" action="{{ route('checkout.store', $product->slug) }}"
                  @submit="loading = true">
                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div style="display:flex;flex-direction:column;gap:20px;">

                    {{-- Nama --}}
                    <div>
                        <label class="form-label">
                            Nama Lengkap <span style="color:#ec4899;">*</span>
                        </label>
                        <input type="text" name="customer_name"
                               value="{{ old('customer_name') }}"
                               placeholder="Masukkan nama kamu"
                               class="form-input {{ $errors->has('customer_name') ? 'error' : '' }}">
                        @error('customer_name')
                        <p style="color:#ef4444;font-size:0.8rem;margin:6px 0 0;font-weight:500;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No Telepon --}}
                    <div>
                        <label class="form-label">
                            Nomor Telepon <span style="color:#ec4899;">*</span>
                        </label>
                        <input type="number" name="customer_phone"
                               value="{{ old('customer_phone') }}"
                               placeholder="08xxxxxxxxxx"
                               class="form-input {{ $errors->has('customer_phone') ? 'error' : '' }}">
                        @error('customer_phone')
                        <p style="color:#ef4444;font-size:0.8rem;margin:6px 0 0;font-weight:500;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="form-label">
                            Email
                            <span style="color:#9ca3af;font-weight:400;">(opsional)</span>
                        </label>
                        <input type="email" name="customer_email"
                               value="{{ old('customer_email') }}"
                               placeholder="email@kamu.com"
                               class="form-input {{ $errors->has('customer_email') ? 'error' : '' }}">
                        @error('customer_email')
                        <p style="color:#ef4444;font-size:0.8rem;margin:6px 0 0;font-weight:500;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Note --}}
                <div style="background:rgba(139,92,246,0.05);border:1px solid rgba(139,92,246,0.12);border-radius:12px;padding:14px 16px;margin-top:24px;margin-bottom:28px;">
                    <p style="font-size:0.8rem;color:#6b7280;margin:0;line-height:1.6;">
                        <i class="fa-solid fa-shield-halved"></i> Data kamu hanya digunakan untuk keperluan pesanan ini. Kami tidak menyimpan informasi sensitif.
                    </p>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        :disabled="loading"
                        class="btn-primary"
                        style="width:100%;text-align:center;padding:14px;font-size:1rem;">
                    <span x-show="!loading">Bayar Sekarang →</span>
                    <span x-show="loading">Memproses...</span>
                </button>
            </form>
        </div>
    </div>

    {{-- ===== KANAN: SUMMARY ===== --}}
    <div style="position:sticky; top:100px;">

        {{-- Product Card --}}
        <div class="card" style="padding:24px; margin-bottom:16px;">
            <p style="font-size:0.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 16px;">RINGKASAN PESANAN</p>

            @if($product->thumbnail)
            <img src="{{ asset('storage/'.$product->thumbnail) }}"
                 style="width:100%;height:120px;object-fit:cover;border-radius:14px;margin-bottom:16px;">
            @else
            <div style="height:100px;background:linear-gradient(135deg,rgba(109,40,217,0.08),rgba(236,72,153,0.08));border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                <span style="font-size:2.5rem;"><i class="fa-solid fa-bolt"></i></span>
            </div>
            @endif

            <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:0 0 6px;">{{ $product->name }}</h3>

            @if($product->description)
            <p style="color:#6b7280;font-size:0.825rem;line-height:1.5;margin:0 0 16px;">
                {{ Str::limit($product->description, 100) }}
            </p>
            @endif

            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px;">
                @if($product->available_stock > 0)
                <span class="badge-green">Stok tersedia</span>
                @endif
                <p style="font-size:1.3rem;font-weight:800;letter-spacing:-0.5px;margin:0;" class="gradient-text">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="card" style="padding:20px 24px;">
            <p style="font-size:0.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 14px;">METODE PEMBAYARAN</p>
            <div style="display:flex;flex-wrap:wrap;gap:8px;">
                @foreach(['GoPay','OVO','Dana','BCA','Mandiri','Kartu Kredit'] as $pm)
                <span style="background:#f3f4f6;color:#374151;font-size:0.75rem;font-weight:600;padding:4px 10px;border-radius:8px;">
                    {{ $pm }}
                </span>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection