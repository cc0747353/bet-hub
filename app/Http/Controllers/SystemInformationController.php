<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SystemInformationController extends AppBaseController
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('system_information.index');
    }
}
