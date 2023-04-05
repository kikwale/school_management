<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendReceiptMaillable extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $school;
    public $fee_payment;
    public $student;
    public $parent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$school,$fee_payment,$student,$parent)
    {
        $this->title = $title;
        $this->school = $school;
        $this->fee_payment = $fee_payment;
        $this->student = $student;
        $this->parent = $parent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Receipt')->view('parent_receipt')->with('title',$this->title)
            ->with('school',$this->school)->with('fee_payment',$this->fee_payment)
            ->with('student', $this->student)
            ->with('parent', $this->parent);
    }
}
