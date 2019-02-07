<?php

namespace Httpfactory\Approvals\Http\Controllers;

use Httpfactory\Approvals\Contracts\ApprovalRequestRepository as Approval;

class PendingApprovalController extends Controller
{

    public $approval;


    public function __construct(Approval $approval)
    {
        $this->approval = $approval;
    }


    /**
     * Handles approving the Approval.
     *
     * @param $token
     * @return mixed
     */
    public function approve($token)
    {
        $approvalRecord = $this->approval->tokenValid($token);
        abort_unless($approvalRecord, 404);

        $approval = $this->approval->approve($token);

        //now we should redirect somewhere...
        return view('approvals::approvals.approve');
    }

    /**
     * Handles declining the Approval.
     *
     * @param $token
     * @return mixed
     */
    public function decline($token)
    {
        $approvalRecord = $this->approval->tokenValid($token);
        abort_unless($approvalRecord, 404);

        $denial = $this->approval->decline($token);

        //now we should redirect somewhere...
        return view('approvals::approvals.denied');
    }
}
