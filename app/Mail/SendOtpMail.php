<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    // 🔥 kirim data OTP ke class
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    // subject email
    public function build()
    {
        return $this->subject('Kode OTP Anda')
            ->view('emails.otp')
            ->with([
                'otp' => $this->otp
            ]);
    }
}
