<?php

namespace App;

use App\Presenters\ProviderPresenter;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use GeneralFunctions;

    protected $fillable = [
        'codigo_proveedor', 'razon_social', 'rfc', 'numero_interior', 'numero_exterior', 'calle', 'colonia', 'codigo_postal', 'pais', 'estado', 'ciudad', 'municipio', 'telefono1', 'telefono2', 'credit_days', 'service', 'inactive_at'
    ];

    public function accounts()
    {
    	return $this->hasMany(AccountProvider::class);
    }

    public function present()
    {
      return new ProviderPresenter($this);
    }

    public function invoices()
    {
        return $this->hasMany(InvoiceProvider::class);
    }

    public function accountManagementBalanceInvoicesMXN($balance)
    {
        $invoices = InvoiceProvider::where('provider_id', $this->id)->whereDate('aut_fin', '=', $balance->created_at)->get();

        $total = 0;
        foreach ($invoices as $invoice) {
            if ($invoice->account()->currency == "MXN") {
                $total = $total + (($invoice->neto + $invoice->vat + $invoice->others) - $invoice->retention);
            }
        }

        if ($total == 0) {
            return 0;
        }

        return $total;
    }

    public function accountManagementBalanceInvoicesUSD($balance)
    {
        $invoices = InvoiceProvider::where('provider_id', $this->id)->whereDate('aut_fin', '=', $balance->created_at)->get();

        $total = 0;
        foreach ($invoices as $invoice) {
            if ($invoice->account()->currency == "USD") {
                $total = $total + (($invoice->neto + $invoice->vat + $invoice->others) - $invoice->retention);
            }
        }

        if ($total == 0) {
            return 0;
        }

        return $total;
    }

    public function APBeginningBalanceProviderMXN($balance)
    {
        $invoices = InvoiceProvider::where('provider_id', $this->id)
                                   ->where('canceled_at', null)->get();

        $total = 0;
        foreach ($invoices as $invoice) {
            if ($invoice->account()->currency == "MXN") {
                $total = $total + (($invoice->neto + $invoice->vat + $invoice->others) - $invoice->retention);
            }
        }

        if ($total == 0) {
            return 0;
        }

        return $total;
    }

    public function PaymentProviderMXN($balance)
    {
        $invoices = InvoiceProvider::where('provider_id', $this->id)
                                   ->where('canceled_at', null)
                                   ->whereDate('aut_fin', '=', $balance->created_at)->get();

        $total = 0;
        foreach ($invoices as $invoice) {
            if ($invoice->account()->currency == "MXN") {
                $total = $total + (($invoice->neto + $invoice->vat + $invoice->others) - $invoice->retention);
            }
        }

        if ($total == 0) {
            return 0;
        }

        return $total;
    }

    public function APBeginningBalanceProviderUSD($balance)
    {
        $invoices = InvoiceProvider::where('provider_id', $this->id)
                                   ->where('canceled_at', null)->get();

        $total = 0;
        foreach ($invoices as $invoice) {
            if ($invoice->account()->currency == "USD") {
                $total = $total + (($invoice->neto + $invoice->vat + $invoice->others) - $invoice->retention);
            }
        }

        if ($total == 0) {
            return 0;
        }

        return $total;
    }

    public function PaymentProviderUSD($balance)
    {
        $invoices = InvoiceProvider::where('provider_id', $this->id)
                                   ->where('canceled_at', null)
                                   ->whereDate('aut_fin', '=', $balance->created_at)->get();

        $total = 0;
        foreach ($invoices as $invoice) {
            if ($invoice->account()->currency == "USD") {
                $total = $total + (($invoice->neto + $invoice->vat + $invoice->others) - $invoice->retention);
            }
        }

        if ($total == 0) {
            return 0;
        }

        return $total;
    }

    public function clients($balance)
    {
        $invoices = InvoiceProvider::where('provider_id', $this->id)
                                   ->where('canceled_at', null)
                                   ->whereDate('aut_fin', '=', $balance->created_at)->get();

        $clientes = collect([]);
        foreach ($invoices as $invoice) {
                $clientes->push($invoice->operation->house->codigo_cliente);
            // foreach ($invoice->operation->debitnotes as $debitnote) {
            //     $clientes->push($debitnote->client->codigo_cliente);
            // }
            // foreach ($invoice->operation->prefactures as $prefacture) {
            //     $clientes->push($prefacture->client->codigo_cliente);
            // }
        }

        $clientes_unique = $clientes->unique();

        return $clientes_unique->implode(', ');
    }

    public function unicoPic($balance)
    {
        $invoices = InvoiceProvider::where('provider_id', $this->id)->whereDate('aut_fin', '=', $balance->created_at)->get();

        $usuarios = collect([]);
        foreach ($invoices as $invoice) {
            $usuarios->push($invoice->operation->user->name);
        }

        $usuarios_unique = $usuarios->unique();

        return $usuarios_unique->implode(', ');
    }

    public function RemarksProviderMXN($balance)
    {
        $invoices = InvoiceProvider::where('provider_id', $this->id)->whereDate('aut_fin', '=', $balance->created_at)->get();

        $remarks = collect([]);
        foreach ($invoices as $invoice) {
            $account = AccountProvider::find($invoice->account_provider_id);
            if ($account->currency == "MXN") {
                if ($invoice->guarantee_request) {
                    $remarks->push('Advance Payment');
                }elseif ($invoice->advance_request) {
                    $remarks->push('Advance Payment');
                }elseif (!$invoice->guarantee_request && !$invoice->advance_request) {
                    $remarks->push('Invoice');
                }
            }
        }

        $remarks_unique = $remarks->unique();

        return $remarks_unique->implode(', ');
    }
}
