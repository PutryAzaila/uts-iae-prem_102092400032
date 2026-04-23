@extends('layouts.app')
@section('title', 'Detail Pesanan — '.$order->order_code)
@section('content')

<div style="max-width:600px; margin:40px auto; padding:0 24px;"
    x-data="orderPage()" x-init="init()">

    <div style="text-align:center; margin-bottom:32px;">

        <div style="width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:2rem;
            {{ $order->status->value === 'paid'    ? 'background:linear-gradient(135deg,#d1fae5,#a7f3d0);' : '' }}
            {{ $order->status->value === 'pending' ? 'background:linear-gradient(135deg,#fef9c3,#fde68a);' : '' }}
            {{ in_array($order->status->value, ['failed','expired','cancelled']) ? 'background:linear-gradient(135deg,#fee2e2,#fecaca);' : '' }}
        ">
            @if($order->status->value === 'paid')
                <i class="fa-solid fa-circle-check" style="color:#059669;"></i>
            @elseif($order->status->value === 'pending')
                <i class="fa-solid fa-clock" style="color:#b45309;"></i>
            @elseif($order->status->value === 'expired')
                <i class="fa-solid fa-hourglass-half" style="color:#b45309;"></i>
            @else
                <i class="fa-solid fa-circle-xmark" style="color:#dc2626;"></i>
            @endif
        </div>

        <h1 style="font-size:1.6rem;font-weight:800;color:#111827;letter-spacing:-0.5px;margin:0 0 6px;">
            @if($order->status->value === 'paid')    Pembayaran Berhasil!
            @elseif($order->status->value === 'pending') Menunggu Pembayaran
            @elseif($order->status->value === 'expired')  Pesanan Kadaluarsa
            @elseif($order->status->value === 'cancelled') Pesanan Dibatalkan
            @else Pembayaran Gagal
            @endif
        </h1>

        <p style="color:#9ca3af;font-size:0.875rem;margin:0;font-family:monospace;">
            {{ $order->order_code }}
        </p>
    </div>

    @if($order->status->value === 'pending' && $snapToken)
    <div style="margin-bottom:20px;">
        <button @click="openSnap()"
                :disabled="isPaying || !snapReady"
                class="btn-primary"
                style="width:100%;text-align:center;padding:14px;font-size:1rem;">
            <span x-show="!isPaying && snapReady">Lanjutkan Pembayaran →</span>
            <span x-show="isPaying">Membuka Midtrans...</span>
            <span x-show="!snapReady && !isPaying">Memuat Midtrans...</span>
        </button>
    </div>

    <div x-show="snapError"
         style="background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;padding:12px 14px;border-radius:12px;margin-bottom:16px;font-size:0.85rem;"
         x-text="snapError">
    </div>
    @endif

    <div class="card" style="padding:24px; margin-bottom:16px;">
        <p style="font-size:0.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 16px;">DETAIL PESANAN</p>

        <table style="width:100%;font-size:0.9rem;border-collapse:collapse;">
            @foreach([
                ['Produk',       $order->product->name],
                ['Total',        'Rp '.number_format($order->total_amount,0,',','.')],
                ['Nama',         $order->customer_name],
                ['Telepon',      $order->customer_phone],
            ] as $row)
            <tr style="border-bottom:1px solid rgba(139,92,246,0.06);">
                <td style="padding:10px 0;color:#9ca3af;font-weight:500;width:40%;">{{ $row[0] }}</td>
                <td style="padding:10px 0;color:#111827;font-weight:600;text-align:right;">
                    @if($row[0] === 'Total')
                        <span class="gradient-text">{{ $row[1] }}</span>
                    @else
                        {{ $row[1] }}
                    @endif
                </td>
            </tr>
            @endforeach
            <tr>
                <td style="padding:10px 0;color:#9ca3af;font-weight:500;">Status</td>
                <td style="padding:10px 0;text-align:right;">
                    @if($order->status->value === 'paid')
                        <span class="badge-green">PAID</span>
                    @elseif($order->status->value === 'pending')
                        <span class="badge-yellow">PENDING</span>
                    @else
                        <span class="badge-red">{{ strtoupper($order->status->value) }}</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    @if($account)
    <div style="background:linear-gradient(135deg,rgba(109,40,217,0.05),rgba(236,72,153,0.05));border:1.5px solid rgba(109,40,217,0.2);border-radius:24px;padding:28px;margin-bottom:16px;">

        <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
            <div style="width:36px;height:36px;background:linear-gradient(135deg,#6d28d9,#ec4899);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1rem;"><i class="fa-solid fa-key" style="color:white;"></i></div>
            <div>
                <p style="font-weight:700;color:#111827;margin:0;font-size:0.95rem;">Data Akun Premium Kamu</p>
                <p style="color:#8b5cf6;font-size:0.775rem;margin:0;font-weight:500;">Simpan halaman ini baik-baik!</p>
            </div>
        </div>

        <div style="margin-bottom:14px;">
            <p style="font-size:0.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 8px;">USERNAME / EMAIL</p>
            <div style="display:flex;align-items:center;gap:8px;">
                <code style="flex:1;background:white;border:1px solid rgba(139,92,246,0.15);border-radius:10px;padding:10px 14px;font-size:0.875rem;color:#111827;display:block;">
                    {{ $account->account_email_or_username }}
                </code>
                <button @click="copy('{{ $account->account_email_or_username }}', 'user')"
                        style="background:linear-gradient(135deg,#6d28d9,#ec4899);color:white;border:none;border-radius:10px;padding:10px 16px;font-size:0.8rem;font-weight:600;cursor:pointer;white-space:nowrap;">
                    <span x-text="copied.user ? 'Disalin!' : 'Salin'">Salin</span>
                </button>
            </div>
        </div>

        {{-- Password --}}
        <div style="margin-bottom:16px;">
            <p style="font-size:0.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 8px;">PASSWORD</p>
            <div style="display:flex;align-items:center;gap:8px;">
                <code style="flex:1;background:white;border:1px solid rgba(139,92,246,0.15);border-radius:10px;padding:10px 14px;font-size:0.875rem;color:#111827;display:block;"
                      x-text="showPass ? '{{ $account->account_password }}' : '••••••••••'">
                    ••••••••••
                </code>
                <button @click="showPass = !showPass"
                        style="background:white;color:#6d28d9;border:1.5px solid rgba(109,40,217,0.2);border-radius:10px;padding:10px 14px;font-size:0.8rem;font-weight:600;cursor:pointer;">
                    <span x-text="showPass ? 'Sembunyikan' : 'Lihat'">Lihat</span>
                </button>
                <button @click="copy('{{ $account->account_password }}', 'pass')"
                        style="background:linear-gradient(135deg,#6d28d9,#ec4899);color:white;border:none;border-radius:10px;padding:10px 16px;font-size:0.8rem;font-weight:600;cursor:pointer;white-space:nowrap;">
                    <span x-text="copied.pass ? 'Disalin!' : 'Salin'">Salin</span>
                </button>
            </div>
        </div>

        @if($account->notes)
        <div style="background:rgba(253,230,138,0.3);border:1px solid rgba(217,119,6,0.2);border-radius:10px;padding:12px 14px;">
            <p style="font-size:0.825rem;color:#92400e;margin:0;line-height:1.5;">
                <i class="fa-solid fa-circle-info"></i> {{ $account->notes }}
            </p>
        </div>
        @endif
    </div>
    @endif

    @if($order->status->value === 'pending')
    <div style="background:rgba(253,230,138,0.2);border:1.5px solid rgba(217,119,6,0.2);border-radius:20px;padding:20px;margin-bottom:16px;">
        <p style="font-size:0.875rem;color:#92400e;margin:0;line-height:1.6;">
            <i class="fa-solid fa-clock"></i> Selesaikan pembayaran sebelum
            <strong>{{ $order->expired_at?->format('d M Y, H:i') }}</strong>.
            Akun akan otomatis muncul di halaman ini setelah pembayaran dikonfirmasi.
        </p>
    </div>
    @endif

    @if(in_array($order->status->value, ['failed','expired','cancelled']))
    <div style="background:rgba(254,226,226,0.3);border:1.5px solid rgba(220,38,38,0.15);border-radius:20px;padding:20px;margin-bottom:16px;">
        <p style="font-size:0.875rem;color:#b91c1c;margin:0 0 12px;line-height:1.6;">
            <i class="fa-solid fa-circle-xmark"></i> Pesanan ini tidak dapat diproses. Silakan buat pesanan baru.
        </p>
        <a href="{{ route('home') }}" class="btn-primary" style="font-size:0.875rem;padding:10px 20px;">
            Beli Lagi →
        </a>
    </div>
    @endif

    <div style="text-align:center; margin-top:24px;">
        <a href="{{ route('home') }}"
           style="color:#8b5cf6;font-size:0.875rem;font-weight:600;text-decoration:none;">
            ← Kembali ke Beranda
        </a>
    </div>
</div>

@if($snapToken && config('midtrans.client_key'))
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif

@if($snapToken && !config('midtrans.client_key'))
<script>
    console.error('Midtrans client key kosong. Cek MIDTRANS_CLIENT_KEY di file .env');
</script>
@endif

<script>
function orderPage() {
    return {
        snapToken: '{{ $snapToken ?? '' }}',
        snapReady: false,
        isPaying: false,
        snapError: '',
        showPass: false,
        copied: { user: false, pass: false },

        init() {
            if (!this.snapToken) return;

            let attempts = 0;
            const maxAttempts = 50;
            const timer = setInterval(() => {
                attempts += 1;
                if (typeof window.snap !== 'undefined') {
                    this.snapReady = true;
                    clearInterval(timer);
                    return;
                }

                if (attempts >= maxAttempts) {
                    this.snapError = 'Gagal memuat Snap Midtrans. Coba refresh halaman atau cek koneksi internet.';
                    clearInterval(timer);
                }
            }, 100);
        },

        openSnap() {
            if (!this.snapToken) return;
            if (typeof window.snap === 'undefined') {
                this.snapError = 'Snap Midtrans belum siap. Coba refresh halaman terlebih dahulu.';
                return;
            }

            this.snapError = '';
            this.isPaying = true;

            window.snap.pay(this.snapToken, {
                onSuccess:  () => window.location.reload(),
                onPending:  () => {
                    this.isPaying = false;
                    this.snapError = 'Pembayaran masih pending. Silakan selesaikan pembayaran dari popup Midtrans.';
                },
                onError:    () => {
                    this.isPaying = false;
                    this.snapError = 'Terjadi error saat proses pembayaran. Silakan coba lagi.';
                },
                onClose:    () => {
                    this.isPaying = false;
                }
            });
        },

        copy(text, key) {
            navigator.clipboard.writeText(text);
            this.copied[key] = true;
            setTimeout(() => this.copied[key] = false, 2000);
        }
    }
}
</script>

@endsection