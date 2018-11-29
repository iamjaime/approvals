<?php

namespace Httpfactory\Approvals\Events;

class ApprovalDeclined
{

    /**
     * The Approval Instance
     *
     * @var mixed
     */
    public $approval;

    /**
     * The user instance of the user declining approval
     *
     * @var mixed
     */
    public $declinedBy;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($approval, $declinedBy)
    {
        $this->approval = $approval;
        $this->declinedBy = $declinedBy;
    }

}
