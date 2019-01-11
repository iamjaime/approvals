<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;


class ApprovalElement extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];
}