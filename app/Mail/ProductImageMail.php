<?php

namespace App\Mail;

use App\Models\Product; // <--- TRÈS IMPORTANT : Importe le modèle Product
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductImageMail extends Mailable
{
    use Queueable, SerializesModels;

    // 1. On déclare la propriété publique pour qu'elle soit accessible partout
    public $product;

    /**
     * 2. On reçoit le produit au moment de la création du mail
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lien de votre produit : ' . $this->product->name, // Plus joli avec le nom !
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.product-image',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [
            // Maintenant $this->product existe, donc l'image sera trouvée !
            Attachment::fromStorageDisk('public', $this->product->image),
        ];
    }
}