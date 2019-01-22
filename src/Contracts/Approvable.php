<?php

namespace Httpfactory\Approvals\Contracts;


interface Approvable {

    /**
     * Handles sending the approval request
     * @return mixed
     */
    public function sendRequest();

}