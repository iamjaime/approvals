<?php

namespace Httpfactory\Approvals;

use Httpfactory\Approvals\Repositories\ApprovalLevelRepository;
use Httpfactory\Approvals\Models\ApprovalLevelUser;

class ApprovalLevel extends ApprovalLevelRepository {


    /**
     * Handles creating an approval level with users attached to it
     *
     * @param $data
     * @param $team_id
     * @param $approval_element_id
     * @param $users array of \Httpfactory\Approvals\Models\User instances
     * @return \Httpfactory\Approvals\Models\ApprovalLevel
     */
    public function createWithUsers($data, $team_id, $approval_element_id, $users)
    {
        $level = $this->create($data, $approval_element_id, $team_id);
        $levelUsers = [];

        foreach($users as $user){
            $levelUsers[] = new ApprovalLevelUser([
                'user_id' => $user->id,
                'team_id' => $team_id,
            ]);
        }

        $level->users()->saveMany($levelUsers);

        return $level;
    }

}