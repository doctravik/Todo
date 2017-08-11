<?php

namespace Core\View;

use Core\Exceptions\ViewNotFoundException;

class Template
{
    /**
     * @var string layout;
     */
    private $layout = null;

    /**
     * @var string path
     */
    private $path;

    /**
     * @var array data
     */
    private $data;

    /**
     * @param string $path
     * @param array $data
     */
    public function __construct($path, $data)
    {
        $this->path = $path;
        $this->data = $data;
    }

    /**
     * Render template.
     * 
     * @return string
     */
    public function render() {
        return $this->compileView();
    }

    /**
     * Compile view with layout.
     * 
     * @return string
     */
    private function compileView()
    {
        $content = $this->bufferOutput($this->path, $this->data);

        if ($this->layout) {
            return $this->bufferOutput($this->layout, compact('content'));
        }

        return $content;
    }

    /**
     * Put output to the buffer.
     *
     * @param string $path
     * @param mixed $data
     * @return string
     */
    private function bufferOutput($path, $data)
    {
        try {
            $this->validate($path);
        } catch (ViewNotFoundException $e) {
            die($e->getMessage());
        }

        extract($data);

        ob_start();

        require $path;

        $output = ob_get_clean();

        if(isset($layout)) {
            $this->setLayout($layout);
        }

        return $output;
    }

    /**
     * Validate path to the view.
     *
     * @param string $path
     * @return void
     * @throw ViewNotFoundException if view could not be found
     */
    private function validate($path)
    {
        if (! file_exists($path)) {
            throw new ViewNotFoundException("Could not load view with path: $path");
        }
    }

    /**
     * Set layout.
     *
     * @param string $path
     * @return void
     */
    private function setLayout($path)
    {
        $this->layout = $path;
    }
}
