<?php

namespace Shalvah\Ensure;

class RequirementFailedException extends \Exception
{
    protected $data;

    public function __construct($message, $data = null)
    {
        parent::__construct($message);
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

}
