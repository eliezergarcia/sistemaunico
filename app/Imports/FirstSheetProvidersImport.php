<?php

namespace App\Imports;

use App\Provider;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class FirstSheetProvidersImport implements ToCollection
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row){

            if ($key != 0) {
                Provider::create([
                    'codigo_proveedor' => $row[0],
                    'razon_social' => $row[1],
                    'rfc' => $row[2],
                    'calle' => $row[3],
                    'numero_interior' => $row[4],
                    'numero_exterior' => $row[5],
                    'colonia' => $row[6],
                    'codigo_postal' => $row[7],
                    'pais' => $row[8],
                    'estado' => $row[9],
                    'ciudad' => $row[10],
                    'municipio' => $row[11],
                    'telefono1' => $row[12],
                    'telefono2' => $row[13],
                    'credit_days' => $row[14],
                    'service' => $row[15],
                ]);
            }
        }
    }
}
