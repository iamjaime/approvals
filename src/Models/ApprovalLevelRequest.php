<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApprovalRequest;

class ApprovalLevelRequest extends Model
{


    /**
     * Gets the direct approval request associate with this level request
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function approvalRequest()
    {
        return $this->hasOne(ApprovalRequest::class, 'id', 'approval_request_id');
    }
}
