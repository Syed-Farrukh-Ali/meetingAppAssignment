<?php

namespace App\Http\Controllers;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

class MeetingController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $meetings = Meeting::where('creator_id', '=', auth()->user()->id)->orderBy('id','desc')->paginate(5);
        return view('meetings.index', compact('meetings'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('meetings.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {         
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'attendee1' => 'required|email|exists:users,email',
            'attendee2' => 'required|email|exists:users,email',
        ]);
        $attendee1 = User::where('email', $validatedData['attendee1'])->firstOrFail();
        $attendee2 = User::where('email', $validatedData['attendee2'])->firstOrFail();

        $startTime = Carbon::parse($request->date.' '.$request->time, 'Asia/Karachi');
        $endTime = Carbon::parse($request->date.' '.$request->time, 'Asia/Karachi')->addHour();
        
        $insert = ['subject' => $request->subject, 'description' => $request->description, 'datetime' => $startTime, 'creator_id' => auth()->user()->id, 'attendee1_id' => $attendee1->id, 'attendee2_id' => $attendee2->id];
        
        $meeting = Meeting::create($insert);
        
        //create a new event
        $event = new Event;

        $event->name = $request->subject;
        $event->description = $request->description;
        $event->startDateTime = $startTime;
        $event->endDateTime = $endTime;

        // $event->addAttendee([
        //     'email' => $request->attendee1
        // ]);
        // $event->addAttendee(['email' => $request->attendee2]);

        $newEvent = $event->save();
        $meeting->calendar_event_id = $newEvent->id;

        $meeting->save();
        return redirect()->route('meetings.index')->with('success','Meeting has been created successfully.');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Meeting  $Meeting
    * @return \Illuminate\Http\Response
    */
    public function show(Meeting $meeting)
    {
        return view('meetings.show',compact('meeting'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Meeting  $meeting
    * @return \Illuminate\Http\Response
    */
    public function edit(Meeting $meeting)
    {
        return view('meetings.edit',compact('meeting'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Meeting  $meeting
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Meeting $meeting)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'datetime' => 'required|date',
            'attendee1' => 'required|email|exists:users,email',
            'attendee2' => 'required|email|exists:users,email',
        ]);
        
        $startTime = Carbon::parse($request->datetime, 'Asia/Karachi');
        $endTime = Carbon::parse($request->datetime, 'Asia/Karachi')->addHour();

        $updateEvent = Event::find($meeting->calendar_event_id);
        $update = ['name' => $request->subject, 'description' => $request->description, 'startDateTime' => $startTime, 'endDateTime' => $endTime];
        $updateEvent->update($update);
        
        $meeting->fill($request->post())->save();

        return redirect()->route('meetings.index')->with('success','Meeting Has Been updated successfully');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Meeting  $meeting
    * @return \Illuminate\Http\Response
    */
    public function destroy(Meeting $meeting)
    {
        $event = Event::find($meeting->calendar_event_id);
        if($meeting->delete()) {
            if($event->delete()) {
                return redirect()->route('meetings.index')->with('success','Meeting has been deleted successfully');  
            } else {
                return redirect()->route('meetings.index')->with('error','Meeting has not been deleted successfully');
            }
        } else {
            return redirect()->route('meetings.index')->with('error','Meeting has not been deleted successfully');
        }
    }

}