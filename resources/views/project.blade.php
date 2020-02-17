@extends('layouts.app')

@section('content')

    <div class="card-header">
        <table class="table">
            <td>
                <div><h2>{{$project->name.':'}}</h2></div>
            </td>
            <td>
                <form action="{{url('home/del/'.$project->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}

                    <button class="btn btn-danger">
                        <strong>Delete</strong>
                    </button>
                </form>
            </td>
            <td>
                <form action="{{url('home/edit/'.$project->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}

                    <input type="text" name="name" id="project_name">
                    <button style="color: darkorange">
                        <strong>Change project name</strong>
                    </button>
                </form>
            </td>
        </table>
    </div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{url('project/'.$project->id)}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}

            <div>
                <td>
                    <input type="text" name="title" id="task_title">
                </td>
                <td>
                    <button type="submit" style="color: green">
                        <strong>Create new Task</strong>
                    </button>
                </td>
                <td>
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <input type="file" name="file" id="task_file">
                </td>
            </div>
        </form>

        @if (!empty($tasks))
            <br>
            <p><strong>Your tasks:</strong></p>
        @endif

        <ol>
            @foreach($tasks as $task)
                <div class="m-2">
                    <li>
                        <form action="{{url('project/del/'.$task->id)}}" method="post">
                            <a href="{{url('task/'.$task->id)}}">
                                <strong>{{$task->title}}</strong>
                            </a>
                            {{' ('.$task->status.')'}}

                            {{csrf_field()}}
                            {{method_field('DELETE')}}

                            <button style="color: red">Delete</button>
                        </form>
                    </li>
                </div>
            @endforeach
        </ol>
    </div>

@endsection('content')
