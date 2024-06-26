<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $service_categories = ServiceCategory::all()->keyBy('id');


        if ($request->category_id !== null) {
            $services = Service::when($request->has('category_id'), function ($query) use ($request) {
                return $query->where('service_category_id', $request->category_id);
            })->get();
        } else {
            $services = Service::all();
        }


        return view('services.index', compact('services', 'service_categories'));
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
        $service_categories = ServiceCategory::all();

        return view('services.create', compact('users', 'service_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $service_categories = ServiceCategory::all();

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'service_category_id' => 'required|integer|exists:service_categories,id',
            'price' => 'required|numeric|between:50,250'
        ]);

        $service = Service::create([
            'name' => $validate['name'],
            'description' => $validate['description'],
            'service_category_id' => $validate['service_category_id'],
            'price' => $validate['price'],
            'user_id' => $user->id
        ]);

        $service->users()->attach($user->id, ['user_type' => 'owner']);

        return redirect()->route('services.show', $service->id)->with('success', 'Service has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $individual = Auth::user();
        $service = Service::find($id);
        $users = $service->users();
        return view('services.show', compact('service', 'individual', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $service = Service::find($id);
        $users = $service->users();
        $service_categories = ServiceCategory::all();

        return view('services.edit', compact('service', 'users', 'service_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::find($id);
        $users = User::all();

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'service_category_id' => 'required|integer|exists:service_categories,id',
            'price' => 'required|numeric|between:50,250'
        ]);


        $service->name = $validate['name'];
        $service->description = $validate['description'];
        $service->service_category_id = $validate['service_category_id'];
        $service->price = $validate['price'];

        $service->save();
        return redirect()->route('services.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Service::findOrfail($id)->delete();
        return redirect()->route('services.index');
    }

    public function apply(Service $service)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to apply for a service.');
        }

        $user = Auth::user();

        if ($service->owners->contains($user) || $service->customers->contains($user)) {
            return redirect()->back()->with('error', 'You cannot apply for this service.');
        }


        $service->users()->attach($user->id, ['user_type' => 'customer']);

        return redirect()->back()->with('success', 'Your application has been submitted.');
    }
}
