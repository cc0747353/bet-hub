<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserWithdrawRequest extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var array
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

    public function build(): UserWithdrawRequest
    {
        return $this->subject($this->subject)
            ->markdown($this->view)
            ->with($this->data);
    }
}
