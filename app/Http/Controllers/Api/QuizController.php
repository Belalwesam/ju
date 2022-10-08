<?php

namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizRequest;
use App\Models\Answer;
use App\Models\Question;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::with('questions.answers')->get();
        return response()->json([
            'quizzes' => $quizzes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuizRequest $request)
    {
        // dd($request->all());
        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration
        ]);

        foreach ($request->questions as $question) {
            $question_store = Question::create([
                'question' => $question['question'],
                'quiz_id' => $quiz->id
            ]);
            $index = 0;
            foreach ($question['answers'] as $answer) {
                $answer = Answer::create([
                    'answer' => $answer,
                    'question_id' => $question_store->id
                ]);
                if ($question['correct'] == $index) {
                    $answer->update(['correct' => 1]);
                }
                $index++;
            }
        }
        return response()->json([
            'message' => 'quiz created succesfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['questions.answers']);
        return response()->json([
            'quiz' => $quiz
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        $quiz->load(['questions.answers']);
        $questions = $quiz->questions;
        /*  return $request->all();
        return ($questions); */
        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration
        ]);
        $index = 0;

        foreach ($questions as $question) {
            for ($i = 0; $i < $question->answers->count(); $i++) {
                $question->answers[$i]->update([
                    'answer' => $request->questions[$index]['answers'][$i],
                    'correct' => 0
                ]);
                if ($request->questions[$index]['correct'] == $i) {
                    $question->answers[$i]->update([
                        'correct' => 1
                    ]);
                }
            }
            $index++;
        }
        return response()->json([
            'message' => 'updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return response()->json([
            'message' => 'quiz deleted'
        ]);
    }
}
