<?php

namespace App\Http\Controllers;

use App\Models\SeoTool;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Laracasts\Flash\Flash;

class SeoToolController extends AppBaseController
{

    public function index(): View|Factory|Application
    {
        $seo = SeoTool::all()->first();

        return view('seo-Tool.index', compact('seo'));
    }

    public function update(Request $request): Redirector|RedirectResponse|Application
    {
        $input = Arr::except($request->all(), '_token');
        $seoTool = SeoTool::first();
        $seoTool->update($input);

        Flash::success(__('messages.flash.SEO_tools_updated'));

        return redirect(route('seo-tools.index'));
    }
}
