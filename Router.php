<?php

namespace Irekk\Controller;

use Irekk\Events\Listener;

class Router
{

    /**
     * @var array $listeners
     */
    protected $listeners = [];

    public function __construct()
    {
        // do nothing
    }

    public function get($route, $callback)
    {
        $this->getListenerForMethod('get')->on($route, $callback);
    }

    public function post($route, $callback)
    {
        $this->getListenerForMethod('post')->on($route, $callback);
    }

    public function delete($route, $callback)
    {
        $this->getListenerForMethod('delete')->on($route, $callback);
    }

    public function put($route, $callback)
    {
        $this->getListenerForMethod('put')->on($route, $callback);
    }

    public function dispatch(Request $request, Response $response = null)
    {
        $listener = $this->getListenersForMethod($request->getMethod());
        if ($listener) {
            $listener->emit($request, $response);
        }
    }

    protected function getListenersForMethod($requestMethod)
    {
        if (array_key_exists($requestMethod, $this->listeners)) {
            return $this->listeners[$requestMethod];
        }
        return [];
    }

    protected function getListenerForMethod($requestMethod)
    {
        if (empty($this->listeners[$requestMethod])) {
            $this->listeners[$requestMethod] = $this->getRoute();
        }
        return $this->listeners[$requestMethod];
    }
    
    protected function getRoute()
    {
        return new Route($this);
    }
}