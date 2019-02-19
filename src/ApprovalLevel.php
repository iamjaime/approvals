<?php

namespace Httpfactory\Approvals;

use Httpfactory\Approvals\Repositories\ApprovalLevelRepository;
use Httpfactory\Approvals\Models\ApprovalLevelUser;
use Httpfactory\Approvals\Models\ApprovalLevel as Level;

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


    /**
     * Handles updating approval level
     *
     * @param $data
     * @param $team_id
     * @param $approval_element_id
     * @param $levelId
     * @param $users
     * @return mixed
     */
    public function updateWithUsers($data, $team_id, $approval_element_id, $levelId, $users)
    {
        $approvalLevel = Level::where('id', $levelId)->first();

        $approvalLevel->fill($data);
        $approvalLevel->save();

        $this->truncateCurrentLevelApprovers($levelId);

        $this->saveUsers($approvalLevel, $team_id, $users);

        return $approvalLevel;
    }

    /**
     * Handles saving the level users.
     *
     * @param $level
     * @param $team_id
     * @param $approval_level_id
     * @param $users
     */
    protected function saveUsers($level, $team_id, $users){
        $levelUsers = [];
        foreach($users as $user){
            $levelUsers[] = new ApprovalLevelUser([
                'user_id' => $user->id,
                'team_id' => $team_id,
            ]);
        }
        $level->users()->saveMany($levelUsers);
    }


    /**
     * Deletes all the current level approvers.
     *
     * @param $level_id
     * @return bool
     */
    protected function truncateCurrentLevelApprovers($level_id)
    {
        $approvalLevelUser = new ApprovalLevelUser();
        $approvalLevelUser->where('approval_level_id', '=', $level_id)->delete();

        return true;
    }
}