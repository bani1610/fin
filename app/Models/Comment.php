<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * Menentukan primary key tabel.
     *
     * @var string
     */
    protected $primaryKey = 'comment_id';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'isi_komentar',
        'parent_comment_id', // Untuk fitur balasan komentar
    ];

    /**
     * Mendefinisikan relasi "belongs to" ke model Post.
     * Setiap Comment terikat pada satu Post.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    /**
     * Mendefinisikan relasi "belongs to" ke model User.
     * Setiap Comment ditulis oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
