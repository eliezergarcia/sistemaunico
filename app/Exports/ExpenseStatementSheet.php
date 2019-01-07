<?php

namespace App\Exports;

use Carbon\Carbon;
use App\ExpenseStatement;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExpenseStatementSheet implements FromView, ShouldAutoSize, WithTitle
{
    public function __construct(int $year, int $month)
    {
        $this->month = $month;
        $this->year  = $year;
    }

    public function view(): View
    {
        return view('expensestatement.export', [
            'expenses' => ExpenseStatement::whereMonth('created_at', $this->month)
                                          ->whereYear('created_at', $this->year)
                                          ->where('template', null)
                                          ->where('canceled_at', null)->get(),
        ]);
    }

    public function title(): string
    {
        switch ($this->month) {
            case 1:
                $nameMonth = "ENERO";
                break;
            case 2:
                $nameMonth = "FEB";
                break;
            case 3:
                $nameMonth = "MZO";
                break;
            case 4:
                $nameMonth = "ABR";
                break;
            case 5:
                $nameMonth = "MAY";
                break;
            case 6:
                $nameMonth = "JUN";
                break;
            case 7:
                $nameMonth = "JUL";
                break;
            case 8:
                $nameMonth = "AGO";
                break;
            case 9:
                $nameMonth = "SEPT";
                break;
            case 10:
                $nameMonth = "OCT";
                break;
            case 11:
                $nameMonth = "NOV";
                break;
            case 12:
                $nameMonth = "DIC";
                break;
        }

        return $nameMonth;
    }
}
