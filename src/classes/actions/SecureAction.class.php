<?php

namespace Router\Actions;

use Router\Exceptions\ActionFailedException;

require_once __DIR__ . "/FileIncludeAction.class.php";
require_once __DIR__ . "/../exceptions/ActionFailedException.class.php";

class SecureFileIncludeAction extends FileIncludeAction {

    /**
     * @throws ActionFailedException
     */
    public function doAction() {
        if($this->checkAuthenticated()) {
            parent::doAction();
        } else {
            throw new ActionFailedException();
        }
    }

    private function checkAuthenticated() {
        return isset($_SESSION['user_id']);
    }
}