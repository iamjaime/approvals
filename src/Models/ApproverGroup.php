<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;

class ApproverGroup extends Model
{

    protected $fillable = [
      'name',
      'description',
    ];
}
