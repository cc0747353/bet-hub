<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class NewsLetterController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('news_letter.index');
    }

    public function destroy($id): JsonResponse
    {
        $subscriber = Subscriber::find($id)->firstorFail();
        $subscriber->delete();

        return $this->sendSuccess(__('messages.flash.subscriber_delete'));
    }
}
