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

class DailyApprovalExport implements FromView, ShouldAutoSize, WithTitle
{
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $dailyapprovalbalance = AccountManagementBalance::whereDate('created_at', '=', $this->request->da_fecha_inicio)->first();
        // dd($dailyapprovalbalance->id + 1);
        return view('accountmanagement.export_dailyapproval', [
            'invoices' => InvoiceProvider::all(),
            'accountsunico' => AccountUnico::all(),
            'payments' => Payment::all(),
            'balance' => $dailyapprovalbalance,
            'balanceinitial' => AccountManagementBalance::findOrFail($dailyapprovalbalance['id'] - 1),
            'balancepaymentplan' => AccountManagementBalance::findOrFail($dailyapprovalbalance->id + 1)
        ]);
    }

    public function title(): string
    {
        $dailyapprovalbalance = AccountManagementBalance::whereDate('created_at', '=', $this->request->da_fecha_inicio)->first();
        return $dailyapprovalbalance->created_at->format('d.m.Y');
    }
}
