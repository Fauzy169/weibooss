<?php

namespace App\Filament\Traits;

use Illuminate\Support\Facades\Auth;

trait HasRoleAuthorization
{
    public static function canAccess(): bool
    {
        $user = Auth::user();
        
        // Super admin has access to everything
        if ($user && $user->role === 'super_admin') {
            return true;
        }
        
        // Get allowed roles for this resource
        $allowedRoles = static::getAllowedRoles();
        
        return $user && in_array($user->role, $allowedRoles);
    }

    public static function canViewAny(): bool
    {
        return static::canAccess();
    }

    public static function canCreate(): bool
    {
        return static::canAccess();
    }

    public static function canEdit($record): bool
    {
        return static::canAccess();
    }

    public static function canDelete($record): bool
    {
        return static::canAccess();
    }

    /**
     * Override this method in your resource to define allowed roles
     * Super admin is always allowed by default
     */
    protected static function getAllowedRoles(): array
    {
        return ['super_admin', 'administrator', 'owner'];
    }
}
