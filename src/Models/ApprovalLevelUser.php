<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApprovalLevel;

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

}
