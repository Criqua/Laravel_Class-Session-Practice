<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reportData;
    public $subject;

    public function __construct($reportData, $subject)
    {
        $this->subject = $subject;
        $this->reportData = $reportData;
    }

    /**
     * Se le envia todo lo considerado de report data a la vista.
     */
    public function build(){
        return $this->subject($this->subject)
                    ->view('emails.report')
                    ->with([
                        'reportData' => $this->reportData,
                    ]);
    }

}