<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderPaymentController extends Controller
{
    public function confirmPayment(Request $request, $orderId)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,transfer',
            'payment_proof' => 'nullable|image|max:2048',
            'payment_notes' => 'nullable|string',
            'new_status' => 'required|in:paid,processing,completed',
        ]);

        $order = Order::findOrFail($orderId);

        // Cek apakah sudah completed atau canceled
        if (in_array($order->status, ['completed', 'canceled'])) {
            return redirect()
                ->route('filament.admin.resources.orders.view', $orderId)
                ->with('error', 'Pesanan dengan status ' . $order->status . ' tidak dapat diubah.');
        }

        $updateData = [
            'status' => $validated['new_status'],
        ];

        // Jika pembayaran belum pernah dikonfirmasi, simpan info pembayaran
        if (!$order->payment_confirmed_at) {
            $paymentProofPath = $order->payment_proof;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
            }

            $updateData = array_merge($updateData, [
                'payment_method' => $validated['payment_method'],
                'payment_proof' => $paymentProofPath,
                'payment_notes' => $validated['payment_notes'],
                'payment_confirmed_at' => now(),
                'confirmed_by' => Auth::id(),
            ]);

            $message = 'Pembayaran pesanan #' . $orderId . ' telah berhasil dikonfirmasi dan status diupdate ke ' . $validated['new_status'] . '.';
        } else {
            // Jika sudah dikonfirmasi, hanya update status
            $message = 'Status pesanan #' . $orderId . ' berhasil diupdate ke ' . $validated['new_status'] . '.';
        }

        $order->update($updateData);

        return redirect()
            ->route('filament.admin.resources.orders.view', $orderId)
            ->with('success', $message);
    }
}
