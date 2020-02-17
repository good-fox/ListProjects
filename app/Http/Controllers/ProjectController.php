<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
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

    public function index($project_id){
        $project = App\Project::find($project_id);

        if($project->user_id == Auth::user()->id){
            $id = $project->id;
            $tasks_all = App\Task::all();
            $tasks = [];

            foreach ($tasks_all as $task){
                if ($task->project_id == $id){
                    $tasks[] = $task;
                }
            }

            return view('project', compact('tasks', 'project'));
        } else {
            return view('welcome');
        }
    }

    function add($project_id, Request $request) {
        $project = App\Project::find($project_id);

        if($project->user_id == Auth::user()->id){
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255'
            ]);

            if ($validator->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validator);
            }

            $task = new \App\Task();
            $task->title = $request->title;
            $task->content = '...';
            $task->status = 'new';
            $task->file = 'not selected';
            $task->project_id = $project_id;
            $task->save();

            if (!empty($request->file())){
                foreach ($request->file() as $file) {
                    $file->move(storage_path('file').'/'.$task->id, $file->getClientOriginalName());
                    $task->file = $file->getClientOriginalName();

                    $task->save();
                }
            }
        }

        return redirect('/project/'.$project_id);
    }

    function delete(\App\Task $task) {
        $project = App\Project::find($task->project_id);
        $id = '';

        if($project->user_id == Auth::user()->id){
            $id = $task->project_id;

            $destinationPath = storage_path().'/file/'.$task->id;
            File::deleteDirectory($destinationPath);

            $task->delete();
        }

        return redirect('/project/'.$id);
    }

    function edit(\App\Task $task, Request $request) {
        $project = App\Project::find($task->project_id);
        $id = '';

        if($project->user_id == Auth::user()->id){
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255'
            ]);

            if ($validator->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validator);
            }

            $task->title = $request->title;
            $task->save();

            $id = $task->id;
        }

        return redirect('/task/'.$id);
    }

}
