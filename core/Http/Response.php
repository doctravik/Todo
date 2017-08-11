<?php

namespace Core\Http;

use Core\View\Template;
use Core\Session\ErrorsSessionStorage;
use Core\Session\RequestSessionStorage;
use Core\Session\SuccessSessionStorage;

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

        return (new static($content));
    }

    /**
     * Redirect to the url.
     * 
     * @param  string $path
     * @return static
     */
    public static function redirect($url)
    {
        return (new static('Redirect'))
            ->withStatus(302)
            ->withHeader('Location', $url)
            ->withOldInput();
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
     * Set header for the web response.
     * 
     * @param  string $name
     * @param  string $value
     * @return $this
     */
    public function withHeader($name, $value)
    {
        $this->headers[] = [$name, $value];
        return $this;
    }

    /**
     * Save validation errors for the web response.
     * 
     * @param  array $errors
     * @return $this
     */
    public function withErrors(array $errors)
    {
        (new ErrorsSessionStorage())->set($errors);

        return $this;
    }

    /**
     * Save success message for the web response.
     * 
     * @param  array $message
     * @return $this
     */
    public function withSuccess(array $message)
    {
        (new SuccessSessionStorage())->set($message);

        return $this;
    }

    /**
     * Save old input for the web response.
     * 
     * @param  string $name
     * @param  string $value
     * @return $this
     */
    public function withOldInput()
    {
        (new RequestSessionStorage())->set($_REQUEST);

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