<?php
// File: app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * Menentukan primary key tabel.
     *
     * @var string
     */
    protected $primaryKey = 'kategori_id';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nama_kategori',
        'deskripsi_kategori',
    ];

    /**
     * Mendefinisikan relasi one-to-many ke model Post.
     * Satu Kategori memiliki banyak Post.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'kategori_id', 'kategori_id');
    }
}
