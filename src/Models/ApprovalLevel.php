<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\ApprovalLevelUser;

class ApprovalLevel extends Model
{

    protected $fillable = [
      'name',
      'description',
    ];


    /**
     * The users that belong to this approval level
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(ApprovalLevelUser::class, 'approval_level_id');
    }
}
