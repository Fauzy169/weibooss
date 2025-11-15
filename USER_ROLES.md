# User Roles & Credentials

Sistem autentikasi dengan berbagai role telah dibuat. Berikut adalah daftar user dan kredensial untuk testing:

## Daftar Role dan Akses Menu

| Role | Email | Password | Akses Filament Admin | Menu yang Bisa Diakses |
|------|-------|----------|---------------------|------------------------|
| **Super Admin** | superadmin@weiboo.com | admin123 | ✅ Ya | SEMUA MENU (Akses Penuh) |
| **Administrator** | admin@weiboo.com | admin123 | ✅ Ya | Dashboard, Users, Brands, Categories |
| **Owner** | owner@weiboo.com | owner123 | ✅ Ya | Dashboard, Semua Menu Laporan |
| **Sales** | sales@weiboo.com | sales123 | ✅ Ya | Dashboard, Semua Menu SalesContent (Banners, Promotions, Services, Aksesoris, Baju Pengantin) |
| **Kasir** | kasir@weiboo.com | kasir123 | ✅ Ya | Dashboard, Kelola Pesanan |
| **Keuangan** | keuangan@weiboo.com | keuangan123 | ✅ Ya | Dashboard, Kelola Pesanan, Pemasukan, Pengeluaran |
| **Gudang** | gudang@weiboo.com | gudang123 | ✅ Ya | Dashboard, Stok & Bahan, Pengadaan |
| **Customer** | customer@weiboo.com | customer123 | ❌ Tidak | HomePage (Tidak bisa akses admin panel) |

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

## Detail Akses Menu per Role

### 🔴 Super Admin
- ✅ Akses ke SEMUA menu tanpa batasan
- Dashboard, Users, Brands, Categories, SalesContent, Keuangan, Gudang, Laporan

### 🟡 Administrator
- ✅ Dashboard
- ✅ Users
- ✅ Brands
- ✅ Categories

### 🔵 Owner
- ✅ Dashboard
- ✅ Laporan Pemasukan
- ✅ Laporan Pengeluaran
- ✅ Laporan Stok Bahan

### 🟢 Sales
- ✅ Dashboard
- ✅ Banners
- ✅ Promotions
- ✅ Services
- ✅ Aksesoris
- ✅ Baju Pengantin

### 🟣 Kasir
- ✅ Dashboard
- ✅ Kelola Pesanan

### ⚫ Keuangan
- ✅ Dashboard
- ✅ Kelola Pesanan
- ✅ Pemasukan
- ✅ Pengeluaran

### ⚫ Gudang
- ✅ Dashboard
- ✅ Stok & Bahan
- ✅ Pengadaan

### ⚫ Customer
- ❌ Tidak bisa mengakses admin panel
- ✅ Hanya bisa akses HomePage untuk berbelanja

## Testing

Untuk testing, gunakan kredensial di atas untuk login ke sistem.

Login URL: `/login`
Admin Panel URL: `/admin`

**Catatan:** Customer tidak akan bisa mengakses `/admin` dan akan diarahkan ke homepage.

## Dashboard Informatif Per Role

Setiap role memiliki dashboard yang disesuaikan dengan informasi yang relevan:

### 🔴 Super Admin Dashboard
- 💰 Profit bulan ini (pemasukan - pengeluaran)
- 💵 Pemasukan hari ini
- 📊 Pemasukan bulan ini
- 📦 Order pending
- ⚠️ Stok menipis
- 👥 Total users (dengan user baru bulan ini)
- 🛍️ Produk aktif/total
- 💸 Pengeluaran bulan ini
- 📋 10 Order terbaru (tabel)
- 📈 Grafik penjualan 7 hari terakhir
- ⚠️ Item dengan stok menipis (tabel)

### 🔵 Owner Dashboard
- 💰 Profit hari ini
- 📊 Profit bulan ini
- 💵 Pemasukan bulan ini
- 💸 Pengeluaran bulan ini
- ⚠️ Stok menipis
- 📦 Order pending
- 📋 10 Order terbaru (tabel)
- 📈 Grafik penjualan 7 hari terakhir

### 🟡 Administrator Dashboard
- 👥 Total users
- 🆕 User baru hari ini
- 👤 Total customer
- 👔 Total staff
- 🏷️ Total brands
- 📂 Total categories

### 🟢 Sales Dashboard
- 🛍️ Order hari ini
- 💰 Penjualan bulan ini
- 👗 Produk aktif/total
- ✨ Service aktif/total
- 🎁 Promosi aktif
- 📊 Konversi (coming soon)

### 🟣 Kasir Dashboard
- 🛒 Order hari ini
- ⏳ Order pending (menunggu pembayaran)
- ⚙️ Order diproses
- ✅ Order selesai hari ini
- 💰 Transaksi hari ini
- ✔️ Order terbayar hari ini
- 📋 10 Order terbaru (tabel)

### ⚫ Keuangan Dashboard
- 💵 Pemasukan hari ini
- 💸 Pengeluaran hari ini
- 📊 Pemasukan bulan ini
- 📉 Pengeluaran bulan ini
- 💰 Saldo bulan ini (pemasukan - pengeluaran)
- 📈 Pemasukan tahun ini
- 📋 10 Order terbaru (tabel)
- 📈 Grafik penjualan 7 hari terakhir

### ⚫ Gudang Dashboard
- 📦 Total item
- ⚠️ Stok menipis (perlu restock)
- 🚨 Stok habis (item dengan stok 0)
- 💰 Nilai total stok
- 📝 Pengadaan pending (menunggu persetujuan)
- ✅ Pengadaan approved (siap diterima)
- ⚠️ Item dengan stok menipis (tabel)

Semua widget dashboard dilengkapi dengan:
- 🎨 **Visual yang informatif** dengan emoji dan warna yang sesuai
- 📊 **Chart mini** untuk data tertentu
- 🔗 **Link langsung** ke halaman terkait
- ⏱️ **Real-time data** yang akurat
