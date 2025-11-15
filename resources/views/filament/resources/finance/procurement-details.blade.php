@php
    $statusColors = [
        'draft' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
        'requested' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
        'approved' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
        'received' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
        'canceled' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
    ];
    $statusLabels = [
        'draft' => 'Draft',
        'requested' => 'Menunggu Persetujuan',
        'approved' => 'Disetujui',
        'received' => 'Diterima',
        'canceled' => 'Dibatalkan',
    ];
@endphp

<div class="p-6 space-y-6">
    {{-- Header Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $record->code }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Detail Pengadaan Barang</p>
            </div>
            <span class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $statusColors[$record->status] ?? 'bg-gray-100 text-gray-700' }}">
                {{ $statusLabels[$record->status] ?? ucfirst($record->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="space-y-1">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal Pengajuan</p>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                    {{ $record->requested_at ? $record->requested_at->format('d M Y') : '-' }}
                </p>
                @if($record->requested_at)
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $record->requested_at->format('H:i') }} WIB</p>
                @endif
            </div>

            <div class="space-y-1">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal Disetujui</p>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                    {{ $record->approved_at ? $record->approved_at->format('d M Y') : '-' }}
                </p>
                @if($record->approved_at)
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $record->approved_at->format('H:i') }} WIB</p>
                @endif
            </div>

            <div class="space-y-1">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal Diterima</p>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                    {{ $record->received_at ? $record->received_at->format('d M Y') : '-' }}
                </p>
                @if($record->received_at)
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $record->received_at->format('H:i') }} WIB</p>
                @endif
            </div>

            <div class="space-y-1">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Biaya</p>
                <p class="text-base font-bold text-orange-600 dark:text-orange-400">
                    Rp {{ number_format($record->total_cost ?? $record->items->sum('subtotal'), 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $record->items->count() }} Item</p>
            </div>
        </div>

        @if($record->notes)
        <div class="mt-5 pt-5 border-t border-gray-200 dark:border-gray-700">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Catatan</p>
            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $record->notes }}</p>
        </div>
        @endif
    </div>

    {{-- Items Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h4 class="text-base font-semibold text-gray-900 dark:text-white">Daftar Item yang Dipesan</h4>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">No</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Nama Item</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($record->items as $index => $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->name }}</div>
                            @if($item->description)
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $item->description }}</div>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900 dark:text-white">
                            {{ number_format($item->qty, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-right text-sm text-gray-900 dark:text-white">
                            Rp {{ number_format($item->unit_cost, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-900 dark:text-white">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                            Tidak ada item yang dipesan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($record->items->count() > 0)
                <tfoot class="bg-gray-50 dark:bg-gray-900">
                    <tr class="border-t-2 border-gray-300 dark:border-gray-600">
                        <td colspan="4" class="px-5 py-4 text-right text-sm font-bold text-gray-900 dark:text-white uppercase">
                            Total Keseluruhan
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-right text-base font-bold text-orange-600 dark:text-orange-400">
                            Rp {{ number_format($record->items->sum('subtotal'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
