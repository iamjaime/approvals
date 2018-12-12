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
     * Updates an Approver Group
     *
     * @param ApproverGroup $approverGroup
     * @return mixed|void
     */
    public function update($approverGroup)
    {
        $group = ApproverGroup::find($approverGroup->id);
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