<?php

namespace Httpfactory\Approvals;

use Httpfactory\Approvals\Repositories\Approval;


class MultiTierApproval extends Approval {

    public $approvalsNeededPerGroup = 2;

}