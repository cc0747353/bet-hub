<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;

class CustomCssController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('custom_css.custom-css');
    }

    /**
     * @param Request $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $fileName = public_path("assets/css/custom.css");
        file_put_contents($fileName, $input['css_content']);
        Flash::success(__('messages.flash.css_updated'));

        return redirect(route('custom-css.index'));
    }
}
