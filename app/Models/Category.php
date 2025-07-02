<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Mendefinisikan primary key secara eksplisit.
     * @var string
     */
    protected $primaryKey = 'kategori_id';

    /**
     * Atribut yang dapat diisi.
     * @var array
     */
    protected $fillable = [
        'nama_kategori',
        'deskripsi_kategori',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'kategori_id', 'kategori_id');
    }
}