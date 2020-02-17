@extends('layouts.app')

@section('content')

    <div class="card-header">
        <h2>Project:</h2>
    </div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{url('home/')}}" method="POST">
            {{csrf_field()}}

            <div>
                <td>
                    <input type="text" name="name" id="project_name">
                </td>
                <td>
                    <button type="submit" class="btn btn-success">
                        <strong>Create new Project</strong>
                    </button>
                </td>
            </div>
        </form>

        @if (!empty($projects))
            <br>
            <p><strong>Your projects:</strong></p>
        @endif

        <ol>
            @foreach($projects as $project)
                <div class="m-1">
                    <h5>
                        <a href="{{url('project/'.$project->id)}}">
                            <li><strong>{{$project->name}}</strong></li>
                        </a>
                    </h5>
                </div>
            @endforeach
        </ol>
    </div>

@endsection
