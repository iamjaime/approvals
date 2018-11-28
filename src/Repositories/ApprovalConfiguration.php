<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\ApprovableConfig;

class ApprovalConfiguration implements ApprovableConfig {

    /**
     * The number of yes's required before auto approval
     * @var
     */
    public $yes;

    /**
     * The number of no's required before auto denial
     * @var
     */
    public $no;

    /**
     * The number of Yes's needed before automatically approved.
     * @param int $count  How many yes's
     * @return mixed|void
     */
    public function yes($count)
    {
        // TODO: Implement yes() method.
    }

    /**
     * The number of No's needed before automatically denied.
     * @param int $count  How many no's
     * @return mixed|void
     */
    public function no($count)
    {
        // TODO: Implement no() method.
    }

}