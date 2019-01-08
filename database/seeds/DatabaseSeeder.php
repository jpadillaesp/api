<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //Model::unguard();
        // $this->call('UsersTableSeeder');
        User::truncate();
        Post::truncate();
        factory(App\User::class, 10)->create()->each(function($user){
            $post = factory(App\Orchestrator::class)->make();
            $user->posts()->save($post);
        });
        //Model::reguard();
    }

}
