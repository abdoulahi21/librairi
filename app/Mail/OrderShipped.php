<?php

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Générer la facture en PDF
        $pdf = Pdf::loadView('emails.order.invoice', ['order' => $this->order]);

        return $this->subject('Votre Facture de Commande')
            ->view('emails.order.shipped')  // Vue de l'email
            ->attachData($pdf->output(), 'facture.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
