<?php

namespace Httpfactory\Approvals\Events;

class ApprovalDenied
{

    /**
     * The Approval Instance
     *
     * @var mixed
     */
    public $approval;

    /**
     * The user instance of the user denying approval
     *
     * @var mixed
     */
    public $deniedBy;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($approval, $deniedBy)
    {
        $this->approval = $approval;
        $this->deniedBy = $deniedBy;
    }

}
