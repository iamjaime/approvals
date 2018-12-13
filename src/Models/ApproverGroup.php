<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApproverGroupUser;

class ApproverGroup extends Model
{

    protected $fillable = [
      'name',
      'description',
    ];


    /**
     * The users that belong to this approver group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(ApproverGroupUser::class, 'approver_group_id');
    }
}
