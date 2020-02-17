<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index($task_id)
    {
        $task = App\Task::find($task_id);
        $project = App\Project::find($task->project_id);
        $name_project = $project->name;

        if($project->user_id == Auth::user()->id){
            return view('task', compact('task','name_project'));
        } else {
            return view('welcome');
        }
    }

    public function status(\App\Task $task, Request $request) {
        $project = App\Project::find($task->project_id);

        if($project->user_id == Auth::user()->id){
            $validator = Validator::make($request->all(), [
                'status' => 'required|max:255'
            ]);

            if ($validator->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validator);
            }

            $task->status = $request->status;
            $task->save();
        }

        return redirect('/task/'.$task->id);
    }

    public function content(\App\Task $task, Request $request) {
        $project = App\Project::find($task->project_id);

        if($project->user_id == Auth::user()->id){
            $validator = Validator::make($request->all(), [
                'description' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validator);
            }

            $task->content = $request->description;
            $task->save();
        }

        return redirect('/task/'.$task->id);
    }

    public function file(\App\Task $task, Request $request)
    {
        $project = App\Project::find($task->project_id);

        if($project->user_id == Auth::user()->id){
            $destinationPath = storage_path().'/file/'.$task->id;
            File::deleteDirectory($destinationPath);

            foreach ($request->file() as $file) {
                $file->move(storage_path('file').'/'.$task->id, $file->getClientOriginalName());

                $task->file = $file->getClientOriginalName();
                $task->save();
            }
        }

        return redirect('/task/' . $task->id);
    }

    public function download(\App\Task $task){
        $project = App\Project::find($task->project_id);

        if($project->user_id == Auth::user()->id){
            $pathToFile=storage_path().'/file/'.$task->id.'/'.$task->file;
        } else {
            return view('home');
        }

        return response()->download($pathToFile);
    }

}
