<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Token extends Model
{
    use HasFactory;

    const EFFECT = 0;
    const EXPIRE = 1;

    protected $table = 'tokens';

    protected $fillable = [
        'token_verify_email',
        'token_reset_password',
        'user_id',
        'status',
    ];
}
