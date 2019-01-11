<?php

namespace Httpfactory\Approvals\Contracts;


interface ApprovalRequestRepository {

    /**
     * Handles approving an approval object
     * @param $token
     * @return mixed
     */
    public function approve($token);

    /**
     * Handles declining an approvable object
     * @param $token
     * @return mixed
     */
    public function decline($token);


    /**
     * Handles checking if the token is valid
     * @param $token
     * @return boolean
     */
    public function tokenValid($token);
}