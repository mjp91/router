<?php

namespace Router\Actions;

require_once __DIR__ . "/iAction.class.php";

/**
 * Abstraction of an action accessed through HTTP
 *
 * @author Matthew Pearsall <mjp91@live.co.uk>
 *
 * Class AbstractAction
 * @package Router\Actions
 */
abstract class AbstractAction implements iAction
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    private $validHttpMethods = array();

    public function __construct($validHttpMethods)
    {
        $this->validHttpMethods = $validHttpMethods;
    }

    /**
     * Returns an array of valid HTTP methods that an Action extending this class can be
     * used with
     *
     * @return array
     */
    public function getValidHttpMethods()
    {
        return $this->validHttpMethods;
    }
}