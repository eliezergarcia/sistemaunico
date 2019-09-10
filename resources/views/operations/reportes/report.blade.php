<table class="table">
    <thead>
        <tr>
            <th style="background-color: #9BC2E6">Operator</th>
            <th style="background-color: #9BC2E6">Shipper</th>
            <th style="background-color: #9BC2E6">Master Consignee</th>
            <th style="background-color: #9BC2E6">House Consignee</th>
            <th style="background-color: #9BC2E6">ETD</th>
            <th style="background-color: #9BC2E6">ETA</th>
            <th style="background-color: #9BC2E6">Impo/Expo</th>
            <th style="background-color: #9BC2E6">POL</th>
            <th style="background-color: #9BC2E6">POD</th>
            <th style="background-color: #9BC2E6">Destino</th>
            <th style="background-color: #9BC2E6">Incoterm</th>
            <th style="background-color: #9BC2E6">C. Invoice</th>
            <th style="background-color: #9BC2E6">M B/L</th>
            <th style="background-color: #9BC2E6">H B/L</th>
            <th style="background-color: #9BC2E6">CNTR #</th>
            <th style="background-color: #9BC2E6">Type</th>
            <th style="background-color: #9BC2E6">Size</th>
            <th style="background-color: #9BC2E6">Qty</th>
            <th style="background-color: #9BC2E6">Weight/Measures</th>
            <th style="background-color: #9BC2E6">Modalidad</th>
            <th style="background-color: #9BC2E6">AA</th>
            <th style="background-color: #A9D08E">(Pre Alert) Recibir</th>
            <th style="background-color: #A9D08E">Revisión (Modalidad, Documentos)</th>
            <th style="background-color: #A9D08E">Pre-Alert Mandar</th>
            <th style="background-color: #A9D08E">Revalidación (2 días antes)</th>
            <th style="background-color: #A9D08E">Toca Piso (Desconsolidada)</th>
            <th style="background-color: #A9D08E">Proforma (Recibida)</th>
            <th style="background-color: #A9D08E">Pago Proforma</th>
            <th style="background-color: #A9D08E">Solicitud de Transporte</th>
            <th style="background-color: #A9D08E">Despachado de Puerto Rail</th>
            <th style="background-color: #A9D08E">Port Etd</th>
            <th style="background-color: #A9D08E">Dlv Day</th>
            <th style="background-color: #A9D08E">Debit Note</th>
            <th style="background-color: #A9D08E">Prefactura</th>
        </tr>
        @foreach($operations as $operation)
            <tr>
                <th>{{ $operation->user->name }}</th>
                <th>{{ $operation->ship->codigo_cliente }}</th>
                <th>{{ $operation->master->codigo_cliente }}</th>
                <th>{{ $operation->house->codigo_cliente }}</th>
                <th>{{ $operation->etdFormat }}</th>
                <th>{{ $operation->etaFormat }}</th>
                <th>{{ $operation->impo_expo }}</th>
                <th>{{ $operation->pol }}</th>
                <th>{{ $operation->pod }}</th>
                <th>{{ $operation->destino }}</th>
                <th>{{ $operation->incoterm }}</th>
                <th>{{ $operation->c_invoice }}</th>
                <th>{{ $operation->m_bl }}</th>
                <th>{{ $operation->h_bl }}</th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->cntr }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->type }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->size }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->qty }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->weight }}/{{ $container->measures }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->modalidad }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>{{ $operation->recibirFormat }}</th>
                <th>{{ $operation->revisionFormat }}</th>
                <th>{{ $operation->mandarFormat }}</th>
                <th>{{ $operation->revalidacionFormat }}</th>
                <th>{{ $operation->tocapisoFormat }}</th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->proformaFormat }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->pagoproformaFormat }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->solicitudtransporteFormat }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->despachadopuertoFormat }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->portetdFormat }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th>@foreach($operation->containers as $container )
                        {{ $container->dlvdayFormat }}
                        @if(count($operation->containers) > 1)
                            <br>
                        @endif
                    @endforeach
                </th>
                <th></th>
                <th>@foreach($operation->debitnotes as $debitnote)
                        {{ $debitnote->numberformat }}, 
                    @endforeach
                </th>
                <th>@foreach($operation->prefactures as $prefacture)
                        {{ $prefacture->numberformat }}, 
                    @endforeach
                </th>
            </tr>
        @endforeach
    </thead>
</table>