@extends('layouts.app')

@section('content')

    <div class="card-header">
        <table class="table">
            <td>
                <h2>
                    <a href="{{url('project/'.$task->project_id)}}">{{$name_project.'/'}}</a>
                    {{' '.$task->title.':'}}
                </h2>
            </td>
            <td>
                <form action="{{url('project/del/'.$task->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}

                    <button class="btn btn-danger">
                        <strong>Delete</strong>
                    </button>
                </form>
            </td>
            <td>
                <form action="{{url('project/edit/'.$task->id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}

                    <input type="text" name="title" id="task_title">
                    <button style="color: darkorange">
                        <strong>Change task name</strong>
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

        <p><strong>Task status:</strong> {{$task->status}}</p>

        <form action="{{url('task/status/'.$task->id)}}" method="POST">
            {{csrf_field()}}
            {{method_field('PATCH')}}

            <select type="text" name="status" id="task_status">
                <option value="Done">Done</option>
                <option value="In progress">In progress</option>
                <option value="New">New</option>
            </select>
            <button style="color: darkorange">
                <strong>Change</strong>
            </button>
        </form>

        <br>
        <p><strong>Task description:</strong></p>

        <div class="container">
            <form action="{{url('task/content/'.$task->id)}}" method="POST">
                {{csrf_field()}}
                {{method_field('PATCH')}}

                <textarea name="description" id="task_description">{{$task->content}}</textarea>
                <br>
                <button style="color: darkorange">
                    <strong>Save changes</strong>
                </button>
            </form>
        </div>

        <br>
        <p>
            <strong>
                File:
                @if ($task->file != 'not selected')
                    <a href="{{url('task/download/'.$task->id)}}">{{$task->file}}</a>
                @else
                    not selected
                @endif
            </strong>
        </p>

        <form action="{{url('task/file/'.$task->id)}}" method="post" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input type="file" name="file" id="task_file">
            <button style="color: green">
                <strong>Upload</strong>
            </button>
        </form>
    </div>

@endsection
