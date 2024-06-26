<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pet;
use App\Models\PetType;
use App\Models\PetsAttachment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pet_types = PetType::all()->keyBy('id');
        $pets = Pet::with('attachments')->orderBy('created_at', 'desc')->get();

        return view('pets.index', compact('pets', 'pet_types'));
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
        $pet_types = PetType::all();

        return view('pets.create', compact('users', 'pet_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $pet_types = PetType::all();

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string',
            'pet_type_id' => 'required|integer|exists:pet_types,id',
            'age' => 'required|numeric|between:1,20',
            'description' => 'required|string'
        ]);

        $pet = Pet::create([
            'name' => $validate['name'],
            'breed' => $validate['breed'],
            'pet_type_id' => $validate['pet_type_id'],
            'age' => $validate['age'],
            'description' => $validate['description'],
            'user_id' => $user->id
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('photos', 'public');
                $pet->attachments()->create(['data' => $path]); 
            }
        }

        $pet->users()->attach($user->id);

        return redirect()->route('pets.show', $pet->id)->with('success', 'Pet has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $individual = Auth::user();
        $pet = Pet::find($id);
        $users = $pet->users();
        return view('pets.show', compact('pet', 'individual', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $pet = Pet::with('attachments')->find($id);
        $users = $pet->users();
        $pet_types = PetType::all();

        return view('pets.edit', compact('pet', 'users', 'pet_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pet = Pet::find($id);
        $users = User::all();

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string',
            'pet_type_id' => 'required|integer|exists:pet_types,id',
            'age' => 'required|numeric|between:1,20',
            'description' => 'required|string'
        ]);


        //all clear - updating the post!
        $pet->name = $validate['name'];
        $pet->breed = $validate['breed'];
        $pet->pet_type_id = $validate['pet_type_id'];
        $pet->age = $validate['age'];
        $pet->description = $validate['description'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('photos', 'public');
                PetsAttachment::create([
                    'data' => $path,
                    'pet_id' => $pet->id,
                ]);
            }
        }

        $pet->save();
        return redirect()->route('pets.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pet::findOrfail($id)->delete();
        return redirect()->route('pets.index');
    }

    public function deleteAttachment(Pet $pet, PetsAttachment $attachment)
    {
        if ($attachment->pet_id == $pet->id) {
            Storage::disk('public')->delete($attachment->data);
            $attachment->delete();

            return response()->json(['message' => 'Attachment deleted successfully']);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }
}
