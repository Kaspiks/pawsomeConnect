<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\EventsAttachment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('attachments')->orderBy('created_at', 'desc')->get();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            abort(403);
        }

        $users = User::all();

        return view('events.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:'. Carbon::now()->addDays(2)->toDateString(),
            'max_amount_of_people' => 'required|numeric|between:1,100',
            'price' => 'required|numeric|between:0,500',
            'location' => 'required|string'
        ]);

        $event = Event::create([
            'name' => $validate['name'],
            'description' => $validate['description'],
            'date' => $validate['date'],
            'max_amount_of_people' => $validate['max_amount_of_people'],
            'price' => $validate['price'],
            'location' => $validate['location'],
            'user_id' => $user->id
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('photos', 'public');
                $attachment = new EventsAttachment();
                $attachment->data = $path;
                $attachment->event_id = $event->id;
                $attachment->save();
            }
        }

        $event->users()->attach($user->id, ['user_type' => 'host']);

        return redirect()->route('events.show', $event->id)->with('success', 'Event has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $individual = Auth::user();
        $event = Event::find($id);
        $users = $event->users();
        return view('events.show', compact('event', 'individual', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $event = Event::with('attachments')->find($id);
        $users = $event->users();

        return view('events.edit', compact('event', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::find($id);
        $users = User::all();

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:'. Carbon::now()->addDays(2)->toDateString(),
            'max_amount_of_people' => 'required|numeric|between:1,100',
            'price' => 'required|numeric|between:0,500',
            'location' => 'required|string'
        ]);


        //all clear - updating the post!
        $event->name = $validate['name'];
        $event->description = $validate['description'];
        $event->date = $validate['date'];
        $event->max_amount_of_people = $validate['max_amount_of_people'];
        $event->price = $validate['price'];
        $event->location = $validate['location'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('photos', 'public');
                EventsAttachment::create([
                    'data' => $path,
                    'event_id' => $event->id,
                ]);
            }
        }

        $event->save();
        return redirect()->route('events.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Event::findOrfail($id)->delete();
        return redirect()->route('events.index');
    }

    public function apply(Event $event)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to apply for a service.');
        }

        $user = Auth::user();

        if ($event->hosts->contains($user) || $event->participants->contains($user)) {
            return redirect()->back()->with('error', 'You cannot apply for this event.');
        }


        // 2. Attach the User as a Customer to the Service
        $event->users()->attach($user->id, ['user_type' => 'participant']);

        return redirect()->back()->with('success', 'Your application has been submitted.');
    }

    public function deleteAttachment(Event $event, EventsAttachment $attachment)
    {
        if ($attachment->event_id == $event->id) {
            Storage::disk('public')->delete($attachment->data);
            $attachment->delete();

            return response()->json(['message' => 'Attachment deleted successfully']);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }
}
