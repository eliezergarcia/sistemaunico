<?php

namespace App\Exports;

use App\InvoiceProvider;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InvoicesPerProviderSheet implements FromView, ShouldAutoSize, WithTitle
{
    public function __construct($request, $provider)
    {
        $this->request = $request;
        $this->provider = $provider;
    }

    public function view(): View
    {
        $invoices = InvoiceProvider::whereDate('created_at', '>=', $this->request->fp_fecha_inicio)
                                   ->whereDate('created_at', '<=', $this->request->fp_fecha_fin)
                                   ->where('provider_id', $this->provider->id)
                                   ->get();
        return view('accountmanagement.providers_export', [
            'invoices' => InvoiceProvider::whereDate('created_at', '>=', $this->request->fp_fecha_inicio)
                                   ->whereDate('created_at', '<=', $this->request->fp_fecha_fin)
                                   ->where('provider_id', '=', $this->provider->id)
                                   ->get(),
            'provider' => $this->provider
        ]);
    }

    public function title(): string
    {
        return "";
        // return strtoupper($this->provider->codigo_proveedor);
    }
}
