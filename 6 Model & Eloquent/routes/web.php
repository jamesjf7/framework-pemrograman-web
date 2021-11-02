<?php

use App\Http\Controllers\IndexController;
use App\Models\Group;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Jalankan `composer install`
   Buatlah Database dengan nama `tutor_fpw` (sesuai dalam file .env)
   Jalankan `php artisan migrate:fresh --seed` untuk create table dan seed data
   Jalankan `php artisan serve` pada command prompt */


Route::get('/', function () {
    return redirect('/readme');
});

Route::get('/readme', function () {
    return view('readme');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', function () {
        // Get all users dari database
        $users = User::all();
        return view('users', compact('users'));
    });
    Route::get('/{id}', function ($id) {
        $user = User::find($id);

        if (!$user) abort(404); // if not found, redirect to 404

        return view('user', compact('user'));
    });
    Route::post('/store', function () {
        // validasi user
        request()->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:4|confirmed',
        ]);

        // Add User
        $user = new User;
        $user->username = request('username');
        $user->password = request('password');
        $user->save();

        // add empty profile
        $profile = new Profile;
        $profile->user_id = $user->id;
        $profile->save();


        return back()->with('alert', 'User berhasil ditambahkan');
    });
    Route::post('/update', function () {
        // validasi input data
        request()->validate([
            'username' => 'required',
            // 'github' => 'required',
            // 'instagram' => 'required',
            // 'web' => 'required'
        ]);

        // update profile
        $user = User::find(request('user_id'));

        // update username
        $user->username = request('username');
        $user->save();

        // update one to one profile
        $user->profile->github = request('github');
        $user->profile->instagram = request('instagram');
        $user->profile->web = request('web');
        $user->profile->save();

        return back()->with('alert', 'User berhasil diupdate');
    });
});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', function () {
        // Model juga adalah Query Builder
        $posts = Post::orderBy('created_at', 'desc')->get(); // bisa juga Post::latest()->get();

        return view('posts', compact('posts'));
    });
    Route::post('/store', function () {
        // input validation
        request()->validate([
            'content' => 'required',
        ]);

        // get user
        $user = User::find(request('user_id'));

        // TODO: ADD POST
        // Cara Pertama (Eloquent)
        // $post = new Post;
        // $post->content = request('content');
        // $post->user_id = request('user_id');
        // $post->save();

        // Cara Kedua (Menggunakan eloquent & relationship)
        $post = new Post;
        $post->content = request('content');
        $user->posts()->save($post);

        // Cara ketiga (Mass Assignment & Create)
        // - Pastikan model Post memiliki fillable attribute (atribut yang bisa diisi) atau guarded attribute (atribut yang tidak bisa diisi)
        // Post::create([
        //     'content' => request('content'),
        //     'user_id' => request('user_id')
        // ]);
        // bisa juga
        // $user->posts()->create([
        //     'content' => request('content')
        // ]);
        return back()->with('alert', 'Post berhasil ditambahkan');
    });
    Route::post('/delete/{id}', function ($id) {
        // simple delete
        // $post = Post::find($id);
        // $post->delete();

        // delete by primary key
        Post::destroy($id); // bisa multiple primary key ex: Post::destroy([1,2,3]); / Post::destroy(1,2,3);


        return back();
    });
});

Route::group(['prefix' => 'groups'], function () {
    Route::get('/', function () {
        $groups = Group::all();
        return view('groups', compact('groups'));
    });
    Route::get('/{code}', function ($code) {
        $group = Group::where('code', $code)->first();

        if (!$group) abort(404); // if not found, redirect to 404

        return view('group', compact('group'));
    });
    Route::post('/store', function () {
        // input validation
        request()->validate([
            'name' => 'required',
        ]);

        // add group
        $group = new Group;
        $group->name = request('name');
        $group->code = substr(md5(time()), 0, 10);
        $group->save();

        return back()->with('alert', 'Group berhasil ditambahkan');
    });
    Route::post('/join', function () {
        // join group
        $user = User::find(request('user_id'));
        $group = Group::where('code', request('code'))->first();

        // if code valid
        if (!$group) {
            return back()->with('alert', 'Group tidak ditemukan');
        }

        // check if user already joined
        if ($user->groups->contains($group)) {
            return back()->with('alert', 'User sudah join group');
        } else {
            // Insert into pivot table menggunakan attach($id)
            $user->groups()->attach($group);
            return back()->with('alert', 'User berhasil join group');
            // Jika ingin menambahkan data ke pivot table
            // $user->groups()->attach($group, ['role' => 'member']);
        }

        return back();
    });
    Route::post('/leave', function () {
        // leave group
        $user = User::find(request('user_id'));
        $group = Group::where('code', request('code'))->first();

        // delete menggunakan detach($id)
        $user->groups()->detach($group);
        return back()->with('alert', 'User berhasil leave group');
    });
});
