# User Roles & Credentials

Sistem autentikasi dengan berbagai role telah dibuat. Berikut adalah daftar user dan kredensial untuk testing:

## Daftar Role dan Akses

| Role | Email | Password | Akses Filament Admin | Deskripsi |
|------|-------|----------|---------------------|-----------|
| **Administrator** | admin@weiboo.com | admin123 | ✅ Ya | Akses penuh ke semua fitur sistem |
| **Customer** | customer@weiboo.com | customer123 | ❌ Tidak | Pelanggan yang berbelanja |
| **Sales** | sales@weiboo.com | sales123 | ❌ Tidak | Tim penjualan |
| **Kasir** | kasir@weiboo.com | kasir123 | ❌ Tidak | Kasir untuk transaksi |
| **Keuangan** | keuangan@weiboo.com | keuangan123 | ✅ Ya | Bagian keuangan dengan akses admin |
| **Owner** | owner@weiboo.com | owner123 | ✅ Ya | Pemilik dengan akses admin penuh |
| **Gudang** | gudang@weiboo.com | gudang123 | ✅ Ya | Pengelola gudang dengan akses admin |

## Cara Menggunakan Middleware Role

Untuk melindungi route dengan role tertentu, gunakan middleware `role`:

```php
// Single role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:administrator']);

// Multiple roles
Route::get('/reports', [ReportController::class, 'index'])
    ->middleware(['auth', 'role:administrator,owner,keuangan']);

// Group routes
Route::middleware(['auth', 'role:administrator,owner'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::get('/users', [UserController::class, 'index']);
});
```

## Helper Methods di Model User

```php
// Cek role spesifik
$user->isAdministrator(); // atau $user->isAdmin()
$user->isCustomer();
$user->isSales();
$user->isKasir();
$user->isKeuangan();
$user->isOwner();
$user->isGudang();

// Cek role dengan parameter
$user->hasRole('administrator');

// Cek multiple roles
$user->hasAnyRole(['administrator', 'owner', 'keuangan']);
```

## Akses Panel Filament

User dengan role berikut dapat mengakses Filament Admin Panel:
- Administrator
- Owner
- Keuangan
- Gudang

## Testing

Untuk testing, gunakan kredensial di atas untuk login ke sistem.

Login URL: `/login`
Admin Panel URL: `/admin`
