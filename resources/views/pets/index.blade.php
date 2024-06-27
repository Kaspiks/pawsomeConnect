<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pawsome Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    @php
      $menuItems = app(\App\Http\Controllers\NavigationController::class)->getMenuItems();
    @endphp

    <div>
      @include('layouts.nav', ['menuItems' => $menuItems])
    </div>

    <div class="container mx-auto mt-8 mb-12">
        <div class="flex justify-between items-center mb-4">
            @auth
                <a href="{{ route('pets.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Pet
                </a>
            @endauth
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($pets as $pet)
                <div class="bg-white shadow-md rounded-lg overflow-hidden {{ $loop->iteration % 2 == 0 ? 'md:-mt-8' : 'md:mt-8' }}">
                    @if ($pet->attachments->isNotEmpty())
                        <img src="{{ asset('storage/' . $pet->attachments->first()->data) }}" alt="Pet Banner" class="w-full h-48 object-cover">
                    @endif

                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">
                            <a href="{{ route('pets.show', $pet->id) }}" class="text-blue-500 hover:text-blue-700">{{ $pet->name }}</a>
                        </h2>

                        <p>
                            @if(isset($pet_types[$pet->pet_type_id]))
                                <span class="font-bold">Animal:</span> {{ $pet_types[$pet->pet_type_id]->name }}<br>
                            @endif
                            <span class="font-bold">Breed:</span> {{ $pet->breed }}
                            <br>
                            <span class="font-bold">Age:</span> {{ $pet->age }}
                        </p>
                        <p class="mt-2"><span class="font-bold">Description:</span> {{ $pet->description }}</p>

                        @can('update-pet', $pet)
                            <div class="mt-4 flex space-x-2">
                                <form method="POST" action="{{ route('pets.destroy', $pet->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">
                                        Delete
                                    </button>
                                </form>

                                <form method="GET" action="{{ route('pets.edit', $pet->id) }}">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                                        Update
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
