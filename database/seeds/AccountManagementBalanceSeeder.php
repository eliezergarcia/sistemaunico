<?php

use App\AccountManagementBalance;
use Illuminate\Database\Seeder;

class AccountManagementBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountManagementBalance::create([
        	'mxn' => 610660.01,
            'usd' => 62236.41,
            'debit' => 19970.82
        ]);
    }
}
