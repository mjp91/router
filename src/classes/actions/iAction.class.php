<?php

namespace Router\Actions;

/**
 * Represents the minimum specification for an Action
 *
 * @author Matthew Pearsall <mjp91@live.co.uk>
 *
 * Interface iAction
 * @package Router\Actions
 */
interface iAction {
    /**
     * Contains the logic for the class's Action
     *
     * @return mixed
     */
    public function doAction();
}