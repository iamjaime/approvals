<?php

namespace Httpfactory\Approvals\Contracts;


interface Approvable {

    /**
     * An array of users that approval is being requested from
     * @param $approvers
     * @return mixed
     */
    public function from($approvers);

    /**
     * Handles sending the approval request
     * @return mixed
     */
    public function sendRequest();

    /**
     * Handles approving an approval object
     * @param $request
     * @return mixed
     */
    public function approve($request);

    /**
     * Handles denying an approvable object
     * @param $request
     * @return mixed
     */
    public function deny($request);
}