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
        	'name' => 'administrador',
            'display_name' => 'Administración',
            'description' => 'Control de administración'
        ]);
        Role::create([
        	'name' => 'operador',
            'display_name' => 'Operaciones',
            'description' => 'Control de operaciones'
        ]);
        Role::create([
        	'name' => 'facturador',
            'display_name' => 'Facturación',
            'description' => 'Control de facturación'
        ]);
        Role::create([
        	'name' => 'finanzas',
            'display_name' => 'Finanzas',
            'description' => 'Control de finanzas'
        ]);
        Role::create([
            'name' => 'administradorgeneral',
            'display_name' => 'Administración General',
            'description' => 'Administrador del sistema'
        ]);

        DB::table('assigned_roles')->insert([
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 1, 'role_id' => 5],
            ['user_id' => 2, 'role_id' => 1],
            ['user_id' => 2, 'role_id' => 5],
            ['user_id' => 3, 'role_id' => 1],
            ['user_id' => 3, 'role_id' => 4],
            ['user_id' => 4, 'role_id' => 2],
            ['user_id' => 4, 'role_id' => 3],
            ['user_id' => 5, 'role_id' => 1],
            ['user_id' => 5, 'role_id' => 2],
            ['user_id' => 6, 'role_id' => 1],
            ['user_id' => 6, 'role_id' => 2],
            ['user_id' => 7, 'role_id' => 2],
            ['user_id' => 8, 'role_id' => 2],
            ['user_id' => 9, 'role_id' => 2],
            ['user_id' => 10, 'role_id' => 2],
            ['user_id' => 11, 'role_id' => 2],
            ['user_id' => 12, 'role_id' => 2],
        ]);
    }
}
