<?php

namespace App\Exports;

use App\Provider;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AccountManagementExport implements WithMultipleSheets
{
    use Exportable;

    protected $request;

	public function __construct($request)
    {
        $this->request = $request;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new BalancesSheet($this->request);

        $providers = Provider::where('inactive_at', null)->limit(2)->get();

        foreach ($providers as $provider) {
            $sheets[] = new InvoicesPerProviderSheet($this->request, $provider);
        }

        return $sheets;
    }
}
