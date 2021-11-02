<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Group::factory(6)->create();

        User::factory(5)->create()->each(function ($user) {
            $user->profile()->save(Profile::factory()->make());
            $user->groups()->attach($this->arrayNum(rand(2, 4)));
        });

        Post::factory(15)->create();
    }

    private function arrayNum($max)
    {
        $values = [];

        for ($i = 1; $i < $max; $i++) {
            $values[] = $i;
        }

        return $values;
    }
}
