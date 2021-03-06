<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AuthorizeInvoiceProvider extends Notification
{
    protected $invoice;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if($this->invoice->guarantee_request != null){
            return [
                'created_user' => Auth::user()->id,
                'data' => 'AG'.$this->invoice->controlcode,
                'link' => route('operations.guaranteeRequest', $this->invoice->id),
                'message' => 'Pendiente autorización de solicitud de garantía.',
                'priority' => $this->invoice->priority
            ];
        }elseif ($this->invoice->advance_request != null) {
            return [
                'created_user' => Auth::user()->id,
                'data' => 'AA'.$this->invoice->controlcode,
                'link' => route('operations.advanceRequest', $this->invoice->id),
                'message' => 'Pendiente autorización de solicitud de anticipo.',
                'priority' => $this->invoice->priority
            ];
        }else{
            return [
                'created_user' => Auth::user()->id,
                'data' => 'AF'.$this->invoice->controlcode,
                'link' => route('operations.invoiceProvider', $this->invoice->id),
                'message' => 'Pendiente autorización de factura de proveedor.',
                'priority' => $this->invoice->priority
            ];
        }
    }
}
