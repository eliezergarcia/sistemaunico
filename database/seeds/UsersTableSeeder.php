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
            'email' => '2dcc.eh@gmail.com',
            'password' => '123412',
            'avatar' => 'public/eliezeradmin.jpg',
            'phone' => '(52) 8129368475',
            'address' => 'Juárez, Nuevo León',
            'email_office' => 'eliezer@email.com',
            'password_email_office' => '1234'
        ]);

        User::create([
            'name' => 'Young Rak Kim',
            'user_name' => 'youngkim',
            'email' => 'young.kim@email.com',
            'password' => '123412'
        ]);

        User::create([
            'name' => 'Edith Valdéz',
            'user_name' => 'edithvaldez',
            'email' => 'edith.valdez@email.com',
            'password' => '123412'
        ]);

        User::create([
            'name' => 'Placida Durán',
            'user_name' => 'placidaduran',
            'email' => 'placida.duran@email.com',
            'password' => '123412'
        ]);

        User::create([
            'name' => 'Dinorah Cisneros',
            'user_name' => 'dinorahcisneros',
            'email' => 'dinorah@unicologx.com.mx',
            'password' => '123412'
        ]);

        User::create([
            'name' => 'Julia Joo',
            'user_name' => 'juliajoo',
            'email' => 'julia@unicologx.com.mx',
            'password' => '123412'
        ]);

        User::create([
            'name' => 'Karina González',
            'user_name' => 'karinagzz',
            'email' => 'karina@unicologx.com.mx',
            'password' => '123412'
        ]);

        User::create([
            'name' => 'Susana Aragón',
            'user_name' => 'susanaaragon',
            'email' => 'susana@unicologx.com.mx',
            'password' => '123412'
        ]);

        User::create([
            'name' => 'Karen Ortiz',
            'user_name' => 'karenortiz',
            'email' => 'karen@unicologx.com.mx',
            'password' => '123412'
        ]);

        User::create([
            'name' => 'Erika Nava',
            'user_name' => 'erikanava',
            'email' => 'erika@unicologx.com.mx',
            'password' => '123412'
        ]);

        User::create([
            'name' => 'Maleny Hernández',
            'user_name' => 'malenyhdz',
            'email' => 'maleny@unicologx.com.mx',
            'password' => '123412'
        ]);

        User::create([
            'name' => 'Diego Barrera',
            'user_name' => 'diegobarrera',
            'email' => 'diego@unicologx.com.mx',
            'password' => '123412'
        ]);

        // factory(App\User::class, 9)->create();
    }
}
