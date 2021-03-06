<?php

namespace Httpfactory\Approvals\Events;

class ApprovalAwarded
{

    /**
     * The Approval Instance
     *
     * @var mixed
     */
    public $approval;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($approval)
    {
        $this->approval = $approval;
    }

}
