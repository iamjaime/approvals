<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;


class ApprovalProcess extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];
}