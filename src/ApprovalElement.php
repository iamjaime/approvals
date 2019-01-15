<?php

namespace Httpfactory\Approvals;

use Httpfactory\Approvals\Repositories\ApprovalElementRepository;

class ApprovalElement extends ApprovalElementRepository {


    /**
     * Handles creating an approval element with a level
     *
     * @param $data
     * @param $team_id
     * @param $approval_process_id
     * @param $levels array of \Httpfactory\Approvals\Models\ApprovalLevel instances
     * @return \Httpfactory\Approvals\Models\ApprovalElement
     */
    public function createWithLevels($data, $team_id, $approval_process_id, $levels)
    {
        $element = $this->create($data, $approval_process_id, $team_id);

        //after creating the element, we want to create some levels with it....
        foreach($levels as $level){
            $level->team_id = $team_id;
            $level->approval_element_id = $element->id;
        }

        $element->levels()->saveMany($levels);

        return $element;
    }

}