<?php

namespace Httpfactory\Approvals;

use Httpfactory\Approvals\Repositories\ApprovalProcessRepository;

class ApprovalProcess extends ApprovalProcessRepository {


    /**
     * Handles creating an approval process with an element at the same time
     *
     * @param $data
     * @param $team_id
     * @param $element \Httpfactory\Approvals\Models\ApprovalElement
     */
    public function createWithElement($data, $team_id, $element)
    {
        $process = $this->create($data, $team_id);
        $element->team_id = $team_id;
        $el = $process->approvalElement()->save($element);
        $data['approval_element_id'] = $el->id;
        $this->update($data, $process->id);
    }

}