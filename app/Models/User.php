<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;


/**
 * @property-read DatabaseNotificationCollection<DatabaseNotification> $notifications
 * @property-read DatabaseNotificationCollection<DatabaseNotification> $unreadNotifications
 * @property-read DatabaseNotificationCollection<DatabaseNotification> $readNotifications
 * @method MorphMany notifications()
 * @method MorphMany unreadNotifications()
 * @method MorphMany readNotifications()
 * @method void notify(mixed $notification)
 * @method void notifyNow(mixed $notification)
 */

#[Fillable(['name', 'email', 'password', 'avatar', 'phone', 'bio'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

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

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    // Returns uploaded avatar OR auto-generated letter avatar
    public function avatarUrl(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return Storage::url($this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name)
            . '&size=128&background=6366f1&color=fff&bold=true';
    }
}
