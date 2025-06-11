<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // INI BAGIAN YANG MEMPERBAIKI ERRORNYA
        // Tambahkan 'image_path' ke array fillable
    protected $fillable = [
        'title',
        'category',
        'body',
        'image_path', // TAMBAHKAN INI
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
