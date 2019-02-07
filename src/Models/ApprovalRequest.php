<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\Tag;
use Httpfactory\Approvals\Models\Team;
use Httpfactory\Approvals\Models\User;
use Httpfactory\Approvals\Models\ApprovalProcess;
use Httpfactory\Approvals\Models\ApprovalRequestDocument;

class ApprovalRequest extends Model
{

    protected $fillable = [
        'name',
        'description'
    ];


    /**
     * The team associated with this approval
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * The approval requester
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }


    /**
     * The tags associated with this approval
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'approval_tags');
    }


    /**
     * Gets the approval process associated with this request
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function approvalProcess()
    {
        return $this->hasOne(ApprovalProcess::class, 'id', 'approval_process_id');
    }


    /**
     * Gets the documents that belong to this approval request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(ApprovalRequestDocument::class, 'approval_request_id', 'id');
    }

}