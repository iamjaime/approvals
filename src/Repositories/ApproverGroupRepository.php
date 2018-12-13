<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\ApproverGroupRepository as ApproverGroupRepositoryInterface;
use Httpfactory\Approvals\Models\ApproverGroup;

class ApproverGroupRepository implements ApproverGroupRepositoryInterface
{

    /**
     * Gets the Approver Group By Id
     *
     * @param $approverGroupId
     * @return mixed|void
     */
    public function getById($approverGroupId)
    {
        $approverGroup = ApproverGroup::find($approverGroupId);
        return $approverGroup;
    }


    /**
     * Handles getting all approver groups for specified team
     *
     * @param $teamId   If teams are setup then use this else leave null
     * @return ApproverGroup[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAll($teamId)
    {
        if($teamId){
            $approverGroups = ApproverGroup::where('team_id', $teamId)->get();
        }else{
            $approverGroups = ApproverGroup::all();
        }
        return $approverGroups;
    }

    /**
     * Handles creating an Approval Group
     *
     * @param $data
     * @param $teamId
     * @return ApprovalGroup|mixed
     */
    public function create($data, $teamId)
    {
        $approvalGroup = new ApproverGroup();
        if($teamId){
            $approvalGroup->team_id = $teamId;
        }
        $approvalGroup->fill($data);
        $approvalGroup->save();

        return $approvalGroup;
    }


    /**
     * Handles updating an approver group
     * @param $data
     * @param $approverGroupId
     * @return mixed
     */
    public function update($data, $approverGroupId)
    {
        $group = ApproverGroup::find($approverGroupId);
        $group->fill($data);
        $group->save();
    }


    /**
     * Deletes the Approver group
     *
     * @param ApproverGroup $approverGroup
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($approverGroup)
    {
        $group = $approverGroup;
        $group->delete();

        return true;
    }

}