<?php

namespace App\Exports;

use App\Operation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OperationsReportExport implements FromView, ShouldAutoSize, WithTitle
{
    use Exportable;

    protected $request;

	public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        return view('operations.reportes.report', [
            'operation' => Operation::whereDate('eta', '>=', $this->request->fecha_inicio)
                                          ->where('eta', '<=', $this->request->fecha_fin)
                                          ->get(),
        ]);
    }

    public function title(): string
    {
        return 'OPERACIONES';
    }
}
