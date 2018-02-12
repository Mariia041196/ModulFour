<?php

class Request
{
    private $post;
    private $get;

    public function __construct(array $get = [], array $post = [])
    {
        $this->post = $post;
        $this->get = $get;
    }

    public function post($key)
    {
        if (isset($this->post[$key])) {
           return $this->post[$key];
        }
        return null;
    }
    public function get($key)
    {
        if (isset($this->get[$key])) {
           return $this->get[$key];
        }
        return null;
    }
    public function isPost()
    {
        return (bool) $this->post;
    }
}