<?php

namespace Httpfactory\Approvals\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovalRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $approval;

    public $approver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($approval, $approver)
    {
        $this->approval = $approval;
        $this->approver = $approver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("approvals::emails.approval-request", ['approval' => $this->approval, 'approver' => $this->approver]);
    }
}