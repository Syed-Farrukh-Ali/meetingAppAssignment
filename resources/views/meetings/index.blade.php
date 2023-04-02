@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-left">
                                    <h2>Meeting Schedual</h2>
                                </div>
                                <div class="pull-right mb-2">
                                    <a class="btn btn-success" href="{{ route('meetings.create') }}"> Create Meeting</a>
                                </div>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Date Time</th>
                                    <th>Attendee1</th>
                                    <th>Attendee2</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($meetings as $meeting)
                                    <tr>
                                        <td>{{ $meeting->subject }}</td>
                                        <td>{{ $meeting->description }}</td>
                                        <td>{{ $meeting->datetime }}</td>
                                        <td>{{ $meeting->attendee1->email }}</td>
                                        <td>{{ $meeting->attendee2->email }}</td>
                                        <td>
                                            <form action="{{ route('meetings.destroy',$meeting->id) }}" method="Post">
                                                <a class="btn btn-primary" href="{{ route('meetings.edit',$meeting->id) }}">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        {!! $meetings->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection