<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(['username' => 'administrator'], [
            'full_name' => 'Administrator',
            'password' => bcrypt('city_health_admin'),
            'admin' => true
        ]);
    }
}
