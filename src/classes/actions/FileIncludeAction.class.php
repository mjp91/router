<?php

namespace Router\Actions;

use Router\Exceptions\ActionFailedException;

require_once __DIR__ . "/AbstractAction.class.php";
require_once __DIR__ . "/../exceptions/ActionFailedException.class.php";

class FileIncludeAction extends AbstractAction
{
    protected $file_uri;

    public function __construct($file_uri, $validHttpMethods)
    {
        $this->file_uri = $file_uri;
        parent::__construct($validHttpMethods);
    }

    /**
     * @throws ActionFailedException
     */
    public function doAction() {
        if(is_readable($this->file_uri)) {
            require $this->file_uri;
        } else {
            throw new ActionFailedException("Required file not found/not readable");
        }
    }

    /**
     * @return mixed
     */
    public function getFileUri()
    {
        return $this->file_uri;
    }

    /**
     * @param mixed $file_uri
     */
    public function setFileUri($file_uri)
    {
        $this->file_uri = $file_uri;
    }

}