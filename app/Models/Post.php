<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Mendefinisikan primary key secara eksplisit.
     * @var string
     */
    protected $primaryKey = 'post_id';

    /**
     * Atribut yang dapat diisi.
     * @var array
     */
    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'isi_post',
        'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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