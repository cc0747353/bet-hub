<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAllMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'match_title'  => 'required|unique:all_matches,match_title',
            'league_id'    => 'required',
            'start_from'   => 'required',
            'end_at'       => 'required',
            'team_a'       => 'required',
            'team_b'       => 'required',
            'match_start'  => 'required',
            'team_a_image' => 'nullable|mimes:jpeg,png,jpg|max:2000',
            'team_b_image' => 'nullable|mimes:jpeg,png,jpg|max:2000',
        ];
    }
}
