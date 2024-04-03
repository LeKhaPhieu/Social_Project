<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    const LIMIT_ADMIN_PAGE = 5;

    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];
}
