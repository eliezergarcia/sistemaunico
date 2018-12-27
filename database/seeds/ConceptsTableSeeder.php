<?php

use App\Concepts;
use Illuminate\Database\Seeder;

class ConceptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Concepts::create([
        	'description' => 'O/FREIGHT',
            'curr' => 'USD',
            'rate' => '0'
        ]);
		Concepts::create([
        	'description' => 'A.M.S',
            'curr' => 'USD',
            'rate' => '0'
        ]);
		Concepts::create([
        	'description' => 'CUSTOMS CLEARANCE CHARGE',
            'curr' => 'USD',
            'rate' => '0'
        ]);
		Concepts::create([
        	'description' => 'DOCUMENT FEE',
            'curr' => 'USD',
            'rate' => '0'
        ]);
		Concepts::create([
        	'description' => 'HANDLING COMMISSION',
            'curr' => 'USD',
            'rate' => '0'
        ]);
		Concepts::create([
        	'description' => 'CONTAINER SEAL',
            'curr' => 'USD',
            'rate' => '0'
        ]);
		Concepts::create([
        	'description' => 'INLAND TRUCKING CHRAGE',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        Concepts::create([
        	'description' => 'INSURANCE',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        Concepts::create([
        	'description' => 'SSO',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        Concepts::create([
        	'description' => 'EBS',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        Concepts::create([
        	'description' => 'T.H.C.',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        Concepts::create([
        	'description' => 'TRUCKING CHG',
            'curr' => 'USD',
            'rate' => '0'
        ]);
        Concepts::create([
        	'description' => 'WHARFAGE',
            'curr' => 'USD',
            'rate' => '0'
        ]);
    }
}
