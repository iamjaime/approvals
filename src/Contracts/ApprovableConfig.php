<?php

namespace Httpfactory\Approvals\Contracts;


interface ApprovableConfig {

    /**
     * The number of Yes required before automatically approved
     * @param $count  int  How many yeses are needed?
     * @return mixed
     */
    public function yes($count);

    /**
     * The number of No required before automatically denied
     * @param $count  int  How many no's are needed?
     * @return mixed
     */
    public function no($count);

}