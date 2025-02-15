<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeagueRequest;
use App\Http\Requests\UpdateLeagueRequest;
use App\Models\Category;
use App\Models\League;
use App\Repositories\LeagueRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class LeagueController extends AppBaseController
{
    /**
     * @var LeagueRepository
     */
    private LeagueRepository $leagueRepository;

    /**
     * @param LeagueRepository $leagueRepository
     */
    public function __construct(LeagueRepository $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    public function index(): Factory|View|Application
    {
        $category = Category::where('status', 1)->pluck('name', 'id')->toArray();

        return view('leagues.index', compact('category'));
    }

    public function store(CreateLeagueRequest $request): JsonResponse
    {
        $this->leagueRepository->store($request->all());

        return $this->sendSuccess(__('messages.flash.league_create'));
    }

    public function edit(League $league): JsonResponse
    {
        return $this->sendResponse($league, __('messages.flash.league_retrieved'));
    }

    public function update(UpdateLeagueRequest $request, League $league): JsonResponse
    {
        $input = $request->all();
        $league = $this->leagueRepository->update($input, $league->id);

        return $this->sendSuccess(__('messages.flash.league_update'));

    }

    public function destroy(League $league): JsonResponse
    {
        if ($league->match_count > 0) {
            return $this->sendError(__('messages.flash.league_cannot_deleted'));

        }

        $league->delete();

        return $this->sendSuccess(__('messages.flash.league_deleted'));
    }

    public function changeLeagueStatus(League $league): JsonResponse
    {
        $league->update(['status' => $league->status == 0 ? 1 : 0]);

        return $this->sendResponse($league, __('messages.flash.league_status_update'));
    }
}
