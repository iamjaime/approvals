<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\ApprovalElementRepository as ApprovalElementRepositoryInterface;
use Httpfactory\Approvals\Models\ApprovalElement;

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
            $approvalElement = ApprovalElement::where('team_id', $teamId)->get();
        }else{
            $approvalElement = ApprovalElement::all();
        }
        return $approvalElement;
    }

    /**
     * Handles creating an Approval Element
     *
     * @param $data
     * @param $teamId
     * @return ApprovalElement|mixed
     */
    public function create($data, $teamId)
    {
        $approvalElement = new ApprovalElement();
        if($teamId){
            $approvalElement->team_id = $teamId;
        }
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