<?php

use App\Role;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
        	'name' => 'admin',
            'display_name' => 'Administrador',
            'description' => 'Administrador del sistema'
        ]);
        Role::create([
        	'name' => 'oper',
            'display_name' => 'Operaciones',
            'description' => 'Control de operaciones'
        ]);
        Role::create([
        	'name' => 'fact',
            'display_name' => 'Facturación',
            'description' => 'Control de facturación'
        ]);
        Role::create([
        	'name' => 'pag',
            'display_name' => 'Pagos',
            'description' => 'Control de pagos'
        ]);
    }
}
