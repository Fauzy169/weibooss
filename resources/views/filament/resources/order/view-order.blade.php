<x-filament-panels::page>
    @if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.5); border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem; color: #10B981;">
        <strong>✓ Berhasil!</strong> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.5); border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem; color: #EF4444;">
        <strong>✗ Error!</strong> {{ session('error') }}
    </div>
    @endif

    <style>
        .order-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .order-card h3 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }
        .order-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }
        .order-field label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            opacity: 0.7;
            margin-bottom: 0.375rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        .order-field p {
            font-size: 1rem;
            font-weight: 500;
        }
        .status-badge {
            display: inline-flex;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2);
        }
        .status-pending { background: #FEF3C7; color: #92400E; border: 1px solid #FCD34D; }
        .status-paid { background: #DBEAFE; color: #1E40AF; border: 1px solid #93C5FD; }
        .status-processing { background: #E0E7FF; color: #5B21B6; border: 1px solid #A5B4FC; }
        .status-completed { background: #D1FAE5; color: #065F46; border: 1px solid #6EE7B7; }
        .status-canceled { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }
        .total-price {
            font-size: 1.75rem;
            font-weight: 700;
            color: #10B981;
        }
        .items-table {
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        .items-table thead {
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .items-table th {
            padding: 0.875rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .items-table td {
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        .items-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }
        .items-table tfoot td {
            background: rgba(16, 185, 129, 0.1);
            font-weight: 700;
            padding: 1rem;
            border-top: 2px solid rgba(16, 185, 129, 0.3);
        }
        .items-table tfoot .total-text {
            color: #10B981;
            font-size: 1.125rem;
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: rgba(75, 85, 99, 0.8);
            color: white;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .back-button:hover {
            background: rgba(55, 65, 81, 0.9);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3);
        }
        .payment-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            opacity: 0.8;
        }
        .payment-method-option {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .payment-method-option:has(input:checked) {
            background: rgba(59, 130, 246, 0.2);
            border-color: rgba(59, 130, 246, 0.5);
        }
        .payment-method-option input[type="radio"] {
            margin-right: 0.5rem;
        }
        .payment-method-label {
            font-size: 0.875rem;
            font-weight: 600;
        }
        .file-input {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            cursor: pointer;
        }
        .file-input:hover {
            background: rgba(255, 255, 255, 0.08);
        }
        .textarea-input {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            resize: vertical;
            font-family: inherit;
        }
        .textarea-input:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(255, 255, 255, 0.08);
        }
        .select-input {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            cursor: pointer;
            color: inherit;
        }
        .select-input:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(255, 255, 255, 0.08);
        }
        .select-input option {
            background: #1F2937;
            color: white;
            padding: 0.5rem;
        }
        .confirm-button {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 5px 0 rgba(16, 185, 129, 0.3);
        }
        .confirm-button:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px 0 rgba(16, 185, 129, 0.4);
        }
    </style>

    <div>
        {{-- Informasi Pesanan --}}
        <div class="order-card">
            <h3>Informasi Pesanan</h3>
            <div class="order-grid">
                <div class="order-field">
                    <label>Order ID</label>
                    <p>#{{ $record->id }}</p>
                </div>
                <div class="order-field">
                    <label>Tanggal Order</label>
                    <p>{{ $record->placed_at ? $record->placed_at->format('d M Y, H:i') : '-' }}</p>
                </div>
                <div class="order-field">
                    <label>Customer</label>
                    <p>{{ $record->user->name }}</p>
                </div>
                <div class="order-field">
                    <label>Email</label>
                    <p>{{ $record->user->email }}</p>
                </div>
            </div>
        </div>

        {{-- Status & Pembayaran --}}
        <div class="order-card">
            <h3>Status & Pembayaran</h3>
            <div class="order-grid">
                <div class="order-field">
                    <label>Status</label>
                    <div style="margin-top: 0.5rem;">
                        @php
                            $statusConfig = [
                                'pending' => ['label' => 'Pending - Menunggu Pembayaran', 'class' => 'status-pending'],
                                'paid' => ['label' => 'Paid - Sudah Dibayar', 'class' => 'status-paid'],
                                'processing' => ['label' => 'Processing - Sedang Diproses', 'class' => 'status-processing'],
                                'completed' => ['label' => 'Completed - Selesai', 'class' => 'status-completed'],
                                'canceled' => ['label' => 'Canceled - Dibatalkan', 'class' => 'status-canceled'],
                            ];
                            $status = $statusConfig[$record->status] ?? ['label' => $record->status, 'class' => 'status-pending'];
                        @endphp
                        <span class="status-badge {{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>
                </div>
                <div class="order-field">
                    <label>Total Pembayaran</label>
                    <p class="total-price">Rp {{ number_format($record->total, 0, ',', '.') }}</p>
                </div>
                @if($record->notes)
                <div class="order-field" style="grid-column: span 2;">
                    <label>Catatan</label>
                    <p>{{ $record->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Detail Item Pesanan --}}
        <div class="order-card">
            <h3>Detail Item Pesanan</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="text-align: left;">Produk/Layanan</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Harga</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($record->items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td style="text-align: center;">{{ $item->qty }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: right; font-weight: 600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;" class="total-text">TOTAL:</td>
                        <td style="text-align: right;" class="total-text">
                            Rp {{ number_format($record->total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Form Konfirmasi Pembayaran --}}
        @if($record->status !== 'completed' && $record->status !== 'canceled')
        <div class="order-card">
            <h3>{{ $record->payment_confirmed_at ? 'Update Status Pesanan' : 'Konfirmasi Pembayaran' }}</h3>
            
            <form action="{{ route('filament.admin.resources.orders.confirm-payment', $record->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                @csrf
                
                @if(!$record->payment_confirmed_at)
                {{-- Form Konfirmasi Pembayaran Pertama Kali --}}
                <div style="margin-bottom: 1.5rem;">
                    <label class="payment-label">Metode Pembayaran</label>
                    <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
                        <label class="payment-method-option">
                            <input type="radio" name="payment_method" value="cash" checked onchange="togglePaymentProof()">
                            <span class="payment-method-label">💵 Cash</span>
                        </label>
                        <label class="payment-method-option">
                            <input type="radio" name="payment_method" value="transfer" onchange="togglePaymentProof()">
                            <span class="payment-method-label">🏦 Transfer Bank</span>
                        </label>
                    </div>
                </div>

                <div id="transferProof" style="display: none; margin-bottom: 1.5rem;">
                    <label class="payment-label">Bukti Transfer</label>
                    <input type="file" name="payment_proof" accept="image/*" class="file-input">
                    <p style="font-size: 0.75rem; opacity: 0.6; margin-top: 0.5rem;">Upload foto bukti transfer (JPG, PNG, max 2MB)</p>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label class="payment-label">Catatan Pembayaran (Opsional)</label>
                    <textarea name="payment_notes" rows="3" class="textarea-input" placeholder="Tambahkan catatan tentang pembayaran...">{{ old('payment_notes', $record->payment_notes) }}</textarea>
                </div>
                @else
                {{-- Update Status Setelah Pembayaran Dikonfirmasi --}}
                <input type="hidden" name="payment_method" value="{{ $record->payment_method }}">
                <input type="hidden" name="payment_notes" value="{{ $record->payment_notes }}">
                
                <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem;">
                    <p style="font-size: 0.875rem; opacity: 0.9;">
                        ℹ️ <strong>Pembayaran telah dikonfirmasi</strong><br>
                        Anda hanya dapat mengubah status pesanan. Untuk mengubah metode pembayaran atau bukti transfer, hubungi administrator.
                    </p>
                </div>
                @endif

                <div style="margin-bottom: 1.5rem;">
                    <label class="payment-label">Update Status Pesanan</label>
                    <select name="new_status" class="select-input" required>
                        @if(!$record->payment_confirmed_at || in_array($record->status, ['pending', 'placed']))
                        <option value="paid" {{ in_array($record->status, ['pending', 'placed']) ? 'selected' : '' }}>✅ Paid - Sudah Dibayar</option>
                        @endif
                        @if($record->payment_confirmed_at || $record->status === 'paid')
                        <option value="processing" {{ $record->status === 'paid' ? 'selected' : '' }}>⚙️ Processing - Sedang Diproses</option>
                        @endif
                        @if($record->payment_confirmed_at || in_array($record->status, ['paid', 'processing']))
                        <option value="completed" {{ $record->status === 'processing' ? 'selected' : '' }}>✔️ Completed - Selesai</option>
                        @endif
                    </select>
                    <p style="font-size: 0.75rem; opacity: 0.6; margin-top: 0.5rem;">
                        @if(!$record->payment_confirmed_at)
                        Status pesanan akan diupdate setelah konfirmasi pembayaran
                        @else
                        Pilih status berikutnya untuk pesanan ini
                        @endif
                    </p>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="submit" class="confirm-button">
                        @if(!$record->payment_confirmed_at)
                        <span style="margin-right: 0.5rem;">✓</span> Konfirmasi Pembayaran
                        @else
                        <span style="margin-right: 0.5rem;">🔄</span> Update Status Pesanan
                        @endif
                    </button>
                </div>
            </form>
        </div>
        @endif

        {{-- Riwayat Pembayaran --}}
        @if($record->payment_confirmed_at)
        <div class="order-card">
            <h3>Informasi Pembayaran</h3>
            <div class="order-grid">
                <div class="order-field">
                    <label>Metode Pembayaran</label>
                    <p>{{ $record->payment_method === 'cash' ? '💵 Cash' : '🏦 Transfer Bank' }}</p>
                </div>
                
                <div class="order-field">
                    <label>Dikonfirmasi Pada</label>
                    <p>{{ $record->payment_confirmed_at->format('d M Y, H:i') }}</p>
                </div>

                @if($record->confirmedBy)
                <div class="order-field">
                    <label>Dikonfirmasi Oleh</label>
                    <p>{{ $record->confirmedBy->name }} ({{ ucfirst($record->confirmedBy->role) }})</p>
                </div>
                @endif

                @if($record->payment_notes)
                <div class="order-field" style="grid-column: span 2;">
                    <label>Catatan Pembayaran</label>
                    <p>{{ $record->payment_notes }}</p>
                </div>
                @endif

                @if($record->payment_proof)
                <div class="order-field" style="grid-column: span 2;">
                    <label>Bukti Transfer</label>
                    <div style="margin-top: 0.5rem;">
                        <a href="{{ asset('storage/' . $record->payment_proof) }}" target="_blank" style="display: inline-block;">
                            <img src="{{ asset('storage/' . $record->payment_proof) }}" alt="Bukti Transfer" style="max-width: 300px; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.2); cursor: pointer; transition: transform 0.2s;">
                        </a>
                        <p style="font-size: 0.75rem; opacity: 0.6; margin-top: 0.5rem;">Klik gambar untuk melihat ukuran penuh</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Tombol Kembali --}}
        <div style="text-align: right; margin-top: 1.5rem;">
            <a href="{{ route('filament.admin.resources.orders.index') }}" class="back-button">
                ← Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>

    <script>
        function togglePaymentProof() {
            const transferProof = document.getElementById('transferProof');
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const fileInput = document.querySelector('input[name="payment_proof"]');
            
            if (paymentMethod === 'transfer') {
                transferProof.style.display = 'block';
                fileInput.setAttribute('required', 'required');
            } else {
                transferProof.style.display = 'none';
                fileInput.removeAttribute('required');
            }
        }

        // Form validation
        document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const fileInput = document.querySelector('input[name="payment_proof"]');
            
            if (paymentMethod === 'transfer' && !fileInput.files.length) {
                e.preventDefault();
                alert('⚠️ Harap upload bukti transfer untuk metode pembayaran transfer!');
                return false;
            }

            const confirmMsg = paymentMethod === 'cash' 
                ? '💵 Konfirmasi pembayaran CASH untuk pesanan #{{ $record->id }}?\n\nTotal: Rp {{ number_format($record->total, 0, ",", ".") }}'
                : '🏦 Konfirmasi pembayaran TRANSFER untuk pesanan #{{ $record->id }}?\n\nTotal: Rp {{ number_format($record->total, 0, ",", ".") }}';
            
            if (!confirm(confirmMsg)) {
                e.preventDefault();
                return false;
            }
        });
    </script>
</x-filament-panels::page>
