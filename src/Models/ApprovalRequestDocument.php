<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApprovalReqeust;

class ApprovalRequestDocument extends Model
{

    protected $fillable = [
        'document_name',
        'document_url',
    ];

    /**
     * The approval request that this document record belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approvalRequest()
    {
        return $this->belongsTo(ApprovalRequest::class, 'approval_request_id');
    }

}