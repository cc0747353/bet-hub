<?php

namespace App\Repositories;

use App\Models\AllMatch;
use App\Models\Question;
use Carbon\Carbon;
use Exception;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class LeagueRepository
 */
class AllMatchRepository extends BaseRepository
{
    public $fieldSearchable = [
        'match_title',
    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return AllMatch::class;
    }

    public function store($input): bool
    {
        $matchStartTime = Carbon::parse($input['match_start'])->format('Y-m-d H:i:s');
        $match = AllMatch::whereLeagueId($input['league_id'])
            ->whereMatchStart($matchStartTime)
            ->first();
        if($match){
            Flash::error('Another match is already scheduled at the start time of this match.');
            
            return false;
        }
        try {
            $input['match_start'] = Carbon::parse($input['match_start'])->format('Y-m-d H:i');
            $input['start_from'] = Carbon::parse($input['start_from'])->format('Y-m-d H:i');
            $input['end_at'] = Carbon::parse($input['end_at'])->format('Y-m-d H:i');
            $allMatch = AllMatch::create($input);

            if (!empty($input['team_a_image'])) {
                $allMatch->addMedia($input['team_a_image'])->toMediaCollection(AllMatch::TEAM_A_IMAGE,
                    config('app.media_disc'));
            }
            if (!empty($input['team_b_image'])) {
                $allMatch->addMedia($input['team_b_image'])->toMediaCollection(AllMatch::TEAM_B_IMAGE,
                    config('app.media_disc'));
            }

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $allMatch): void
    {
        try {
            /** @var AllMatch $allMatch */
            $input['match_start'] = Carbon::parse($input['match_start'])->format('Y-m-d H:i');
            $input['start_from'] = Carbon::parse($input['start_from'])->format('Y-m-d H:i');
            $input['end_at'] = Carbon::parse($input['end_at'])->format('Y-m-d H:i');
            $allMatch->update($input);
            
            if (isset($input['is_locked'])){
                Question::whereMatchId($allMatch->id)->update(['is_locked' => true]);    
            }else{
                Question::whereMatchId($allMatch->id)->update(['is_locked' => false]);
            }
            
            if (isset($input['team_a_image']) && !empty($input['team_a_image'])) {
                $allMatch->clearMediaCollection(AllMatch::TEAM_A_IMAGE);
                $allMatch->addMedia($input['team_a_image'])->toMediaCollection(AllMatch::TEAM_A_IMAGE,
                    config('app.media_disc'));
            }
            if (isset($input['team_b_image']) && !empty($input['team_b_image'])) {
                $allMatch->clearMediaCollection(AllMatch::TEAM_B_IMAGE);
                $allMatch->addMedia($input['team_b_image'])->toMediaCollection(AllMatch::TEAM_B_IMAGE,
                    config('app.media_disc'));
            }
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

}
