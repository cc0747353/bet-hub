<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;

class BlogController extends AppBaseController
{

    /**
     * @param BlogRepository $blogRepository
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepo = $blogRepository;
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('cms.blog.index');
    }


    /**
     *
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('cms.blog.create');
    }


    /**
     * @param CreateBlogRequest $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateBlogRequest $request)
    {
        $this->blogRepo->store($request->all());

        Flash::success(__('messages.flash.blog_create'));

        return redirect(route('blog.index'));
    }

    /**
     * @param $id
     *
     *
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        return view('cms.blog.edit', compact('blog'));
    }

    /**
     * @param UpdateBlogRequest $request
     * @param Blog $blog
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $this->blogRepo->update($request->all(), $blog);

        Flash::success(__('messages.flash.blog_updated'));

        return redirect(route('blog.index'));
    }

    public function destroy(Blog $blog): JsonResponse
    {
        $blog->delete();

        return $this->sendSuccess(__('messages.flash.blog_deleted'));
    }
}
