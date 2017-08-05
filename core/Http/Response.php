<?php

namespace Core\Http;

use Core\View\Template;

class Response
{
    /**
     * Render view.
     * 
     * @param  string $path
     * @param  array  $data
     * @return void
     */
    public function view($path, $data = [])
    {
        $template = new Template("app/views/{$path}.view.php", $data);

        $template->render();
    }

    /**
     * Redirect to the url.
     * 
     * @param  string $url
     * @return void
     */
    public function redirect($url)
    {
        header("Location: $url");
    }
}