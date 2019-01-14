<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApprovalLevel;


class ApprovalElement extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];


    /**
     * Gets the Approval Levels associated with this approval element.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function levels()
    {
        return $this->hasMany(\Httpfactory\Approvals\Models\ApprovalLevel::class);
    }
}