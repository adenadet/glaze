<?php

namespace App\Mail\Guarantor;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $loan;
    public $guarantor;

    public function __construct($loan, $guarantor)
    {
        $this->loan = $loan;
        $this->guarantor = $guarantor;
    }

    public function build()
    {
        return $this->subject('Request for Loan Guarantee '.$this->loan->user->first_name.' '.$this->loan->user->last_name)
        ->view('mails.guarantor.request');
    }
}