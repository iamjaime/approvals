<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApprovalProcess;

class Tag extends Model
{

    protected $fillable = [
        'name'
    ];

    /**
     * The approvals that belong to this tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function approvals()
    {
        return $this->belongsToMany(ApprovalProcess::class, 'approval_process_tags');
    }
}