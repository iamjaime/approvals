<?php

namespace Httpfactory\Approvals\Events;

class ApprovalApproved
{

    /**
     * The Approval Instance
     *
     * @var mixed
     */
    public $approval;

    /**
     * The user instance of the user approving the approval
     *
     * @var mixed
     */
    public $approvedBy;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($approval, $approvedBy)
    {
        $this->approval = $approval;
        $this->approvedBy = $approvedBy;
    }

}
