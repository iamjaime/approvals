<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApprovalLevel;
use Httpfactory\Approvals\Models\ApprovalLevelRequest;

class ApprovalLevelUser extends Model
{
    protected $fillable = [
        'level_order'
    ];


    /**
     * The Approval Level that this user belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approvalLevel()
    {
        return $this->belongsTo(ApprovalLevel::class);
    }


    /**
     * Get the approval requests associated with this approval level user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvalRequests()
    {
        return $this->hasMany(ApprovalLevelRequest::class);
    }

}
