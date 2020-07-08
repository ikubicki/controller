<?php

namespace Irekk\Controller;

use Irekk\Promises\Promise;

class Response extends Promise
{
    
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
        $this->then(function() use ($header, $value, $code) {
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
        $this->then(function() use ($contents) {
            print $contents;
        });
    }
}