<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class payment_email_template extends Mailable
{
    use Queueable, SerializesModels;
    public string $customer_name, $order_no, $order_date, $street_address1, $street_address2, $street_address3, $city, $state, $country, $zip_code, $phone_no, $payment_link;
    /**
     * Create a new message instance.
     */
    public function __construct($customer_name, $order_no, $order_date, $street_address1, $street_address2, $street_address3, $city, $state, $country, $zip_code, $phone_no, $payment_link)
    {
        $this->customer_name = $customer_name;
        $this->order_no = $order_no;
        $this->order_date = $order_date;
        $this->street_address1 = $street_address1;
        $this->street_address2 = $street_address2;
        $this->street_address3 = $street_address3;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->zip_code = $zip_code;
        $this->phone_no = $phone_no;
        $this->payment_link = $payment_link;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "BYJU'S ONLINE ORDERS - DO NOT REPLY",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.payment_email_template',
            with:
            [
                'customer_name' => $this->customer_name,
                'order_no' => $this->order_no,
                'order_date' => $this->order_date,
                'street_address1' => $this->street_address1,
                'street_address2' => $this->street_address2,
                'street_address3' => $this->street_address3,
                'city' => $this->city,
                'state' => $this->state,
                'country' => $this->country,
                'zip_code' => $this->zip_code,
                'phone_no' => $this->phone_no,
                'payment_link' => $this->payment_link
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
