<?php

namespace Httpfactory\Approvals\Models;

use Illuminate\Database\Eloquent\Model;
use Httpfactory\Approvals\Models\Approval;
use App\User;

class Approver extends Model
{

    protected $fillable = [
        'status'
    ];


    /**
     * The approval associated with this approver
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approval()
    {
        return $this->belongsTo(Approval::class);
    }


    /**
     * This Approver's user data
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}