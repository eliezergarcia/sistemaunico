<table>
	<thead>
		<tr>
			<th>EXPENSES STATEMENT</th>
		</tr>
		<tr></tr>
		<tr>
			<th></th>
            <th style="background-color: #6699CC">REPORTING</th>
            <th style="background-color: #D3D3D3;">Edith Valdez</th>
            <th style="background-color: #6699CC">FROM</th>
            <th style="background-color: #D3D3D3;"></th>
        </tr>
        <tr>
        	<th></th>
            <th style="background-color: #6699CC">APPROVED</th>
            <th style="background-color: #D3D3D3;">Young Rak Kim</th>
            <th style="background-color: #6699CC">TO</th>
            <th style="background-color: #D3D3D3;"></th>
        </tr>
        <tr>
        	<th style="background-color: #66CCCC;">INVOICE</th>
        	<th style="background-color: #66CCCC;">DATE</th>
        	<th style="background-color: #66CCCC;">INVOICE DATE</th>
        	<th style="background-color: #66CCCC;">EXPENSE TYPE</th>
        	<th style="background-color: #66CCCC;">DESCRIPTION</th>
        	<th style="background-color: #66CCCC;">AMOUNT</th>
        	<th style="background-color: #66CCCC;">VAT</th>
        	<th style="background-color: #66CCCC;">RETENCION</th>
        	<th style="background-color: #66CCCC;">OTROS SERVICIOS</th>
        	<th style="background-color: #66CCCC;">TOTAL</th>
        	<th style="background-color: #66CCCC;">CANTIDADES PENDIENTES</th>
        	<th style="background-color: #66CCCC;">PAYMENT SOURCE</th>
        	<th style="background-color: #66CCCC;">NOTES</th>
        	<th style="background-color: #66CCCC;">CONTROL CODE</th>
        	<th style="background-color: #66CCCC;">PAYMENT STATUS</th>
        	<th style="background-color: #66CCCC;">EXPENSE DESCRIPTION</th>
        </tr>
        @foreach($expenses as $expense)
        	<tr>
	        	<th>{{ $expense->invoice }}</th>
	        	<th>{{ $expense->created_at->format('d-m') }}</th>
	        	<th>{{ $expense->invoice_date }}</th>
	        	<th>{{ $expense->expense_type }}</th>
	        	<th>{{ $expense->description }}</th>
	        	<th>{{ $expense->neto }}</th>
	        	<th>{{ $expense->vat }}</th>
	        	<th>- {{ $expense->retention }}</th>
	        	<th>{{ $expense->others }}</th>
	        	<th>{{ $expense->total }}</th>
	        	<th></th>
	        	<th></th>
	        	<th>{{ $expense->notes }}</th>
	        	<th>{{ $expense->controlcode }}</th>
	        	<th></th>
	        	<th>{{ $expense->expense_description }}</th>
        	</tr>
        @endforeach
	</thead>
</table>