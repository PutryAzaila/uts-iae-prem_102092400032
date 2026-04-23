@extends('layouts.app')
@section('title', $product->name.' — Azaila Premstore')
@section('content')

<div style="max-width:960px; margin:40px auto; padding:0 24px; display:grid; grid-template-columns:1fr 380px; gap:28px; align-items:start;">

    <div>
        <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;color:#8b5cf6;font-size:0.875rem;font-weight:600;text-decoration:none;margin-bottom:28px;">
            ← Kembali
        </a>

        <div class="card" style="padding:30px;">
            @if($product->thumbnail)
            <img src="{{ asset('storage/'.$product->thumbnail) }}"
                 alt="{{ $product->name }}"
                 style="width:100%;height:220px;object-fit:cover;border-radius:16px;margin-bottom:20px;">
            @endif

            <h1 style="font-size:1.75rem;font-weight:800;color:#111827;letter-spacing:-0.5px;margin:0 0 10px;">
                {{ $product->name }}
            </h1>

            @if($product->description)
            <p style="color:#6b7280;font-size:0.95rem;line-height:1.8;margin:0;">
                {{ $product->description }}
            </p>
            @endif
        </div>
    </div>

    <div style="position:sticky; top:100px;">
        <div class="card" style="padding:24px;">
            <p style="font-size:0.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 16px;">RINGKASAN</p>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                <span style="color:#6b7280;font-size:0.9rem;">Harga</span>
                <span class="gradient-text" style="font-size:1.35rem;font-weight:800;letter-spacing:-0.5px;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
                <span style="color:#6b7280;font-size:0.9rem;">Stok</span>
                @if($product->available_stock > 0)
                <span class="badge-green">{{ $product->available_stock }} tersedia</span>
                @else
                <span class="badge-red">Stok habis</span>
                @endif
            </div>

            @if($product->available_stock > 0)
            <a href="{{ route('checkout.index', $product->slug) }}" class="btn-primary" style="display:block;text-align:center;">
                <i class="fa-solid fa-credit-card"></i> Lanjut ke Checkout
            </a>
            @else
            <span class="btn-primary disabled" style="display:block;text-align:center;">Stok Habis</span>
            @endif
        </div>
    </div>
</div>

@endsection
