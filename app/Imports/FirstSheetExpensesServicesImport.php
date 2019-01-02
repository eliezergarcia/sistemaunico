<?php

namespace App\Imports;

use App\ExpenseService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class FirstSheetExpensesServicesImport implements ToCollection
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row){

            if ($key != 0){
                ExpenseService::create([
                    'numero_usuario' => $row[0],
                    'servicio' => $row[1],
                    'concepto_pago' => $row[2],
                ]);
            }
        }
    }
}