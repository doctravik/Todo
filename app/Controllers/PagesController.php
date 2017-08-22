<?php

namespace App\Controllers;

use Core\Http\Response;

class PagesController
{
    /**
     * Show about page
     *
     * @return Response
     */
    public function about()
    {
        return Response::view('about');
    }
}
