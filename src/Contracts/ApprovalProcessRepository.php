<?php

namespace Httpfactory\Approvals\Contracts;


interface ApprovalProcessRepository {

    /**
     * Handles creating an approval process
     * @param $data
     * @param $teamId
     * @return mixed
     */
    public function create($data, $teamId);


    /**
     * Handles updating an approval process
     * @param $data
     * @param $approvalProcessId
     * @return mixed
     */
    public function update($data, $approvalProcessId);

    /**
     * Handles getting a specific approval process
     * @param $approvalProcessId
     * @return mixed
     */
    public function getById($approvalProcessId);

    /**
     * Handles getting all approval processes for specific team id ( if we have a team id )
     * @param $teamId
     * @return mixed
     */
    public function getAll($teamId);


    /**
     * Handles deleting an approval process
     * @param $approvalProcess  \Httpfactory\Approvals\Models\ApprovalProcess   An approval process instance
     * @return mixed
     */
    public function delete($approvalProcess);

}