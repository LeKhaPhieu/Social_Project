<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    const PENDING = 1;
    const NOT_APPROVED = 2;
    const APPROVED = 3;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id');
    }

    public function getStatusNameAttribute(): string
    {
        if ($this->status === self::APPROVED) {
            return __('admin.status_approved');
        }
        if ($this->status === self::NOT_APPROVED) {
            return __('admin.status_blocked');
        }
        return __('admin.status_pending');
    }

    public static function getStatus(): array
    {
        return [
            self::PENDING => __('admin.status_pending'),
            self::NOT_APPROVED => __('admin.status_blocked'),
            self::APPROVED =>  __('admin.status_approved'),
        ];
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', self::APPROVED);
    }
}
