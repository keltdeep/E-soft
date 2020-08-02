<?php

namespace App\Exceptions;

use Exception;
use http\Env\Request;

class CustomException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {


        return response()->view(
            'errors.money',
            array(
                'exception' => $this
            )
        );
    }
}
