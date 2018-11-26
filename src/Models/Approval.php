<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\Tag;

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

}