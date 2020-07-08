<?php

namespace Irekk\Controller;

use Irekk\Events\Event;

class Request extends Event
{
    
    public function getMethod()
    {
        return $this->subject;
    }

    public function build()
    {
        $this->subject = strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');
        $this->type = strtolower($_SERVER['REQUEST_URI'] ?? '/');
        $this->payload = (array) $_REQUEST;
        return $this;
    }

    public function get($parameter)
    {
        return $this->payload[$parameter] ?? false;
    }
}