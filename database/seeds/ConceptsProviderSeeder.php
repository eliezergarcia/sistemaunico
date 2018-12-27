<?php

use App\ConceptsProviders;
use Illuminate\Database\Seeder;

class ConceptsProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	ConceptsProviders::create([
        	'description' => 'Garantias',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'O/FREIGHT',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Maniobras',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Trucking',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Estadias',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Flete en falso',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Agencia aduanal',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Rta. Montacargas',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'ISP',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Liberacion de embarque',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Almacenajes',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Demoras',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Royalty',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'HC',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Nota de credito',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Cargos Collect',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Inspeccion',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Cleaning',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Corte M BL',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Pago de BL',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Revalidacion',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        ConceptsProviders::create([
        	'description' => 'Embalaje',
            'curr' => 'USD',
            'rate' => '0'
        ]);

    }
}
