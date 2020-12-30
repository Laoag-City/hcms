<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'administrator',
            'full_name' => 'Administrator',
            'password' => bcrypt('city_health_admin'),
            'admin' => true
        ]);
    }
}
