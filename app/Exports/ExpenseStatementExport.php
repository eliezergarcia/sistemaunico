<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExpenseStatementExport implements WithMultipleSheets
{
    use Exportable;

    // protected $request;

    public function __construct()
    {
        // $this->request = $request;
    }

    public function sheets(): array
    {
        $sheets = [];

        $fecha = Carbon::now();
        $year = $fecha->year;

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new ExpenseStatementSheet($year, $month);
        }

        $sheets[] = new ControlServicesSheet($year, $month);

        return $sheets;
    }
}
