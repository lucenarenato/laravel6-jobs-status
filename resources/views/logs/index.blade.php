@extends('layouts.app')
@section('content')
    <div class="container">
        @include('flash::message')
        <div class="row justify-content-center">
            @include('_menu')
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Logs</div>
                    <div class="card-body">
                        <table class="table table-hover table-striped table-sm">
                            <thead>
                            <tr>
                                <th scope="col">Job</th>
                                <th scope="col">Records</th>
                                <th scope="col">Last update</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>{{$log->loggable_type}}:{{$log->loggable_id}}</td>
                                    <td>{{$log->total}}</td>
                                    <td>{{$log->created_at}}</td>
                                    <td ><a class="btn btn-sm btn-primary" href="{{route('logs.show', ['log'=>$log]) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="table-info"> No records</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                    <div class="card-footer">
                        {{$logs->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection