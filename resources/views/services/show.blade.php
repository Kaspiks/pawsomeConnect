<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$service->name}}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @vite('resources/css/app.css')
</head>
<body>
    @php
        $menuItems = app(\App\Http\Controllers\NavigationController::class)->getMenuItems();
    @endphp

    <div>
        @include('layouts.nav', ['menuItems' => $menuItems])
    </div>

    <div class="container-l mx-auto mt-8 p-4 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Show Service</h1>

        <div class="mb-4">
            <h2 class="text-xl font-semibold">{{ $service->name }}</h2>
            <p>{{ $service->description }}</p>

            @if ($service->owners->isNotEmpty())
                <p class="text-gray-600 text-sm mb-2">
                    Service by
                    <em>
                        @foreach ($service->owners as $owner)
                            {{ $owner->nickname }}
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </em>
                    published on {{ $service->created_at->format('d.m.y') }}
                </p>
            @endif

            <p>Category: {{ $service->category->name }}</p>
        </div>

        @if (!$service->owners->contains(Auth::user()) && !$service->customers->contains(Auth::user()))
            <form action="{{ route('service.apply', $service->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Apply for this service
                </button>
            </form>
        @endif
    </div>
</body>
</html>
