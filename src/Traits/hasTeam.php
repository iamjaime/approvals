<?php

namespace Httpfactory\Approvals\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

trait HasTeam {

    /**
     * Handles checking if user has team and if yes, gets the current team id.
     */
    protected function hasTeam()
    {
        if(Schema::hasTable('teams')){
            $user = Auth::user();
            $teamId = $user->current_team_id;
            return $teamId;
        }

        return null;
    }


}