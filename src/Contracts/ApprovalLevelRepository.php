<?php

namespace Httpfactory\Approvals\Contracts;


interface ApprovalLevelRepository {

    /**
     * Handles creating an approver group
     * @param $data
     * @param $teamId
     * @return mixed
     */
    public function create($data, $teamId);


    /**
     * Handles updating an approver group
     * @param $data
     * @param $approverGroupId
     * @return mixed
     */
    public function update($data, $approverGroupId);

    /**
     * Handles getting a specific approver group
     * @param $approverGroupId
     * @return mixed
     */
    public function getById($approverGroupId);

    /**
     * Handles getting all approver groups for specific team id ( if we have a team id )
     * @param $teamId
     * @return mixed
     */
    public function getAll($teamId);


    /**
     * Handles deleting an approver group
     * @param $approverGroup  \Httpfactory\Approvals\Models\ApproverGroup   An approver group instance
     * @return mixed
     */
    public function delete($approverGroup);


    /**
     * Handles attaching Users to a specific approver group
     *
     * @param $approverGroupId
     * @param $users
     * @param $teamId
     */
    public function attachUsers($approverGroupId, $users, $teamId);

    /**
     * Handles detaching Users from a specific approver group
     *
     * @param $approverGroupId
     * @param $users
     * @param $teamId
     */
    public function detachUsers($approverGroupId, $users, $teamId);
}