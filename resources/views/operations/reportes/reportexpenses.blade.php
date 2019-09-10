<table class="table">
    <thead>
        <!-- <tr>
            <th style="background-color: #9BC2E6">BL</th>
            <th style="background-color: #9BC2E6" colspan="2">Solicitud de Anticipo</th>
            <th style="background-color: #9BC2E6" colspan="2">Factura de Proveedor</th>
        </tr> -->
        <tr>
            @foreach($operations as $operation)
                <th style="background-color: #9BC2E6; text-align: center;">BL</th>
                @foreach($operation->invoicesproviders as $invoiceprovider)
                    @foreach($invoiceprovider->conceptsinvoice as $conceptinvoice)
                        @if($invoiceprovider->factura == null && $invoiceprovider->advance_request != null)
                            <th style="background-color: #9BC2E6; text-align: center;" colspan="2">Solicitud de Anticipo<br></th>
                        @else
                            <th style="background-color: #9BC2E6; text-align: center;" colspan="2">Factura de Proveedor<br></th>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </tr>
        <tr>
            @foreach($operations as $operation)
                <th style="background-color: #9BC2E6; text-align: center;">{{ $operation->m_bl }}</th>
                @foreach($operation->invoicesproviders as $invoiceprovider)
                    @foreach($invoiceprovider->conceptsinvoice as $conceptinvoice)
                        @if($invoiceprovider->factura == null && $invoiceprovider->advance_request != null)
                            <th style="background-color: #9BC2E6; text-align: center;" colspan="2">{{ $invoiceprovider->controlcode }}</th>
                        @else
                            <th style="background-color: #9BC2E6; text-align: center;" colspan="2">{{ $invoiceprovider->controlcode }}</th>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </tr>
        <!-- <tr>
            @foreach($operations as $operation)
                <th></th>
                @foreach($operation->invoicesproviders as $invoiceprovider)
                    @foreach($invoiceprovider->conceptsinvoice as $conceptinvoice)
                        @if($invoiceprovider->factura == null && $invoiceprovider->advance_request != null)
                            <th>{{ $conceptinvoice->concept->description }}</th>
                            <th>{{ ($conceptinvoice->rate + $conceptinvoice->iva) * $conceptinvoice->qty }}</th>
                        @else
                            <th></th>
                            <th></th>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </tr> -->
        <tr>
            @foreach($operations as $operation)
                <th></th>
                @foreach($operation->invoicesproviders as $invoiceprovider)
                    <th>
                        @foreach($invoiceprovider->conceptsinvoice as $conceptinvoice)
                            {{ $conceptinvoice->concept->description }} <br>
                        @endforeach
                    </th>
                    <th>
                        @foreach($invoiceprovider->conceptsinvoice as $conceptinvoice)
                            {{ number_format(($conceptinvoice->rate + $conceptinvoice->iva) * $conceptinvoice->qty, 2, '.', ',') }} <br>
                        @endforeach
                    </th>
                @endforeach
            @endforeach
        </tr>
        <tr>
            @foreach($operations as $operation)
                <th></th>
                @foreach($operation->invoicesproviders as $invoiceprovider)
                    <th>
                        Total: 
                    </th>
                    <strong><th>
                        <?php 
                            $rate = 0;
                            $iva = 0;
                            $tot = 0;
                        ?>
                        @foreach($invoiceprovider->conceptsinvoice as $conceptinvoice)
                            <?php 
                                $rate = $rate + $conceptinvoice->rate;
                                $iva = $iva + $conceptinvoice->iva;
                                $tot = $tot + (($rate + $iva) * $conceptinvoice->qty);
                            ?>
                        @endforeach
                        {{ number_format($tot, 2, '.', ',') }}
                        <!-- @foreach($invoiceprovider->conceptsinvoice as $conceptinvoice) -->
                            <!-- {{ ($invoiceprovider->conceptsinvoice->pluck('rate')->sum() + $invoiceprovider->conceptsinvoice->pluck('iva')->sum())}} <br> -->
                        <!-- @endforeach -->
                    </th></strong>
                @endforeach
            @endforeach
        </tr>
        <!-- @foreach($operations as $operation)
            @foreach($operation->invoicesproviders as $invoiceprovider)
                @foreach($invoiceprovider->conceptsinvoice as $conceptinvoice)
                    @if($invoiceprovider->factura == null && $invoiceprovider->advance_request != null)
                        <tr>
                            <th></th>
                            <th>{{ $conceptinvoice->concept->description }}</th>
                            <th>{{ $conceptinvoice->rate }}</th>    
                            <th></th>
                            <th></th>
                        </tr>
                    @else
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{ $conceptinvoice->concept->description }}</th>
                            <th>{{ $conceptinvoice->rate }}</th>    
                        </tr>
                    @endif
                @endforeach
            @endforeach
        @endforeach -->
    </thead>
</table>