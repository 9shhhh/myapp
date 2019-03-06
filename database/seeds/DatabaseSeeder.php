<?php

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
        // $this->call(UsersTableSeeder::class);

        if(config('database.default')!=='sqlite'){
            DB::statement("SET FOREIGN_KEY_CHECKS=0");
        }

        // model::unguard();

        App\User::truncate();
        $this->call(UsersTableSeeder::class);

        App\Article::truncate();
        $this->call(ArticlesTableSeeder::class);

        // model::reguard();

        if(config('database.default') !== 'sqlite'){
            DB::statement("SET FOREIGN_KEY_CHECKS=1");
        }
    }
}
