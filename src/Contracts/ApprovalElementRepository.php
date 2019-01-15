<?php

namespace Httpfactory\Approvals\Contracts;


interface ApprovalElementRepository {

    /**
     * Handles creating an approval element
     * @param $data
     * @param $teamId
     * @return mixed
     */
    public function create($data, $teamId);


    /**
     * Handles updating an approval element
     * @param $data
     * @param $approvalElementId
     * @return mixed
     */
    public function update($data, $approvalElementId);

    /**
     * Handles getting a specific approval element
     * @param $approvalElementId
     * @return mixed
     */
    public function getById($approvalElementId);

    /**
     * Handles getting all approval elements for specific team id ( if we have a team id )
     * @param $teamId
     * @return mixed
     */
    public function getAll($teamId);


    /**
     * Handles deleting an approval element
     * @param $approvalElement  \Httpfactory\Approvals\Models\ApprovalElement   An approval element instance
     * @return mixed
     */
    public function delete($approvalElement);

}