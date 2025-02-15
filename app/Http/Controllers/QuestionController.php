<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\AllMatch;
use App\Models\Question;
use App\Repositories\QuestionsRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends AppBaseController
{

    /**
     * @param QuestionsRepository $questionsRepo
     */
    public function __construct(QuestionsRepository $questionsRepo)
    {
        $this->questionsRepo = $questionsRepo;
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index($id)
    {
        $match = AllMatch::findOrFail($id);

        return view('manage_matches.match_questions.index', compact('match'));
    }

    public function store(CreateQuestionRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ?: 0;
        $input['is_locked'] = isset($input['is_locked']) ?: 0;
        $this->questionsRepo->create($input);

        return $this->sendSuccess(__('messages.flash.question_added'));
    }

    public function edit(Question $question): JsonResponse
    {
        return $this->sendResponse($question, __('messages.flash.questions_retrieved'));
    }

    public function update(UpdateQuestionRequest $request, Question $question): JsonResponse
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ?: 0;
        $this->questionsRepo->update($input, $question->id);

        return $this->sendSuccess(__('messages.flash.question_update'));
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $question = Question::findOrFail($request->id);
        $question->update(['status' => !$question->status]);

        return $this->sendResponse($question, __('messages.flash.question_status'));
    }

    public function changeLockedStatus(Request $request): JsonResponse
    {
        $question = Question::findOrFail($request->id);
        $question->update(['is_locked' => !$question->is_locked]);

        return $this->sendResponse($question, __('messages.flash.question_status'));
    }

    public function destroy(Question $question): JsonResponse
    {
        if ($question->options_count > 0) {
            return $this->sendError(__('messages.flash.question_can_not'));
        }
        $question->delete();

        return $this->sendSuccess(__('messages.flash.question_deleted'));
    }
}
