<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawRequestApproved extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var array|mixed
     */
    private $data;

    /**
     * @param $view
     * @param $subject
     * @param $data
     */
    public function __construct($view, $subject, $data = [])
    {
        $this->view = $view;
        $this->subject = $subject;
        $this->data = $data;
    }

    public function build(): WithdrawRequestApproved
    {
        return $this->subject($this->subject)
            ->markdown($this->view)
            ->with($this->data);
    }
}
