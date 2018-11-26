<?php

namespace Httpfactory\Approvals\Events;

class ApprovalRequest
{

    /**
     * The Approval Instance
     *
     * @var mixed
     */
    public $approval;

    /**
     * The user instances of the users that need to approve
     *
     * @var array an array of user instances
     */
    public $users;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($approval, $users)
    {
        $this->approval = $approval;
        $this->users = $users;
    }

}
