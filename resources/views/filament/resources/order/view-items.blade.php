<div class="rounded-lg border border-gray-200 overflow-hidden">
    <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Produk/Layanan
                </th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Qty
                </th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Harga
                </th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Subtotal
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($getRecord()->items as $item)
            <tr>
                <td class="px-4 py-3 text-sm text-gray-900">
                    {{ $item->name }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                    {{ $item->qty }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-900 text-right">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
            <tr class="bg-gray-50">
                <td colspan="3" class="px-4 py-3 text-sm font-bold text-gray-900 text-right">
                    TOTAL:
                </td>
                <td class="px-4 py-3 text-lg font-bold text-green-600 text-right">
                    Rp {{ number_format($getRecord()->total, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
