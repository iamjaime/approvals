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

}