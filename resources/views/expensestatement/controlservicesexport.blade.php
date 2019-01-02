<table>
	<thead>
		<tr>
		</tr>
		<tr>
            <th colspan="3" style="background-color: #CCCC33;">RECIBO</th>
            <th colspan="13" style="background-color: #FF9900;"></th>
        </tr>
        <tr>
            <th style="background-color: #9999CC;">NUMERO DE USUARIO</th>
            <th style="background-color: #9999CC;">SERVICIO</th>
            <th style="background-color: #FF9999;"></th>
            <th style="background-color: #FFDEAD;">ENERO</th>
            <th style="background-color: #FFDEAD;">FEBRERO</th>
            <th style="background-color: #FFDEAD;">MARZO</th>
            <th style="background-color: #FFDEAD;">ABRIL</th>
            <th style="background-color: #FFDEAD;">MAYO</th>
            <th style="background-color: #FFDEAD;">JUNIO</th>
            <th style="background-color: #FFDEAD;">JULIO</th>
            <th style="background-color: #FFDEAD;">AGOSTO</th>
            <th style="background-color: #FFDEAD;">SEPTIEMBRE</th>
            <th style="background-color: #FFDEAD;">OCTUBRE</th>
            <th style="background-color: #FFDEAD;">NOVIEMBRE</th>
            <th style="background-color: #FFDEAD;">DICIEMBRE</th>
            <th style="background-color: #FFDEAD;">Total</th>
        </tr>
        <?php $enerogasto = 0; $febrerogasto = 0; $marzogasto = 0; $abrilgasto = 0; $mayogasto = 0; $juniogasto = 0; $juliogasto = 0; $agostogasto = 0; $septiembregasto = 0; $octubregasto = 0; $noviembregasto = 0; $diciembregasto = 0; $totaltotal = 0; ?>
        @foreach($services as $service)
            @if($service->id > 0 && $service->id < 14)
                <tr>
                    <th>{{ $service->numero_usuario }}</th>
                    <th>{{ $service->servicio }}</th>
                    <th>{{ $service->concepto_pago }}</th>
                    <?php $totalgasto = 0; ?>
                    @for ($i = 1; $i < 13; $i++)
                        @switch($i)
                            @case(1)
                                <?php $enerogasto = $enerogasto + $service->expensesPerMonth($i); ?>
                                @break

                            @case(2)
                                <?php $febrerogasto = $febrerogasto + $service->expensesPerMonth($i);  ?>
                                @break

                            @case(3)
                                <?php $marzogasto = $marzogasto + $service->expensesPerMonth($i);  ?>
                                @break

                            @case(4)
                                <?php $abrilgasto = $abrilgasto + $service->expensesPerMonth($i);  ?>
                                @break

                            @case(5)
                                <?php $mayogasto = $mayogasto + $service->expensesPerMonth($i);  ?>
                                @break

                            @case(6)
                                <?php $juniogasto = $juniogasto + $service->expensesPerMonth($i);  ?>
                                @break

                            @case(7)
                                <?php $juliogasto = $juliogasto + $service->expensesPerMonth($i);  ?>
                                @break

                            @case(8)
                                <?php $agostogasto = $agostogasto + $service->expensesPerMonth($i);  ?>
                                @break

                            @case(9)
                                <?php $septiembregasto = $septiembregasto + $service->expensesPerMonth($i);  ?>
                                @break

                            @case(10)
                                <?php $octubregasto = $octubregasto + $service->expensesPerMonth($i);  ?>
                                @break

                            @case(11)
                                <?php $noviembregasto = $noviembregasto + $service->expensesPerMonth($i);  ?>
                                @break

                            @case(12)
                                <?php $diciembregasto = $diciembregasto + $service->expensesPerMonth($i);  ?>
                                @break
                        @endswitch
                        <th>
                            <?php $totalgasto = $totalgasto + $service->expensesPerMonth($i); $totaltotal = $totaltotal + $totalgasto; ?>
                            @if($service->expensesPerMonth($i) != 0)
                                $ {{ number_format($service->expensesPerMonth($i), 2, '.', ',') }}
                            @else
                                -
                            @endif
                        </th>
                    @endfor

                    <th>$ {{ number_format($totalgasto, 2, '.', ',') }}</th>
                </tr>
            @endif
        @endforeach
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>$ {{ number_format($enerogasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($febrerogasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($marzogasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($abrilgasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($mayogasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($juniogasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($juliogasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($agostogasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($septiembregasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($octubregasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($noviembregasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($diciembregasto, 2, '.', ',') }}</th>
            <th>$ {{ number_format($totaltotal, 2, '.', ',') }}</th>
        </tr>
    </thead>
</table>