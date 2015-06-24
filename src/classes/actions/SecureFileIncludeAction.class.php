<?php

namespace Router\Actions;

use Router\Exceptions\SecureActionFailedException;

require_once __DIR__ . "/FileIncludeAction.class.php";
require_once __DIR__ . "/../exceptions/SecureActionFailedException.class.php";

/**
 * Performs a security check before including a file
 *
 * @author Matthew Pearsall <mjp91@live.co.uk>
 *
 * Class SecureFileIncludeAction
 * @package Router\Actions
 */
class SecureFileIncludeAction extends FileIncludeAction {

    public function doAction() {
        if($this->checkAuthenticated()) {
            parent::doAction();
        } else {
            throw new SecureActionFailedException("Authentication failed");
        }
    }

    /**
     * Checks the user's session to see if they authenticated
     *
     * @return bool
     */
    private function checkAuthenticated() {
        return isset($_SESSION['user_id']);
    }
}