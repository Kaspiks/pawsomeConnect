<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawsome Connect - {{ $pet->name }}</title>
    @vite('resources/css/app.css')
</head>
<body>
    @php
        $menuItems = app(\App\Http\Controllers\NavigationController::class)->getMenuItems();
    @endphp
    <div>
        @include('layouts.nav', ['menuItems' => $menuItems])
    </div>

    <div class="container mx-auto mt-8 p-4">
        <div class="relative overflow-hidden mb-6">
            <div class="flex">
                @foreach($pet->attachments as $attachment)
                    <img src="{{ asset('storage/' . $attachment->data) }}"  alt="{{ $pet->name }} - Photo" style="height:24rem;" class="w-full object-cover border-2 border-gray-200 rounded-md"> 
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $pet->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $pet->description }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-gray-700 font-bold">Animal Type:</p>
                        <p class="text-gray-600">{{ $pet->type->name }}</p>
                    </div>

                    <div>
                        <p class="text-gray-700 font-bold">Breed:</p>
                        <p class="text-gray-600">{{ $pet->breed }}</p>
                    </div>

                    <div>
                        <p class="text-gray-700 font-bold">Age:</p>
                        <p class="text-gray-600">{{ $pet->age }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    @if ($pet->users->isNotEmpty())
                        <p class="text-gray-600 text-sm mb-2">
                            Owned by
                            <em>
                                @foreach ($pet->users as $owner)
                                    {{ $owner->nickname }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </em>
                            published on {{ $owner->created_at->format('d.m.y') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>


        <div class="mt-4 flex space-x-2">
            <a href="{{ route('pets.edit', $pet->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <form action="{{ route('pets.destroy', $pet->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Delete
                </button>
            </form>
        </div>
    </div>
</body>
</html>
