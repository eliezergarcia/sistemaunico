<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'Eliezer Hernández',
            'user_name' => 'eliezerhdz',
            'email' => 'eliezer@email.com',            
            'password' => bcrypt('123412'),
            'avatar' => 'public/eliezeradmin.jpg',
            'phone' => '(52) 8129368475'
        ]);

        factory(App\User::class, 10)->create();

        // Schema::table('assigned_roles', function ($table) {
        //     $table->create([
        //         'user_id' => '1',
        //         'role_id' => '1'
        //     ]);
        // });
    }
}
