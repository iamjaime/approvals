<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\ApprovalElementRepository as ApprovalElementRepositoryInterface;
use Httpfactory\Approvals\Models\ApprovalElement;
use Httpfactory\Approvals\Models\User;

class ApprovalElementRepository implements ApprovalElementRepositoryInterface
{

    /**
     * Gets the Approval Element By Id
     *
     * @param $approvalElementId
     * @return mixed
     */
    public function getById($approvalElementId)
    {
        $approvalElement = ApprovalElement::find($approvalElementId);
        return $approvalElement;
    }


    /**
     * Handles getting all approval elements for specified team
     *
     * @param $teamId   If teams are setup then use this else leave null
     * @return ApprovalElement[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAll($teamId)
    {
        if($teamId){
            $approvalElement = ApprovalElement::where('team_id', $teamId)->with('levels.users')->get();
            foreach ($approvalElement as $elem){
                foreach($elem->levels as $level){
                    $users = $this->getLevelUsers($level->users);
                    unset($level->users);
                    $level->users = $users;
                }
            }
        }else{
            $approvalElement = ApprovalElement::all();
        }
        return $approvalElement;
    }

    /**
     * Handles getting the level user ids and converting them into
     * User objects
     */
    private function getLevelUsers($users)
    {
        $userIds = [];

            foreach($users as $user){
                array_push($userIds, $user->user_id);
            }

        $users = User::whereIn('id', $userIds)->get();

        return $users;
    }

    /**
     * Handles creating an Approval Element
     *
     * @param $data
     * @param $approval_process_id
     * @param $teamId
     * @return ApprovalElement|mixed
     */
    public function create($data, $approval_process_id, $teamId)
    {
        $approvalElement = new ApprovalElement();

        if($teamId){
            $approvalElement->team_id = $teamId;
        }
        $approvalElement->approval_process_id = $approval_process_id;
        $approvalElement->fill($data);
        $approvalElement->save();

        return $approvalElement;
    }


    /**
     * Handles updating an approval element
     * @param $data
     * @param $approvalElementId
     * @return mixed
     */
    public function update($data, $approvalElementId)
    {
        $element = ApprovalElement::find($approvalElementId);
        $element->fill($data);
        $element->save();
    }


    /**
     * Deletes the Approval Element
     *
     * @param ApprovalElement $approvalElement
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($approvalElement)
    {
        $element = $approvalElement;
        $element->delete();

        return true;
    }

}