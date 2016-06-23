<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks = 0");
        Admin::truncate();

        if( env('APP_ENV') == 'development')
        	Admin::create(['email' => 'admin@admin.com', 'name' => 'admin', 'password' => bcrypt('1234')]);
        DB::statement("SET foreign_key_checks = 1");
    }
}
