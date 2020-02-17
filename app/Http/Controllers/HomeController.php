<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function admin()
    {
        $projects_all = App\Project::all();
        $id = Auth::user()->id;
        $projects = [];

        foreach ($projects_all as $project){
            if ($project->user_id == $id){
                $projects[] = $project;
            }
        }

        return view('home', compact('projects'));
    }

    public function index()
    {
            $projects_all = App\Project::all();
            $id = Auth::user()->id;
            $projects = [];

            foreach ($projects_all as $project){
                if ($project->user_id == $id){
                    $projects[] = $project;
                }
            }

            return view('home', compact('projects'));
    }

    function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $project = new \App\Project;
        $project->name = $request->name;
        $project->user_id = Auth::user()->id;
        $project->save();

        return redirect('/home');
    }

    function delete(\App\Project $project) {

        if($project->user_id == Auth::user()->id){
            $tasks = \App\Task::all();

            foreach ($tasks as $task){
                if ($task->project_id == $project->id){
                    $destinationPath = storage_path().'/file/'.$task->id;
                    File::deleteDirectory($destinationPath);

                    $task->delete();
                }
            }

            $project->delete();
        }

        return redirect('/home');
    }

    function edit(\App\Project $project, Request $request) {

        if($project->user_id == Auth::user()->id){
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255'
            ]);

            if ($validator->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validator);
            }

            $project->name = $request->name;
            $project->save();
        }

        return redirect('/project/'.$project->id);
    }

}
