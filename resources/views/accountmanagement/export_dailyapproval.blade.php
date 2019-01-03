<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>{{ $balance->created_at->format('d.m.Y') }}</th>
        </tr>
        <tr>
            <th colspan="2">1. Cash Flow</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th style="background-color: #FFB03D">Beginning Balance</th>
            <th style="background-color: #FFB03D">Currency</th>
            <th style="background-color: #FFB03D">Collection</th>
            <th style="background-color: #FFB03D">Payment</th>
            <th style="background-color: #FFB03D">Ending Balance</th>
        </tr>
            <?php
                $pcmxn = 0;
                $pcusd = 0;
            ?>
            @foreach($balance->clients($balance) as $client)
                <?php
                    $pcmxn = $pcmxn + $balance->paymentsClientTotalMXN($balance, $client->client()->id)->pluck('monto')->sum();
                    $pcusd = $pcusd + $balance->paymentsClientTotalUSD($balance, $client->client()->id)->pluck('monto')->sum();
                ?>
            @endforeach
            <?php
                    $fpmxn = 0;
                    $fpusd = 0;
            ?>
            @foreach($balance->invoicesProviders() as $invoice)
                <?php
                    $fpmxn = $fpmxn + $invoice->provider->accountManagementBalanceInvoicesMXN($balance);
                    $fpusd = $fpusd + $invoice->provider->accountManagementBalanceInvoicesUSD($balance);
                ?>
            @endforeach
        <tr>
            <th></th>
            <th style="background-color: #FCFFCD">{{ number_format($balanceinitial->mxn, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">MXN</th>
            <th style="background-color: #FCFFCD">{{ number_format($pcmxn, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">{{ number_format($fpmxn, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">{{ number_format($balance->mxn, 2, '.', ',') }}</th>
        </tr>
        <tr>
            <th></th>
            <th style="background-color: #FCFFCD">{{ number_format( $balanceinitial->usd, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">USD</th>
            <th style="background-color: #FCFFCD">{{ number_format($pcusd, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">$ {{ number_format($fpusd, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">$ {{ number_format($balance->usd, 2, '.', ',') }}</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="2">2. Collection</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th style="background-color: #FFB03D">Vendor or Sub-contractor</th>
            <th style="background-color: #FFB03D">Currency</th>
            <th style="background-color: #FFB03D">AR Beginning Balance</th>
            <th style="background-color: #FFB03D">Collection</th>
            <th style="background-color: #FFB03D">AR Ending Balance</th>
            <th style="background-color: #FFB03D">Remark 1</th>
            <th style="background-color: #FFB03D">Remark 2</th>
        </tr>
        @foreach($balance->clients($balance) as $client)
            @if($balance->paymentsClientTotalMXN($balance, $client->client()->id)->pluck('monto')->sum() != 0)
                <tr>
                    <th></th>
                    <th>{{ $client->client()->codigo_cliente }}
                        {{ $balance->paymentsClientMXN($balance, $client->client()->id)->pluck('factura')->implode(', ') }}
                    </th>
                    <th>MXN</th>
                    <th>{{ number_format($balance->ARBeginningBalanceClientMXN($balance, $client->client()->id), 2, '.', ',') }}</th>
                    <th>{{ number_format($balance->CollectionClientTotalMXN($balance, $client->client()->id)->pluck('monto')->sum(), 2, '.', ',') }}</th>
                    <th>{{ number_format($balance->ARBeginningBalanceClientMXN($balance, $client->client()->id) - ($balance->CollectionClientTotalMXN($balance, $client->client()->id)->pluck('monto')->sum()), 2, '.', ',') }}</th>
                </tr>
            @endif
            @if($balance->paymentsClientTotalUSD($balance, $client->client()->id)->pluck('monto')->sum() != 0)
                <tr>
                    <th></th>
                    <th>{{ $client->client()->codigo_cliente }}
                        {{ $balance->paymentsClientUSD($balance, $client->client()->id)->pluck('factura')->implode(', ') }}
                    </th>
                    <th>USD</th>
                    <th>$ {{ number_format($balance->ARBeginningBalanceClientUSD($balance, $client->client()->id), 2, '.', ',') }}</th>
                    <th>$ {{ number_format($balance->CollectionClientTotalUSD($balance, $client->client()->id)->pluck('monto')->sum(), 2, '.', ',') }}</th>
                    <th>{{ number_format($balance->ARBeginningBalanceClientUSD($balance, $client->client()->id) - ($balance->CollectionClientTotalUSD($balance, $client->client()->id)->pluck('monto')->sum()), 2, '.', ',') }}</th>
                </tr>
            @endif
        @endforeach
        <?php
            $arbeginningmxn = 0;
            $collectionmxn = 0;
            $arbeginningusd = 0;
            $collectionusd = 0;
        ?>
        @foreach($balance->clients($balance) as $client)
            <?php
                $arbeginningmxn = $arbeginningmxn + $balance->ARBeginningBalanceClientMXN($balance, $client->client()->id);
                $collectionmxn = $collectionmxn + $balance->CollectionClientTotalMXN($balance, $client->client()->id)->pluck('monto')->sum();
                $arbeginningusd = $arbeginningusd + $balance->ARBeginningBalanceClientUSD($balance, $client->client()->id);
                $collectionusd = $collectionusd + $balance->CollectionClientTotalUSD($balance, $client->client()->id)->pluck('monto')->sum();
            ?>
        @endforeach
        <tr></tr>
        <tr>
            <th></th>
            <th style="background-color: #FCFFCD">Total MXN</th>
            <th style="background-color: #FCFFCD">MXN</th>
            <th style="background-color: #FCFFCD">{{ number_format($arbeginningmxn, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">{{ number_format($collectionmxn, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">{{ number_format($arbeginningmxn - $collectionmxn, 2, '.', ',') }}</th>
        </tr>
        <tr>
            <th></th>
            <th style="background-color: #FCFFCD">Total USD</th>
            <th style="background-color: #FCFFCD">USD</th>
            <th style="background-color: #FCFFCD">$ {{ number_format($arbeginningusd, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">$ {{ number_format($collectionusd, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">{{ number_format($arbeginningusd - $collectionusd, 2, '.', ',') }}</th>
        </tr>
        <tr>
            <th></th>
            <th style="background-color: #FCFFCD">Total EUR</th>
            <th style="background-color: #FCFFCD">EUR</th>
            <th style="background-color: #FCFFCD">0.00</th>
            <th style="background-color: #FCFFCD">0.00</th>
            <th style="background-color: #FCFFCD">0.00</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="2">3. Payment Plan</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th style="background-color: #FFB03D">Vendor or Sub-contractor</th>
            <th style="background-color: #FFB03D">Currency</th>
            <th style="background-color: #FFB03D">AP Beginning Balance</th>
            <th style="background-color: #FFB03D">Payment</th>
            <th style="background-color: #FFB03D">AP Ending Balance</th>
            <th style="background-color: #FFB03D">Approval Status</th>
            <th style="background-color: #FFB03D">Client</th>
            <th style="background-color: #FFB03D">Unico PIC</th>
            <th style="background-color: #FFB03D">Service (Truck, Ocean)</th>
            <th style="background-color: #FFB03D">Remarks</th>
        </tr>
        @foreach($balancepaymentplan->invoicesProviders() as $invoice)
            <?php
            ?>
            @if($invoice->provider->accountManagementBalanceInvoicesMXN($balancepaymentplan) != 0)
                <tr>
                    <th></th>
                    <th>{{ strtoupper($invoice->provider->codigo_proveedor) }}</th>
                    <th>MXN</th>
                    <th>{{ number_format($invoice->provider->APBeginningBalanceProviderMXN($balancepaymentplan), 2, '.', ',') }}</th>
                    <th>{{ number_format($invoice->provider->PaymentProviderMXN($balancepaymentplan), 2, '.', ',') }}</th>
                    <th>{{ number_format($invoice->provider->APBeginningBalanceProviderMXN($balancepaymentplan) - $invoice->provider->PaymentProviderMXN($balancepaymentplan), 2, '.', ',') }}</th>
                    <th></th>
                    <th>{{ $invoice->provider->clients($balancepaymentplan) }}</th>
                    <th>{{ $invoice->provider->unicoPic($balancepaymentplan) }}</th>
                    <th>{{ $invoice->provider->service }}</th>
                    <th>{{ $invoice->provider->RemarksProviderMXN() }}</th>
                </tr>
            @endif
            @if($invoice->provider->accountManagementBalanceInvoicesUSD($balancepaymentplan) != 0)
                <tr>
                    <th></th>
                    <th>{{ strtoupper($invoice->provider->codigo_proveedor) }}</th>
                    <th>USD</th>
                    <th>$ {{ number_format($invoice->provider->APBeginningBalanceProviderUSD($balancepaymentplan), 2, '.', ',') }}</th>
                    <th>$ {{ number_format($invoice->provider->PaymentProviderUSD($balancepaymentplan), 2, '.', ',') }}</th>
                    <th>$ {{ number_format($invoice->provider->APBeginningBalanceProviderUSD($balancepaymentplan) - $invoice->provider->PaymentProviderUSD($balancepaymentplan), 2, '.', ',') }}</th>
                    <th></th>
                    <th>{{ $invoice->provider->clients($balancepaymentplan) }}</th>
                    <th>{{ $invoice->provider->unicoPic($balancepaymentplan) }}</th>
                    <th>{{ $invoice->provider->service }}</th>
                    <th>Remark</th>
                </tr>
            @endif
        @endforeach
        <tr></tr>
         <?php
                $apbeginningmxn = 0;
                $apbeginningusd = 0;
                $paymentmxn = 0;
                $paymentusd = 0;
        ?>
        @foreach($balancepaymentplan->invoicesProviders() as $invoice)
            <?php
                $apbeginningmxn = $apbeginningmxn + $invoice->provider->APBeginningBalanceProviderMXN($balancepaymentplan);
                $paymentmxn = $paymentmxn + $invoice->provider->PaymentProviderMXN($balancepaymentplan);
                $apbeginningusd = $apbeginningusd + $invoice->provider->APBeginningBalanceProviderUSD($balancepaymentplan);
                $paymentusd = $paymentusd + $invoice->provider->PaymentProviderUSD($balancepaymentplan);
            ?>
        @endforeach
        <tr>
            <th></th>
            <th style="background-color: #FCFFCD">Total AED</th>
            <th style="background-color: #FCFFCD">MXN</th>
            <th style="background-color: #FCFFCD">{{ number_format($apbeginningmxn, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">{{ number_format($paymentmxn, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">{{ number_format($apbeginningmxn - $paymentmxn, 2, '.', ',') }}</th>
        </tr>
        <tr>
            <th></th>
            <th style="background-color: #FCFFCD">Total USD</th>
            <th style="background-color: #FCFFCD">USD</th>
            <th style="background-color: #FCFFCD">$ {{ number_format($apbeginningusd, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">$ {{ number_format($paymentusd, 2, '.', ',') }}</th>
            <th style="background-color: #FCFFCD">$ {{ number_format($apbeginningusd - $paymentusd, 2, '.', ',') }}</th>
        </tr>
        <tr>
            <th></th>
            <th style="background-color: #FCFFCD">Total EUR</th>
            <th style="background-color: #FCFFCD">EUR</th>
            <th style="background-color: #FCFFCD">0.00</th>
            <th style="background-color: #FCFFCD">0.00</th>
            <th style="background-color: #FCFFCD">0.00</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>