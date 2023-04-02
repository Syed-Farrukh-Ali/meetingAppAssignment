@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-left">
                                    <h2>Edit Meetings</h2>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-primary" href="{{ route('meetings.index') }}" enctype="multipart/form-data">
                                        Back</a>
                                </div>
                            </div>
                        </div>
                        @if(session('status'))
                        <div class="alert alert-success mb-1 mt-1">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form action="{{ route('meetings.update',$meeting->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Meeting Subject:</strong>
                                        <input type="text" name="subject" value="{{ $meeting->subject }}" class="form-control"
                                            placeholder="Meeting Subject">
                                        @error('subject')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Meeting Description:</strong>
                                        <input type="text" name="description" class="form-control" placeholder="Meeting Description"
                                            value="{{ $meeting->description }}">
                                        @error('description')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Meeting Date:</strong>
                                        <input type="datetime-local" name="datetime" value="{{ $meeting->datetime }}" class="form-control"
                                            placeholder="Meeting Date">
                                        @error('datetime')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Attendee1 Email:</strong>
                                        <input type="email" name="attendee1" value="{{ $meeting->attendee1->email }}" class="form-control"
                                            placeholder="Attendee1 Email">
                                        @error('attendee1')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Attendee2 Email:</strong>
                                        <input type="email" name="attendee2" value="{{ $meeting->attendee2->email }}" class="form-control"
                                            placeholder="Attendee2 Email">
                                        @error('attendee2')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary ml-3">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection