<?php

namespace Httpfactory\Approvals\Contracts;


interface ApprovalRepository {

    /**
     * Handles approving an approval object
     * @param $token
     * @return mixed
     */
    public function approve($token);

    /**
     * Handles denying an approvable object
     * @param $token
     * @return mixed
     */
    public function deny($token);


    /**
     * Handles checking if the token is valid
     * @param $token
     * @return boolean
     */
    public function tokenValid($token);
}