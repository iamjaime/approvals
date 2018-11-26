<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\Tag;


class ApprovalConfiguration extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];


    /**
     * The tags associated with this approval configuration
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}