<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'phone',
        'password',
        'balance',
        'is_merchant'
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
    protected $casts = [
        'password' => 'hashed',
        'is_merchant' => 'boolean',
        'balance' => 'decimal:2',
    ];

    public function merchant(): HasOne
    {
        return $this->hasOne(Merchant::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function encryptedValues(): HasMany
    {
        return $this->hasMany(EncryptedValue::class);
    }

    public function merchantPayments(): HasMany
    {
        return $this->hasMany(MerchantPayment::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    #[SearchUsingFullText(['phone', 'email', 'id', 'name'])]
    public function toSearchableArray(): array
    {

        return array_merge($this->toArray(),[
            'id' => (string) $this->id,
            'name' => $this->name ?? '',
            'email' => $this->email ?? '',
            'phone' => $this->phone ?? '',
            'balance' => (float) $this->balance,
            'is_merchant' => (bool) $this->is_merchant,
            'created_at' => $this->created_at ? $this->created_at->timestamp : time(),
        ]);
    }

    public function searchableAs(): string
    {
        return 'users';
    }

    public function shouldBeSearchable(): bool
    {
        return true;
    }
}
