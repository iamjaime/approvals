<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\ApproverGroupRepository as ApproverGroupRepositoryInterface;
use Httpfactory\Approvals\Models\ApproverGroup;
use Httpfactory\Approvals\Models\ApproverGroupUser;

class ApproverGroupRepository implements ApproverGroupRepositoryInterface
{

    public $approverGroup;

    public $approverGroupUser;


    public function __construct(ApproverGroup $approverGroup, ApproverGroupUser $approverGroupUser)
    {
        $this->approverGroup = $approverGroup;
        $this->approverGroupUser = $approverGroupUser;
    }


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


    /**
     * Handles attaching Users to a specific approver group
     *
     * @param $approverGroupId
     * @param $users
     * @param $teamId
     */
    public function attachUsers($approverGroupId, $users, $teamId)
    {
        $group = $this->approverGroup->where('team_id', '=', $teamId)->where('id', '=', $approverGroupId)->first();
        $group->users()->saveMany($users);
    }

    /**
     * Handles detaching Users from a specific approver group
     *
     * @param $approverGroupId
     * @param $users
     * @param $teamId
     */
    public function detachUsers($approverGroupId, $users, $teamId)
    {
//        $group = $this->approverGroup->where('team_id', '=', $teamId)->where('id', '=', $approverGroupId)->first();
//        $group->users()->saveMany($users);
    }

}