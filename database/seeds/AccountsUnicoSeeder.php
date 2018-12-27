<?php

use App\AccountUnico;
use Illuminate\Database\Seeder;

class AccountsUnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountUnico::create([
        	'currency' => 'MXN',
            'account' => '65550522702'
        ]);
        AccountUnico::create([
        	'currency' => 'USD',
            'account' => '82500714619'
        ]);
		AccountUnico::create([
        	'currency' => 'DEBIT',
            'account' => '4913270000604960'
        ]);
    }
}
