<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timetable;
use App\User;
use App\Lesson;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    //
    public function index(Request $request)
    {
        // 考えたくないのでフロントで実装した。
        return Auth::user()->timetables()->with(['lesson', 'person_lesson'])->get();
    }

    public function show($id)
    {
        return Auth::user()->tasks()->where('lesson_id', '=', $id)->get();
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|max:30|alpha_num',
            'limit' => 'required|numeric',
        ]);
      
        return Lesson::create([
            'title' => $request->input('title'),
            'limit' => $request->input('limit'),

        ]);
    }

    public function update(Request $request, $id)
    {
        //
        $lesson = Lesson::find($id);
        $lesson->update([
            'title' => $request->input('title'),
            'limit' => $request->input('limit'),
        ]);

        return $lesson;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return 
     */
    public function destory($id){
        $lesson = Lesson::find($id);
        $lesson->delete();
    }

    public function achievement_lesson($id,$lesson_id){
        
        return Auth::User()->invites()->where('invite_user_id', '=', $id)->firstOrFail()->user()->find($id)->firstOrFail()->tasks()->where('lesson_id', '=' , $lesson_id)->get();
       //return User::find($id)->tasks()->get();

        
        // return response()->noContent();
    }
}

