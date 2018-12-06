<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\Tag;
use Httpfactory\Approvals\Models\Approval;


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
        return $this->hasMany(Tag::class, 'approval_configurations_tags');
    }

    /**
     * The approval that this configuration belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approval()
    {
        return $this->belongsTo(Approval::class, 'approval_id');
    }
}