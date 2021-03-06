<?php

namespace Core\Http;

use Core\File\UploadedFile;

class Request
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $params;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->params = $_REQUEST;

        $this->setFiles();
    }

    /**
     * Put files from $_FILES to Request.
     *
     * @return void
     */
    protected function setFiles()
    {
        if (! count($_FILES)) {
            return false;
        }

        foreach ($_FILES as $key => $value) {
            $this->params[$key] = new UploadedFile($value);
        }
    }

    /**
     * Getter for request method.
     *
     * @return string
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * Getter for request uri.
     *
     * @return string
     */
    public function uri()
    {
        return $this->uri;
    }

    /**
     * Get all parameters from request.
     *
     * @return array
     */
    public function all()
    {
        return $this->params;
    }

    /**
     * Get subset of parameters from request.
     *
     * @param array $keys
     * @return array
     */
    public function only(array $keys)
    {
        return array_intersect_key($this->params, array_flip($keys));
    }

    /**
     * Get parameter from request.
     *
     * @param  string $key
     * @return mixed
     */
    public function input($key)
    {
        return $this->exists($key) ? $this->params[$key] : null;
    }

    /**
     * Check if Request contains a given parameter.
     *
     * @param  string  $key
     * @return boolean
     */
    public function exists($key)
    {
        return isset($this->params[$key]);
    }
}
