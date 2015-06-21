<?php

namespace Router\Actions;

use Router\Exceptions\SecureActionFailedException;

require_once __DIR__ . "/FileIncludeAction.class.php";
require_once __DIR__ . "/../exceptions/SecureActionFailedException.class.php";

class SecureFileIncludeAction extends FileIncludeAction {

    /**
     * @throws SecureActionFailedException
     */
    public function doAction() {
        if($this->checkAuthenticated()) {
            parent::doAction();
        } else {
            throw new SecureActionFailedException("Authentication failed");
        }
    }

    private function checkAuthenticated() {
        return isset($_SESSION['user_id']);
    }
}