<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'users';

    protected $hidden = ['password', 'remember_token'];
}