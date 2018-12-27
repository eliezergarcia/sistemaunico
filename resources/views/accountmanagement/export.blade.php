<html>
    <table>
        <thead>
            <tr>
                <td align="center" style="align-content: center;"><strong><i>ACCOUNT MANAGEMENT</i></strong></td>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th style="background-color: #6699CC">REPORTING</th>
                <th style="background-color: #D3D3D3;">Edith Valdez</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th style="background-color: #6699CC">APPROVED</th>
                <th style="background-color: #D3D3D3;">Young Rak Kim</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th rowspan="2" colspan="2">ACCOUNT</th>
                @foreach($accountsunico as $account)
                    <th style="text-align: center;"><strong>{{ $account->currency }}</strong></th>
                @endforeach
            </tr>
            <tr>
                @foreach($accountsunico as $account)
                    <th style="text-align: center;">{{ $account->account }}</th>
                @endforeach
            </tr>
            <tr>
                <th colspan="2" scope="col" style="background-color: #FFFF00;">INITIAL BALANCE</th>
                <th style="background-color: #FFFF00; float: right;" align="right"> {{ number_format($balanceinitial->mxn, 2, '.', ',') }}</th>
                <th style="background-color: #FFFF00;" align="right">$ {{ number_format($balanceinitial->usd, 2, '.', ',') }}</th>
                <th style="background-color: #FFFF00;" align="right">{{ number_format($balanceinitial->debit, 2, '.', ',') }}</th>
            </tr>
            @foreach($balances as $key => $balance)
                <?php
                    $pcmxn = 0;
                    $pcusd = 0;
                ?>
                @foreach($balance->clients($balance) as $client)
                    <tr>
                            <th></th>
                            <th>{{ $client->client()->codigo_cliente }}
                                {{ $balance->paymentsClient($balance, $client->client()->id)->pluck('factura')->implode(', ') }}
                            </th>
                        <th>{{ $balance->paymentsClientTotalMXN($balance, $client->client()->id)->pluck('monto')->sum() }}</th>
                        <th>{{ $balance->paymentsClientTotalUSD($balance, $client->client()->id)->pluck('monto')->sum() }}</th>
                        <th></th>
                        <?php
                            $pcmxn = $pcmxn + $balance->paymentsClientTotalMXN($balance, $client->client()->id)->pluck('monto')->sum();
                            $pcusd = $pcusd + $balance->paymentsClientTotalUSD($balance, $client->client()->id)->pluck('monto')->sum();
                        ?>
                    </tr>
                @endforeach
                <tr>
                    <th></th>
                    <th></th>
                    <th> </th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th></th>
                    <th>Total</th>
                    <th>{{ number_format($pcmxn, 2, '.', ',') }}</th>
                    <th>$ {{ number_format($pcusd, 2, '.', ',') }}</th>
                    <th></th>
                </tr>
                <?php
                        $fpmxn = 0;
                        $fpusd = 0;
                ?>
                @foreach($balance->invoicesProviders() as $invoice)
                    <tr>
                        @if($balance->invoicesProviders()->first() == $invoice)
                            <th rowspan="{{ $balance->invoicesProviders()->count() }}">PAYMENT ({{ $balance->created_at->format('d/m') }})</th>
                        @endif
                        <th>{{ strtoupper($invoice->provider->codigo_proveedor) }}</th>
                        <th>{{ number_format($invoice->provider->accountManagementBalanceInvoicesMXN($balance), 2, '.', ',') }}</th>
                        <th>{{ number_format($invoice->provider->accountManagementBalanceInvoicesUSD($balance), 2, '.', ',') }}</th>
                        <th></th>
                    </tr>
                    <?php
                        $fpmxn = $fpmxn + $invoice->provider->accountManagementBalanceInvoicesMXN($balance);
                        $fpusd = $fpusd + $invoice->provider->accountManagementBalanceInvoicesUSD($balance);
                    ?>
                @endforeach
                <tr>
                    <th></th>
                    <th>Total</th>
                    <th>{{ number_format($fpmxn, 2, '.', ',') }}</th>
                    <th>$ {{ number_format($fpusd, 2, '.', ',') }}</th>
                    <th></th>
                </tr>
                <tr>
                    <th style="background-color: #FFFF00; border-color: black;">BALANCE {{ $key + 1 }}</th>
                    <th style="background-color: #FFFF00;"></th>
                    <th style="background-color: #FFFF00;">{{ number_format($balance->mxn, 2, '.', ',') }}</th>
                    <th style="background-color: #FFFF00;">$ {{ number_format($balance->usd, 2, '.', ',') }}</th>
                    <th style="background-color: #FFFF00;">$ {{ number_format($balance->debit, 2, '.', ',') }}</th>
                </tr>
            @endforeach
        </thead>
        <tbody>
        </tbody>
    </table>
</html>