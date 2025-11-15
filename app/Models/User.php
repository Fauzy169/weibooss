<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Customer tidak bisa akses admin panel
        // Hanya staff dan admin yang bisa akses
        return $this->hasAnyRole(['super_admin', 'administrator', 'owner', 'keuangan', 'gudang', 'sales', 'kasir']);
    }

    // Helper methods for checking roles
    public function isAdministrator(): bool
    {
        return $this->role === 'administrator';
    }
    
    public function isAdmin(): bool
    {
        return $this->role === 'administrator';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isSales(): bool
    {
        return $this->role === 'sales';
    }

    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

    public function isKeuangan(): bool
    {
        return $this->role === 'keuangan';
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isGudang(): bool
    {
        return $this->role === 'gudang';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'super_admin' => 'Super Administrator',
            'administrator' => 'Administrator',
            'owner' => 'Owner',
            'keuangan' => 'Keuangan',
            'gudang' => 'Gudang',
            'sales' => 'Sales',
            'kasir' => 'Kasir',
            'customer' => 'Customer',
            default => ucfirst($this->role),
        };
    }
}
