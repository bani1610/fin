<?php
// File: app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    /**
     * Menentukan primary key tabel.
     *
     * @var string
     */
    protected $primaryKey = 'post_id';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'isi_post',
        'image_path',
        'mood_tag',
    ];

    /**
     * Mendefinisikan relasi "belongs to" ke model User.
     * Setiap Post dimiliki oleh satu User.
     */
        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id', 'kategori_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'post_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
    }
    

}
