<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    /**
     * Check if user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Explicitly assigned applications.
     */
    public function apps(): BelongsToMany
    {
        return $this->belongsToMany(App::class);
    }

    /**
     * Get all accessible active applications.
     * Admins have access to ALL active apps.
     * Users have access only to assigned active apps.
     */
    public function accessibleApps()
    {
        if ($this->isAdmin()) {
            return App::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('name', 'asc')
                ->get();
        }

        return $this->apps()
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Check if the user can access a specific app by ID or code.
     */
    public function canAccessApp($appIdentifier): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->apps()
            ->where('is_active', true)
            ->where(function ($query) use ($appIdentifier) {
                if (is_numeric($appIdentifier)) {
                    $query->where('apps.id', $appIdentifier);
                } else {
                    $query->where('apps.code', $appIdentifier);
                }
            })
            ->exists();
    }
}
