<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content'];

    public function user()
    {
        // ONE TO MANY (inversed)
        // Jika foreign_key dari tabel yang bersangkutan bukan "user_id" atau other_key dari tabel yang bersangkutan bukan "id" maka harus didefinisikan secara manual :
        // - return $this->hasMany(Post::class, 'foreign_key'); jika foreign = 'user_id' dan other_key != 'id'
        // - return $this->hasMany(Post::class, 'foreign_key', 'other_key'); jika foreign != 'user_id' dan other_key != 'id'
        return $this->belongsTo(User::class);
    }
}
