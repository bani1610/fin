<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Tasks extends Model
{
    protected $primaryKey = 'task_id';

    protected $fillable = [
        'user_id', 'judul_tugas', 'deskripsi', 'deadline',
        'kategori', 'prioritas', 'beban_kognitif', 'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

        protected function bebanKognitifBadge(): Attribute // <-- PERIKSA NAMA INI DENGAN TELITI
    {
        return Attribute::make(
            get: function () {
                $classMap = [
                    'ringan' => 'bg-green-200 text-green-800',
                    'sedang' => 'bg-yellow-200 text-yellow-800',
                    'berat'  => 'bg-red-200 text-red-800',
                ];

                // Menggunakan null coalescing operator untuk default value jika key tidak ditemukan
                $class = $classMap[$this->beban_kognitif] ?? 'bg-gray-200 text-gray-800';

                return ['class' => $class];
            },
        );
    }
}
