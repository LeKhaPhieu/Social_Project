<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    const INACTIVATED = 0;
    const ACTIVATED = 1;
    const BLOCKED = 2;

    const MALE = 0;
    const FEMALE = 1;
    const OTHER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $fillable = [
        'user_name',
        'email',
        'password',
        'phone_number',
        'gender',
        'role',
        'status',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function getGenders(): array
    {
        return [
            self::MALE,
            self::FEMALE,
            self::OTHER,
        ];
    }

    public function getStatusNameAttribute(): string
    {
        if ($this->status === self::ACTIVATED) {
            return __('admin.status_activated');
        }
        if ($this->status === self::BLOCKED) {
            return __('admin.status_blocked');
        }
        return __('admin.status_inactivated');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function postLikes(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }

    public function checkLikePost(int $id): bool
    {
        return $this->postLikes()->where('post_id', $id)->exists();
    }

    public function commentLikes(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'likes', 'user_id', 'comment_id');
    }

    public function checkLikeComment(int $id): bool
    {
        return $this->commentLikes()->where('comment_id', $id)->exists();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class, 'user_id');
    }
}
