<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\Tag;
use Httpfactory\Approvals\Models\Approver;
use Httpfactory\Approvals\Models\Team;
use Httpfactory\Approvals\Models\User;
use Httpfactory\Approvals\Models\ApprovalConfiguration as Configuration;

class Approval extends Model
{

    protected $fillable = [
        'name',
        'description'
    ];


    /**
     * This approval's configurations
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function configuration()
    {
        return $this->hasOne(Configuration::class, 'approval_configuration_id');
    }

    /**
     * The team associated with this approval
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * The approval requester
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }


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