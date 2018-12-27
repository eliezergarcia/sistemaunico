<?php

use App\Provider;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::create([
        	'codigo_proveedor' => 'SIN PROVEEDOR',
            'razon_social' => 'SIN PROVEEDOR'
        ]);
    }
}