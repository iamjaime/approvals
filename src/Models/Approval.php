<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\Tag;
use Httpfactory\Approvals\Models\Approver;

class Approval extends Model
{

    protected $fillable = [
        'name',
        'description'
    ];


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
     * The approvers associated with this approval
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvers()
    {
        return $this->hasMany(Approver::class);
    }

}