<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'role'
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function enderecos() {
        return $this->hasMany(Endereco::class);
    }
    public function produtos() {
        return $this->hasMany(Produto::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function favorites()
{
    return $this->belongsToMany(Produto::class, 'favorites', 'user_id', 'produto_id')
        ->withTimestamps();
}



public function commentVotes()
{
    return $this->hasMany(CommentVote::class);
}


public function bans()
{
    return $this->hasMany(\App\Models\UserBan::class);
}

public function activeBan()
{
    return $this->hasOne(\App\Models\UserBan::class)
        ->where('active', true)
        ->where(function ($q) {
            $q->whereNull('banned_until')
              ->orWhere('banned_until', '>', now());
        });
}

public function isBanned(): bool
{
    return $this->activeBan()->exists();
}


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
}
