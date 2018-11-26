<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\Approval;
use Httpfactory\Approvals\Models\ApprovalConfiguration;

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
        return $this->belongsToMany(Approval::class);
    }


    /**
     * The approval configurations that belong to this tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function approvalConfigurations()
    {
        return $this->belongsToMany(ApprovalConfiguration::class);
    }
}