<?php

namespace App\Exports;

use Carbon\Carbon;
use App\ExpenseService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ControlServicesSheet implements FromView, ShouldAutoSize, WithTitle
{
    public function __construct(int $year, int $month)
    {
        $this->month = $month;
        $this->year  = $year;
    }

    public function view(): View
    {
        return view('expensestatement.controlservicesexport', [
            'services' => ExpenseService::all(),
        ]);
    }

    public function title(): string
    {
        return "CONTROL DE SERVICIOS";
    }
}
