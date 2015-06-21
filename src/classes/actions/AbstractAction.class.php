<?php

namespace Router\Actions;

require_once __DIR__ . "/iAction.class.php";

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

    public function getValidHttpMethods()
    {
        return $this->validHttpMethods;
    }
}