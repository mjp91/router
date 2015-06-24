<?php

namespace Router\Actions;

use Router\Exceptions\ActionFailedException;

require_once __DIR__ . "/AbstractAction.class.php";
require_once __DIR__ . "/../exceptions/ActionFailedException.class.php";

/**
 * Action class to include a file
 *
 * @author Matthew Pearsall <mjp91@live.co.uk>
 *
 * Class FileIncludeAction
 * @package Router\Actions
 */
class FileIncludeAction extends AbstractAction
{
    protected $file_uri;

    public function __construct($file_uri, $validHttpMethods)
    {
        $this->file_uri = $file_uri;
        parent::__construct($validHttpMethods);
    }

    public function doAction() {
        if(is_readable($this->file_uri)) {
            require $this->file_uri;
        } else {
            throw new ActionFailedException("Required file not found/not readable");
        }
    }

    /**
     * Returns the file URI this class includes
     *
     * @return mixed
     */
    public function getFileUri()
    {
        return $this->file_uri;
    }

    /**
     * Sets the file URI this class includes
     *
     * @param mixed $file_uri
     */
    public function setFileUri($file_uri)
    {
        $this->file_uri = $file_uri;
    }

}