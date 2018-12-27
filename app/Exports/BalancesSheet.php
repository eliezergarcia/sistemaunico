<?php

namespace App\Exports;

use App\Payment;
use Carbon\Carbon;
use App\AccountUnico;
use App\InvoiceProvider;
use App\AccountManagementBalance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class BalancesSheet implements FromView, ShouldAutoSize, WithTitle
{
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        // dd($this->request->fecha_inicio);
        // $newdate = strtotime ( '-1 day' , strtotime ( $this->request->fecha_inicio ) ) ;
        // $newdate = date ( 'Y-m-d' , $newdate );
        $accountmanagementbalance = AccountManagementBalance::whereDate('created_at', '>=', $this->request->am_fecha_inicio)->get();
        return view('accountmanagement.export', [
            'invoices' => InvoiceProvider::all(),
            'accountsunico' => AccountUnico::all(),
            'payments' => Payment::all(),
            'balances' => AccountManagementBalance::whereDate('created_at', '>=', $this->request->am_fecha_inicio)->get(),
            'balanceinitial' => AccountManagementBalance::findOrFail($accountmanagementbalance[0]['id'] - 1)
        ]);
    }

    public function title(): string
    {
        return 'ACCOUNT M.';
    }
}
