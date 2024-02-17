<?php

namespace App\Mail\Guarantor;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GuaranteedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $loan;

    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    public function build()
    {
        return $this->subject('Your Loan Request '.$this->loan->name.' Has Been Guaranteed ')
        ->view('mails.guarantor.guaranteed');
    }
}