<table class="table">
    <thead>
    @foreach($operations as $operation)
        <tr>
            <th>Fecha:</th>
            <th>{{ $operation->etaformat }}</th>
        </tr>
        <!-- Se imprimen los titulos -->
        <tr>
            <th style="background-color: #9BC2E6; text-align: center;">BL</th>
            @foreach($operation->invoicesproviders as $invoiceprovider)
                @if(!$invoiceprovider->canceled_at)
                    @if($invoiceprovider->advance_request != null)
                        <th style="background-color: #9BC2E6; text-align: center;" colspan="2">Solicitud de Anticipo<br></th>
                    @endif
                    @if($invoiceprovider->factura != null && $invoiceprovider->guarantee_request == null && $invoiceprovider->advance_request == null)
                        <th style="background-color: #9BC2E6; text-align: center;" colspan="2">Factura de Proveedor<br></th>
                    @endif
                @endif
            @endforeach
        </tr>
        <!-- Se imprimen los titulos -->
        <!-- Se imprimen los codigos de control -->
        <tr>
            <th style="background-color: #9BC2E6; text-align: center;">{{ $operation->m_bl }}</th>
            @foreach($operation->invoicesproviders as $invoiceprovider)
                @if(!$invoiceprovider->canceled_at)
                    @if($invoiceprovider->advance_request != null)
                        <th style="background-color: #9BC2E6; text-align: center;" colspan="2">{{ $invoiceprovider->controlcode }}</th>
                    @endif
                    @if($invoiceprovider->factura != null && $invoiceprovider->guarantee_request == null && $invoiceprovider->advance_request == null)
                        <th style="background-color: #9BC2E6; text-align: center;" colspan="2">{{ $invoiceprovider->controlcode }}</th>
                    @endif
                @endif
            @endforeach
        </tr>
        <!-- Se imprimen los codigos de control -->
        <!-- Se imprimen los proveedores -->
        <tr>
            <th></th>
            @foreach($operation->invoicesproviders as $invoiceprovider)
                @if(!$invoiceprovider->canceled_at)
                    @if($invoiceprovider->advance_request != null)
                        <th style="background-color: #9BC2E6; text-align: center;" colspan="2">{{ $invoiceprovider->provider->codigo_proveedor }}</th>
                    @endif
                    @if($invoiceprovider->factura != null && $invoiceprovider->guarantee_request == null && $invoiceprovider->advance_request == null)
                        <th style="background-color: #9BC2E6; text-align: center;" colspan="2">{{ $invoiceprovider->provider->codigo_proveedor }}</th>
                    @endif
                @endif
            @endforeach
        </tr>
        <!-- Se imprimen los proveedores -->
        <!-- Se imprimen los conceptos -->
        <tr>
            <th></th>
            @foreach($operation->invoicesproviders as $invoiceprovider)
                @if(!$invoiceprovider->canceled_at)
                    @if($invoiceprovider->advance_request != null)
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
                    @endif
                    @if($invoiceprovider->factura != null && $invoiceprovider->guarantee_request == null && $invoiceprovider->advance_request == null)
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
                    @endif
                @endif
            @endforeach
        </tr>
        <!-- Se imprimen los conceptos -->
        <!-- Se imprimen los totales -->
        <tr>
            <th></th>
            @foreach($operation->invoicesproviders as $invoiceprovider)
                @if(!$invoiceprovider->canceled_at)
                    @if($invoiceprovider->advance_request != null)
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
                                    $rate = 0;
                                    $iva = 0;
                                    $rate = $rate + $conceptinvoice->rate;
                                    $iva = $iva + $conceptinvoice->iva;
                                    $tot = $tot + (($rate + $iva) * $conceptinvoice->qty);
                                ?>
                            @endforeach
                            {{ number_format($tot, 2, '.', ',') }}
                        </th></strong>
                    @endif
                    @if($invoiceprovider->factura != null && $invoiceprovider->guarantee_request == null && $invoiceprovider->advance_request == null)
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
                                    $rate = 0;
                                    $iva = 0; 
                                    $rate = $rate + $conceptinvoice->rate;
                                    $iva = $iva + $conceptinvoice->iva;
                                    $tot = $tot + (($rate + $iva) * $conceptinvoice->qty);
                                ?>
                            @endforeach
                            {{ number_format($tot, 2, '.', ',') }}
                        </th></strong>
                    @endif
                @endif
            @endforeach
        </tr>
        <!-- Se imprimen los totales -->

        <tr></tr>

        <!-- Se imprimen los titulos -->
        <tr>
            <th></th>
            @foreach($operation->debitnotes as $debitnote)
                @if(!$debitnote->canceled_at)
                    <th style="background-color: #A9D08E; text-align: center;" colspan="2">Debit note<br></th>
                @endif
            @endforeach
            @foreach($operation->prefactures as $prefacture)
                @if(!$prefacture->canceled_at)
                    <th style="background-color: #A9D08E; text-align: center;" colspan="2">Prefactura<br></th>
                @endif
            @endforeach
        </tr>
        <!-- Se imprimen los titulos -->
        <!-- Se imprimen los codigos de control -->
        <tr>
            <th></th>
            @foreach($operation->debitnotes as $debitnote)
                @if(!$debitnote->canceled_at)
                    <th style="background-color: #A9D08E; text-align: center;" colspan="2">{{ $debitnote->numberformat }}<br></th>
                @endif
            @endforeach
            @foreach($operation->prefactures as $prefacture)
                @if(!$prefacture->canceled_at)
                    <th style="background-color: #A9D08E; text-align: center;" colspan="2">{{ $prefacture->numberformat }}<br></th>
                @endif
            @endforeach
        </tr>
        <!-- Se imprimen los codigos de control -->
        <!-- Se imprimen los clientes -->
        <tr>
            <th></th>
            @foreach($operation->debitnotes as $debitnote)
                @if(!$debitnote->canceled_at)
                    <th style="background-color: #A9D08E; text-align: center;" colspan="2">{{ $debitnote->client->codigo_cliente }}<br></th>
                @endif
            @endforeach
            @foreach($operation->prefactures as $prefacture)
                @if(!$prefacture->canceled_at)
                    <th style="background-color: #A9D08E; text-align: center;" colspan="2">{{ $prefacture->client->codigo_cliente }}<br></th>
                @endif
            @endforeach           
        </tr>
        <!-- Se imprimen los clientes -->
        <!-- Se imprimen los conceptos -->
        <tr>
            <th></th>
            @foreach($operation->debitnotes as $debitnote)
                @if(!$debitnote->canceled_at)
                    <th>
                        @foreach($debitnote->conceptsoperations as $conceptoperation)
                            {{ $conceptoperation->concept->description }} <br>
                        @endforeach
                    </th>
                    <th>
                        @foreach($debitnote->conceptsoperations as $conceptoperation)
                            {{ number_format(($conceptoperation->rate + $conceptoperation->iva) * $conceptoperation->qty, 2, '.', ',') }} <br>
                        @endforeach
                    </th>
                @endif
            @endforeach
            @foreach($operation->prefactures as $prefacture)
                @if(!$prefacture->canceled_at)
                    <th>
                        @foreach($prefacture->conceptsoperations as $conceptoperation)
                            {{ $conceptoperation->concept->description }} <br>
                        @endforeach
                    </th>
                    <th>
                        @foreach($prefacture->conceptsoperations as $conceptoperation)
                            {{ number_format(($conceptoperation->rate + $conceptoperation->iva) * $conceptoperation->qty, 2, '.', ',') }} <br>
                        @endforeach
                    </th>
                @endif
            @endforeach
        </tr>
        <!-- Se imprimen los conceptos -->
        <!-- Se imprimen los totales -->
        <tr>
            <th></th>
            @foreach($operation->debitnotes as $debitnote)
                @if(!$debitnote->canceled_at)
                    <th>
                        Total: 
                    </th>
                    <strong><th>
                        <?php 
                            $rate = 0;
                            $iva = 0;
                            $tot = 0;
                        ?>
                        @foreach($debitnote->conceptsoperations as $conceptoperation)
                            <?php 
                                $rate = 0;
                                $iva = 0;
                                $rate = $rate + $conceptoperation->rate;
                                $iva = $iva + $conceptoperation->iva;
                                $tot = $tot + (($rate + $iva) * $conceptoperation->qty);
                            ?>
                        @endforeach
                        {{ number_format($tot, 2, '.', ',') }}
                    </th></strong>
                @endif
            @endforeach
            @foreach($operation->prefactures as $prefacture)
                @if(!$prefacture->canceled_at)
                    <th>
                        Total: 
                    </th>
                    <strong><th>
                        <?php 
                            $rate = 0;
                            $iva = 0;
                            $tot = 0;
                        ?>
                        @foreach($prefacture->conceptsoperations as $conceptoperation)
                            <?php 
                                $rate = 0;  
                                $iva = 0;
                                $rate = $rate + $conceptoperation->rate;
                                $iva = $iva + $conceptoperation->iva;
                                $tot = $tot + (($rate + $iva) * $conceptoperation->qty);
                            ?>
                        @endforeach
                        {{ number_format($tot, 2, '.', ',') }}
                    </th></strong>
                @endif
            @endforeach
        </tr>
        <!-- Se imprimen los totales -->
    @endforeach
    </thead>
</table>