<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSocialIconsRequest;
use App\Http\Requests\UpdateSocialIconsRequest;
use App\Models\SocialIcon;
use App\Repositories\SocialIconRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Symfony\Component\Console\Application;

class SocialIconController extends AppBaseController
{

    /**
     * @param SocialIconRepository $socialIconRepository
     */
    public function __construct(SocialIconRepository $socialIconRepository)
    {
        $this->socialIconRepo = $socialIconRepository;
    }

    public function index(): Factory|View|Application
    {
        return view('social_icon.index');
    }

    public function store(CreateSocialIconsRequest $request): JsonResponse
    {
        $this->socialIconRepo->create($request->all());

        return $this->sendSuccess(__('messages.flash.social_icon_create'));
    }

    public function edit(SocialIcon $socialIcon): JsonResponse
    {
        return $this->sendResponse($socialIcon, __('messages.flash.social_icon_retrieved'));
    }


    public function update(UpdateSocialIconsRequest $request, $id): JsonResponse
    {
        $social_icon = $this->socialIconRepo->update($request->all(), $id);

        return $this->sendSuccess(__('messages.flash.social_icon_Update'));
    }


    public function destroy(SocialIcon $socialIcon): JsonResponse
    {
        $socialIcon->delete();

        return $this->sendSuccess(__('messages.flash.social_icon_deleted'));
    }
}
