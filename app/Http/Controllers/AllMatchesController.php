<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAllMatchRequest;
use App\Http\Requests\UpdateAllMatchRequest;
use App\Models\AllMatch;
use App\Models\League;
use App\Models\MatchScore;
use App\Models\Question;
use App\Repositories\AllMatchRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;

class AllMatchesController extends AppBaseController
{

    /**
     * @param AllMatchRepository $allMatchRepo
     */
    public function __construct(AllMatchRepository $allMatchRepo)
    {
        $this->allMatchRepo = $allMatchRepo;
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('manage_matches.all_matches.index');
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $league = League::where('status', 1)->pluck('name', 'id')->toArray();

        return view('manage_matches.all_matches.create', compact('league'));
    }

    /**
     * @param CreateAllMatchRequest $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateAllMatchRequest $request)
    {
        $result = $this->allMatchRepo->store($request->all());
        
        if (!$result){
            return redirect(route('all-matches.create'))->withInput($request->all());
        }
        Flash::success(__('messages.flash.match_added'));

        return redirect(route('all-matches.index'));
    }

    /**
     * @param AllMatch $allMatch
     *
     *
     * @return Application|Factory|View
     */
    public function show(AllMatch $allMatch)
    {
        return view('manage_matches.all_matches.details', compact('allMatch'));
    }

    public function matchScoreStore(Request $request): JsonResponse
    {
        $input = $request->all();
        if (empty($input['team_a_score'])) {
            $teamAScore = MatchScore::whereMatchId($input['match_id'])->latest('created_at')->first()?->team_a_score;
            $input['team_a_score'] = $teamAScore;
        }
        if (empty($input['team_b_score'])) {
            $teamBScore = MatchScore::whereMatchId($input['match_id'])->latest('created_at')->first()?->team_b_score;
            $input['team_b_score'] = $teamBScore;
        }
        MatchScore::create($input);

        return $this->sendSuccess('Match score added successfully.');
    }


    /**
     * @param AllMatch $allMatch
     *
     *
     * @return Application|Factory|View
     */
    public function edit(AllMatch $allMatch)
    {
        $league = League::where('status', 1)->pluck('name', 'id')->toArray();

        return view('manage_matches.all_matches.edit', compact('allMatch', 'league'));
    }

    /**
     * @param UpdateAllMatchRequest $request
     * @param AllMatch $allMatch
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateAllMatchRequest $request, AllMatch $allMatch)
    {
        $this->allMatchRepo->update($request->all(), $allMatch);

        Flash::success(__('messages.flash.match_update'));

        return redirect(route('all-matches.index'));
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $match = AllMatch::findOrFail($request->id);
        $match->update(['status' => !$match->status]);

        return $this->sendResponse($match, __('messages.flash.match_status_update'));
    }

    public function changeLockedStatus(Request $request): JsonResponse
    {
        $match = AllMatch::findOrFail($request->id);
        $match->update(['is_locked' => !$match->is_locked]);

        if ($match->is_locked) {
            Question::whereMatchId($match->id)->update(['is_locked' => true]);
        } else {
            Question::whereMatchId($match->id)->update(['is_locked' => false]);
        }

        return $this->sendResponse($match, __('messages.flash.match_status_update'));
    }
}
