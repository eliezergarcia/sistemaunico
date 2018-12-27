<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ClientsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            // Select by sheet index
            0 => new FirstSheetClientsImport()
        ];
    }
}
