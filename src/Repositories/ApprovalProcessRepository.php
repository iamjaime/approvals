<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\ApprovalProcessRepository as ApprovalProcessRepositoryInterface;
use Httpfactory\Approvals\Models\ApprovalProcess;

class ApprovalProcessRepository implements ApprovalProcessRepositoryInterface
{

    /**
     * Gets the Approval Process By Id
     *
     * @param $approvalProcessId
     * @return mixed
     */
    public function getById($approvalProcessId)
    {
        $approvalProcess = ApprovalProcess::find($approvalProcessId);
        return $approvalProcess;
    }


    /**
     * Handles getting all approval processes for specified team
     *
     * @param $teamId   If teams are setup then use this else leave null
     * @return ApprovalProcess[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAll($teamId)
    {
        if($teamId){
            $approvalProcesses = ApprovalProcess::where('team_id', $teamId)->get();
        }else{
            $approvalProcesses = ApprovalProcess::all();
        }
        return $approvalProcesses;
    }

    /**
     * Handles creating an Approval Process
     *
     * @param $data
     * @param $teamId
     * @return ApprovalProcess|mixed
     */
    public function create($data, $teamId)
    {
        $approvalProcess = new ApprovalProcess();
        if($teamId){
            $approvalProcess->team_id = $teamId;
        }
        $approvalProcess->fill($data);
        $approvalProcess->save();

        return $approvalProcess;
    }


    /**
     * Handles updating an approval process
     * @param $data
     * @param $approvalProcessId
     * @return mixed
     */
    public function update($data, $approvalProcessId)
    {
        $group = ApprovalProcess::find($approvalProcessId);
        $group->fill($data);
        $group->save();
    }


    /**
     * Deletes the Approval Process
     *
     * @param ApprovalProcess $approvalProcess
     * @return mixed|void
     * @throws \Exception
     */
    public function delete($approvalProcess)
    {
        $process = $approvalProcess;
        $process->delete();

        return true;
    }

}