<?php

use App\ExpenseService;
use Illuminate\Database\Seeder;

class ExpenseServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpenseService::create([
        	'numero_usuario' => '5556174-01',
            'servicio' => 'PAYMENT WATER LOC 2',
            'concepto_pago' => 'LOC 2'
        ]);
        ExpenseService::create([
        	'numero_usuario' => '',
            'servicio' => 'PAYMENT WATER LOC 3',
            'concepto_pago' => 'LOC 3'
        ]);
        ExpenseService::create([
        	'numero_usuario' => '370 100 701  377',
            'servicio' => 'PAYMENT ELECTRICITY LOC 2',
            'concepto_pago' => 'LOC 2'
        ]);
        ExpenseService::create([
        	'numero_usuario' => '',
            'servicio' => 'PAYMENT ELECTRICITY LOC 3',
            'concepto_pago' => 'LOC 3'
        ]);
        ExpenseService::create([
        	'numero_usuario' => '8110909472',
            'servicio' => 'TELMEX 8110909472',
            'concepto_pago' => 'MENSUAL'
        ]);
        ExpenseService::create([
            'numero_usuario' => '8110908987',
            'servicio' => 'TELMEX 8110908987',
            'concepto_pago' => 'MENSUAL'
        ]);
        ExpenseService::create([
            'numero_usuario' => '8110909603',
            'servicio' => 'TELMEX 8110909603',
            'concepto_pago' => 'MENSUAL'
        ]);
        ExpenseService::create([
        	'numero_usuario' => '127152775',
            'servicio' => 'NEXTEL',
            'concepto_pago' => 'MENSUAL'
        ]);
        ExpenseService::create([
        	'numero_usuario' => 'N/A',
            'servicio' => 'RCV',
            'concepto_pago' => '17 DE CADA DOS MESES'
        ]);
        ExpenseService::create([
        	'numero_usuario' => 'N/A',
            'servicio' => 'IMSS',
            'concepto_pago' => '17 DE CADA MES'
        ]);
        ExpenseService::create([
        	'numero_usuario' => 'N/A',
            'servicio' => 'SAR/INFONAVIT',
            'concepto_pago' => '17 DE CADA DOS MESES'
        ]);
        ExpenseService::create([
        	'numero_usuario' => 'N/A',
            'servicio' => '3%  NOMINA',
            'concepto_pago' => '17 DE CADA MES'
        ]);
    }
}
