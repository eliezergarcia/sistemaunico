<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountManagementBalance extends Model
{
    protected $fillable = ['mxn', 'usd', 'debit', 'created_at', 'updated_at'];

    public function invoicesProviders()
    {
    	$invoices = InvoiceProvider::whereDate('aut_fin', '=', $this->created_at)->select('provider_id')->distinct()->get();

    	return $invoices;
    }

    public function invoicesClients()
    {
        $clients = Client::where('inactive_at', null)->get();

        return $clients;
    }

    public function clients($balance)
    {
    	return $payments = Payment::join("invoices","payments.invoice_id","=","invoices.id")
            ->whereDate('payments.created_at','=', $balance->created_at)
            ->select('client_id')->distinct()->get();
    }

    public function paymentsClient($balance, $client_id)
    {
        return $payments = Payment::join("invoices","payments.invoice_id","=","invoices.id")
            ->whereDate('payments.created_at','=', $balance->created_at)
            ->where('invoices.client_id', '=', $client_id)
            ->select('factura')->distinct()->get();
    }

    public function paymentsClientMXN($balance, $client_id)
    {
        return $payments = Payment::join("invoices","payments.invoice_id","=","invoices.id")
            ->whereDate('payments.created_at','=', $balance->created_at)
            ->where('invoices.client_id', '=', $client_id)
            ->where('invoices.moneda', '=', 'MXN')
            ->select('factura')->distinct()->get();
    }

    public function paymentsClientUSD($balance, $client_id)
    {
        return $payments = Payment::join("invoices","payments.invoice_id","=","invoices.id")
            ->whereDate('payments.created_at','=', $balance->created_at)
            ->where('invoices.client_id', '=', $client_id)
            ->where('invoices.moneda', '=', 'USD')
            ->select('factura')->distinct()->get();
    }

    public function paymentsClientTotalMXN($balance, $client_id)
    {
        return $payments = Payment::join("invoices","payments.invoice_id","=","invoices.id")
            ->whereDate('payments.created_at','=', $balance->created_at)
            ->where('payments.deleted_at', '=', NULL)
            ->where('invoices.client_id', '=', $client_id)
            ->where('invoices.moneda', '=', 'MXN')
            ->where('invoices.canceled_at', '=', NULL)->get();
    }

    public function ARBeginningBalanceClientMXN($balance, $client_id)
    {
        $invoices = Invoice::where('client_id', '=', $client_id)
            ->where('invoices.moneda', '=', 'MXN')->get();

        return $invoices->pluck('neto')->sum() + $invoices->pluck('iva')->sum();
    }

    public function CollectionClientTotalMXN($balance, $client_id)
    {
        return $payments = Payment::join("invoices","payments.invoice_id","=","invoices.id")
            ->whereDate('payments.created_at', '=', $balance->created_at)
            ->where('payments.deleted_at', '=', NULL)
            ->where('invoices.client_id', '=', $client_id)
            ->where('invoices.moneda', '=', 'MXN')
            ->where('invoices.canceled_at', '=', NULL)->get();
    }

    public function paymentsClientTotalUSD($balance, $client_id)
    {
        return $payments = Payment::join("invoices","payments.invoice_id","=","invoices.id")
            ->whereDate('payments.created_at','=', $balance->created_at)
            ->where('payments.deleted_at', '=', NULL)
            ->where('invoices.client_id', '=', $client_id)
            ->where('invoices.moneda', '=', 'USD')
            ->where('invoices.canceled_at', '=', NULL)->get();
    }

    public function ARBeginningBalanceClientUSD($balance, $client_id)
    {
        $invoices = Invoice::where('client_id', '=', $client_id)
            ->where('invoices.moneda', '=', 'USD')->get();

        return $invoices->pluck('neto')->sum() + $invoices->pluck('iva')->sum();
    }

    public function CollectionClientTotalUSD($balance, $client_id)
    {
        return $payments = Payment::join("invoices","payments.invoice_id","=","invoices.id")
            ->whereDate('payments.created_at', '=', $balance->created_at)
            ->where('payments.deleted_at', '=', NULL)
            ->where('invoices.client_id', '=', $client_id)
            ->where('invoices.moneda', '=', 'USD')
            ->where('invoices.canceled_at', '=', NULL)->get();
    }
}
