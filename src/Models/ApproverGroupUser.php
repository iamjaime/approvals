<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApproverGroup;

class ApproverGroupUser extends Model
{
    protected $fillable = [
        'level'
    ];


    /**
     * The Approver Group that this user belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approverGroup()
    {
        return $this->belongsTo(ApproverGroup::class);
    }

}
