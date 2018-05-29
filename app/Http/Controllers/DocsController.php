<?php

namespace App\Http\Controllers;

class DocsController extends Controller {

    public function index() {
        $apiAddress = config('app.url') . '/api';
        $swaggerFolder = 'swagger/ui/dist';

        return view('docs', ['swaggerFolder' => $swaggerFolder
            , 'apiAddress' => $apiAddress]);
    }

}
