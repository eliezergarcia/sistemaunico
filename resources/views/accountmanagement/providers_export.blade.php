<table class="table">
    <thead>
        <tr>
            <th colspan="4">{{ $provider->codigo_proveedor }}</th>
            <th colspan="2">EXPENSES STATEMENT</th>
            <th></th>
            <th colspan="2">DIAS DE CREDITO</th>
        </tr>
        <tr>
            <th colspan="4"></th>
            <th colspan="2"></th>
            <th></th>
            <th colspan="2">{{ $provider->credit_days }}</th>
        </tr>
        <tr>
            <th colspan="2" style="background-color: #6699CC">REPORTING</th>
            <th style="background-color: #D3D3D3;">Edith Valdez</th>
            <th colspan="2"></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th colspan="2" style="background-color: #6699CC">APPROVED</th>
            <th style="background-color: #D3D3D3;">Young Rak Kim</th>
            <th colspan="2" style="background-color: #6699CC">AMOUNT</th>
        </tr>
        <tr>
            <th style="background-color: #87CEFA">Factura/Invoice</th>
            <th style="background-color: #87CEFA">Reg Date</th>
            <th style="background-color: #87CEFA">Invoice Date</th>
            <th style="background-color: #87CEFA">Expense Tipe</th>
            <th style="background-color: #87CEFA">Description</th>
            <th style="background-color: #87CEFA">Net</th>
            <th style="background-color: #87CEFA">Vat</th>
            <th style="background-color: #87CEFA">Retention</th>
            <th style="background-color: #87CEFA">Others</th>
            <th style="background-color: #87CEFA">Total</th>
            <th style="background-color: #87CEFA">Pending Amounts</th>
            <th style="background-color: #87CEFA">Payment Source</th>
            <th style="background-color: #87CEFA">Notes</th>
            <th style="background-color: #87CEFA">Control Code</th>
            <th style="background-color: #87CEFA">Payment Status</th>
            <th style="background-color: #87CEFA">Expense Description</th>
            <th style="background-color: #87CEFA">Fact. UNICO</th>
        </tr>
        @foreach($invoices as $invoice)
            @if(!$invoice->canceled_at)
                <tr>
                    <th>{{ $invoice->factura }}</th>
                    <th>{{ $invoice->regDateFormat}}</th>
                    <th>{{ $invoice->invoiceDateFormat }}</th>
                    <th>{{ $invoice->expense_tipe }}</th>
                    <th></th>
                    <th>{{ number_format($invoice->neto, 2, '.', ',') }}</th>
                    <th>{{ number_format($invoice->vat, 2, '.', ',') }}</th>
                    <th>- {{ number_format($invoice->retention, 2, '.', ',') }}</th>
                    <th>{{ number_format($invoice->others, 2, '.', ',') }}</th>
                    <th>{{ $invoice->total }}</th>
                    <th>{{ $invoice->pendiente }}</th>
                    <th>{{ $invoice->payment_source() }}</th>
                    <th>
                        {{ $invoice->m_bl }} / {{ $invoice->h_bl }} <br>
                        @foreach($invoice->conceptsinvoice as $concept)
                            {{ $concept->concept->description }} <br>
                        @endforeach
                        {{ $invoice->operation->house->codigo_cliente }} <br>
                        {{ $invoice->operation->etaFormat }} <br>
                        {{ $invoice->operation->user->name }} <br>
                    </th>
                    <th>{{ $invoice->controlcode }}</th>
                    <th>{{ $invoice->payment_status() }}</th>
                    <th>{{ $invoice->expense_description }}</th>
                    <th>
                        F/{{ $invoice->operation->invoicesclients->pluck('factura')->implode(', ') }}
                    </th>
                </tr>
            @endif
        @endforeach
        <?php
            $neto = 0;
            $vat = 0;
            $retention = 0;
            $others = 0;
            $total = 0;
            $pendiente = 0;
        ?>
        @foreach($invoices as $invoice)
            @if(!$invoice->canceled_at)
                <?php
                    $neto = $neto + $invoice->neto;
                    $vat = $vat + $invoice->vat;
                    $retention = $retention + $invoice->retention;
                    $others = $others + $invoice->others;
                    if ($invoice->comissions->isNotEmpty()) {
                        $comision = $invoice->commissions->first()->commission;
                    }else{
                        $comision = 0;
                    }
                    $total = $total + (($invoice->neto + $invoice->vat + $invoice->others + $comision) - $invoice->retention);
                    $pendiente = $pendiente + $invoice->snPendiente;
                ?>
            @endif
        @endforeach
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th style="background-color: #FFA500">Totales</th>
            <th style="background-color: #FFA500">{{ number_format($neto, 2, '.', ',') }}</th>
            <th style="background-color: #FFA500">{{ number_format($vat, 2, '.', ',') }}</th>
            <th style="background-color: #FFA500">{{ number_format($retention, 2, '.', ',') }}</th>
            <th style="background-color: #FFA500">{{ number_format($others, 2, '.', ',') }}</th>
            <th style="background-color: #FFA500">{{ number_format($total, 2, '.', ',') }}</th>
            <th style="background-color: #FFA500">{{ number_format($pendiente, 2, '.', ',') }}</th>
        </tr>
        <tr></tr>
        <tr></tr>
        @if($invoices->pluck('canceled_at')->contains(!NULL))
            <tr>
                <th style="background-color: #F08080">Canceladas</th>
            </tr>
            @foreach($invoices as $invoice)
                @if($invoice->canceled_at)
                    <tr>
                        <th style="background-color: #F08080">{{ $invoice->factura }}</th>
                        <th style="background-color: #F08080">{{ $invoice->regDateFormat}}</th>
                        <th style="background-color: #F08080">{{ $invoice->invoiceDateFormat }}</th>
                        <th style="background-color: #F08080">{{ $invoice->expense_tipe }}</th>
                        <th style="background-color: #F08080"></th>
                        <th style="background-color: #F08080">{{ $invoice->neto }}</th>
                        <th style="background-color: #F08080">{{ $invoice->vat }}</th>
                        <th style="background-color: #F08080">- {{ $invoice->retention }}</th>
                        <th style="background-color: #F08080">{{ $invoice->others }}</th>
                        <th style="background-color: #F08080">{{ $invoice->total }}</th>
                        <th style="background-color: #F08080">{{ $invoice->pendiente }}</th>
                        <th style="background-color: #F08080">{{ $invoice->payment_source() }}</th>
                        <th style="background-color: #F08080">
                            {{ $invoice->m_bl }} / {{ $invoice->h_bl }} <br>
                            @foreach($invoice->conceptsinvoice as $concept)
                                {{ $concept->concept->description }} <br>
                            @endforeach
                            {{ $invoice->operation->user->name }}
                        </th>
                        <th style="background-color: #F08080">{{ $invoice->controlcode }}</th>
                        <th style="background-color: #F08080">{{ $invoice->payment_status() }}</th>
                        <th style="background-color: #F08080">{{ $invoice->expense_description }}</th>
                        <th style="background-color: #F08080">
                            F/{{ $invoice->operation->invoicesclients->pluck('factura')->implode(', ') }}
                        </th>
                    </tr>
                @endif
            @endforeach
            <?php
                $neto = 0;
                $vat = 0;
                $retention = 0;
                $others = 0;
                $total = 0;
            ?>
            @foreach($invoices as $invoice)
                @if($invoice->canceled_at)
                    <?php
                        $neto = $neto + $invoice->neto;
                        $vat = $vat + $invoice->vat;
                        $retention = $retention + $invoice->retention;
                        $others = $others + $invoice->others;
                        $total = $total + (($invoice->neto + $invoice->vat + $invoice->others) - $invoice->retention);
                    ?>
                @endif
            @endforeach
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="background-color: #FFA500">Totales</th>
                <th style="background-color: #FFA500">{{ number_format($neto, 2, '.', ',') }}</th>
                <th style="background-color: #FFA500">{{ number_format($vat, 2, '.', ',') }}</th>
                <th style="background-color: #FFA500">{{ number_format($retention, 2, '.', ',') }}</th>
                <th style="background-color: #FFA500">{{ number_format($others, 2, '.', ',') }}</th>
                <th style="background-color: #FFA500">{{ number_format($total, 2, '.', ',') }}</th>
            </tr>
        @endif
    </thead>
</table>