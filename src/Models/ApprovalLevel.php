<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApprovalLevelUser;

class ApprovalLevel extends Model
{

    protected $fillable = [
      'name',
      'description',
      'required_yes_count',
      'required_no_count',
      'level_order'
    ];


    /**
     * The users/approvers that belong to this approval level
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvers()
    {
        return $this->hasMany(ApprovalLevelUser::class, 'approval_level_id');
    }
}
