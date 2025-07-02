<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'major',      // <-- Tambahkan ini
        'university', // <-- Tambahkan ini
        'bio',        // <-- Tambahkan ini
        'profile_photo_path', // <-- Tambahkan ini
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function getProfilePhotoUrlAttribute()
    {
        // Cek apakah ada path foto yang tersimpan di database
        if ($this->profile_photo_path) {
            // Jika ada, buat URL lengkap ke file di folder storage
            return asset('storage/' . $this->profile_photo_path);
        }

        // Jika tidak ada foto, kembalikan URL ke avatar default dengan inisial nama
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
    }


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function moodLogs() 
    {
        return $this->hasMany(MoodLog::class);
    }

    public function tasks() 
    {
        return $this->hasMany(Tasks::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }
    public function comments() 
    {
        return $this->hasMany(Comment::class);
    }
}
