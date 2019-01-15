<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\ApprovalLevelRepository as ApprovalLevelRepositoryInterface;
use Httpfactory\Approvals\Models\ApprovalLevel;
use Httpfactory\Approvals\Models\ApprovalLevelUser;

class ApprovalLevelRepository implements ApprovalLevelRepositoryInterface
{


    /**
     * Gets the Approval Level By Id
     *
     * @param $approvalLevelId
     * @return mixed
     */
    public function getById($approvalLevelId)
    {
        $approvalLevel = ApprovalLevel::find($approvalLevelId);
        return $approvalLevel;
    }


    /**
     * Handles getting all approval levels for specified team
     *
     * @param $teamId   If teams are setup then use this else leave null
     * @return ApprovalLevel[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAll($teamId)
    {
        if($teamId){
            $approvalLevels = ApprovalLevel::where('team_id', $teamId)->get();
        }else{
            $approvalLevels = ApprovalLevel::all();
        }
        return $approvalLevels;
    }

    /**
     * Handles creating an Approval Level
     *
     * @param $data
     * @param $approval_element_id
     * @param $teamId
     * @return ApprovalLevel|mixed
     */
    public function create($data, $approval_element_id, $teamId)
    {
        $approvalLevel = new ApprovalLevel();
        if($teamId){
            $approvalLevel->team_id = $teamId;
        }
        $approvalLevel->approval_element_id = $approval_element_id;
        $approvalLevel->fill($data);
        $approvalLevel->save();

        return $approvalLevel;
    }


    /**
     * Handles updating an approval level
     * @param $data
     * @param $approvalLevelId
     * @return mixed
     */
    public function update($data, $approvalLevelId)
    {
        $group = ApprovalLevel::find($approvalLevelId);
        $group->fill($data);
        $group->save();
    }


    /**
     * Deletes the Approval level
     *
     * @param ApprovalLevel $approvalLevel
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($approvalLevel)
    {
        $group = $approvalLevel;
        $group->delete();

        return true;
    }


    /**
     * Handles attaching Users to a specific approval level
     *
     * @param $approvalLevelId
     * @param $users
     * @param $teamId
     */
    public function attachUsers($approvalLevelId, $users, $teamId)
    {
        $level = ApprovalLevel::where('team_id', '=', $teamId)->where('id', '=', $approvalLevelId)->first();
        $level->users()->saveMany($users);
    }

    /**
     * Handles detaching Users from a specific approval level
     *
     * @param $approvalLevelId
     * @param $users
     * @param $teamId
     */
    public function detachUsers($approvalLevelId, $users, $teamId)
    {
//        $group = $this->approvalLevel->where('team_id', '=', $teamId)->where('id', '=', $approvalLevelId)->first();
//        $group->users()->saveMany($users);
    }

}