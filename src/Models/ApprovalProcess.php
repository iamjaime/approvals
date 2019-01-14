<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApprovalElement;

class ApprovalProcess extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];


    /**
     * Gets the approval element associated with this approval process.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function approvalElement()
    {
        return $this->hasOne(\Httpfactory\Approvals\Models\ApprovalElement::class);
    }
}