<?php

namespace Core\Http;

use Core\View\Template;

class Response
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $status = 200;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * Return a new web response.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return void
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Render view.
     * 
     * @param  string $path
     * @param  array  $data
     * @return static
     */
    public static function view($path, $data = [])
    {
        $template = new Template("app/views/{$path}.view.php", $data);
        $content = $template->render();

        return new static($content);
    }

    /**
     * Set status code for the Response.
     * 
     * @param  integer $status
     * @return $this
     */
    public function withStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Set headers for the Response.
     * 
     * @param  array $headers
     * @return $this
     */
    public function withHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Retrieves the status code for the current web response.
     *
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->status;
    }

    /**
     * Retrieves the content for the current web response.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Retrieves the headers for the current web response.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}