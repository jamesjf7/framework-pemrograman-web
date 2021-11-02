<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory;

    /*  Soft Delete adalah fitur yang digunakan untuk tidak menghapus data secara permanen data dari database melainkan hanya mengubah statusnya menjadi deleted.
        Soft Delete akan menambahkan field 'deleted_at' pada tabel yang bersangkutan.
        Jika field 'deleted_at' null maka data belum dihapus, jika field 'deleted_at' tidak null maka data sudah dihapus.
     */
    use SoftDeletes;

    // attributes
    protected $table = 'users'; // nama tabel (defaultnya akan diasumsikan bentuk plural dari nama model)
    protected $primaryKey = 'id'; // nama kolom primary key (defaultnya id)
    public $incrementing = true; // primary key auto increment (defaultnya true)
    public $timestamps = true; // menandakan tabel memiliki kolom created_at dan updated_at (defaultnya true)

    // relationships
    public function profile()
    {
        // ONE TO ONE
        // keyword: hasOne dan belongsTo
        // Jika foreign key dari tabel yang bersangkutan bukan "user_id" atau local key dari tabel yang bersangkutan bukan "id" maka harus didefinisikan secara manual :
        // - return $this->hasOne(Profile::class, 'foreign_key'); jika local_key = 'id' dan foreign_key != 'user_id'
        // - return $this->hasOne(Profile::class, 'foreign_key', 'local_key'); jika local_key != 'id' dan foreign_key != 'user_id'
        // defaultnya foreign key dari tabel yang bersangkutan adalah "<nama_model>_id"
        return $this->hasOne(Profile::class);
    }

    public function posts()
    {
        // ONE TO MANY
        // keyword: hasMany dan belongsToMany
        // Jika foreign key dari tabel yang bersangkutan bukan "user_id" atau local key dari tabel yang bersangkutan bukan "id" maka harus didefinisikan secara manual :
        // - return $this->hasMany(Post::class, 'foreign_key'); jika local_key = 'id' dan foreign_key != 'user_id'
        // - return $this->hasMany(Post::class, 'foreign_key', 'local_key'); jika local_key != 'id' dan foreign_key != 'user_id'
        return $this->hasMany(Post::class);
    }

    public function groups()
    {
        // MANY TO MANY
        // keyword: belongsToMany
        // Jika foreign key dari tabel yang bersangkutan bukan "user_id" atau local key dari tabel yang bersangkutan bukan "id" maka harus didefinisikan secara manual :
        // - return $this->belongsToMany(Group::class, 'table_name', 'foreign_key', 'local_key'); jika local_key = 'id' dan foreign_key != 'user_id'
        // - return $this->belongsToMany(Group::class, 'table_name', 'foreign_key', 'local_key', 'pivot_local_key', 'pivot_foreign_key'); jika local_key != 'id' dan foreign_key != 'user_id'
        // Jika terdapat data pada tabel pivot maka harus didefinisikan secara manual :
        // - ->withPivot(['pivot_column_name', '...']);
        // ex : return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id', 'id', 'id')->withPivot('created_at', 'updated_at');
        return $this->belongsToMany(Group::class)->withPivot('created_at', 'updated_at');
    }
}
