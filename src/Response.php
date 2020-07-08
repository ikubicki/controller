<?php

namespace Irekk\Controller;

use Irekk\Events\Promise;

class Response
{
    /**
     * @var integer $state 
     */
    protected $state = Promise::STATE_PENDING;
    
    /**
     * @var array $promises
     */
    protected $promises = [];
    
    /**
     * @var array $promises
     */
    protected $properties = [];
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @param mixed $value
     */
    public function set($property, $value)
    {
        $this->properties[$property] = $value;
    }
    
    /**
     *
     * @author ikubicki
     * @param string $property
     * @return mixed
     */
    public function get($property)
    {
        return $this->properties[$property] ?? false;
    }
    
    /**
     *
     * @author ikubicki
     * @param array $headers
     */
    public function headers(array $headers)
    {
        foreach ($headers as $header => $value) {
            $this->header($header, $value);
        }
    }
    
    /**
     *
     * @author ikubicki
     * @param string $header
     * @param mixed $value
     * @param integer $code
     */
    public function header($header, $value = null, $code = null)
    {
        $this->promises[] = $this->getPromise(function() use ($header, $value, $code) {
            header("$header: $value", true, $code);
        });
    }
    
    /**
     *
     * @author ikubicki
     * @param string $contents
     */
    public function send($contents)
    {
        $this->promises[] = $this->getPromise(function() use ($contents) {
            print $contents;
        });
    }
    
    /**
     *
     * @author ikubicki
     */
    public function resolve()
    {
        if ($this->isPending()) {
            foreach ($this->promises as $promise) {
                $promise->resolve(func_get_args());
            }
            $this->state = Promise::STATE_RESOLVED;
        }
    }
    
    /**
     *
     * @author ikubicki
     */
    public function reject()
    {
        $this->promises = [];
        $this->state = Promise::STATE_REJECTED;
    }
    
    /**
     *
     * @author ikubicki
     * @return boolean
     */
    public function isPending()
    {
        return $this->state == Promise::STATE_PENDING;
    }
    
    /**
     *
     * @author ikubicki
     * @return boolean
     */
    public function isResolved()
    {
        return $this->state == Promise::STATE_RESOLVED;
    }
    
    /**
     *
     * @author ikubicki
     * @return boolean
     */
    public function isRejected()
    {
        return $this->state == Promise::STATE_REJECTED;
    }
    
    /**
     *
     * @author ikubicki
     * @return Promise
     */
    public function getPromise($callback)
    {
        return new Promise($callback);
    }
}