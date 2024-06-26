<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pawsome connect</title>
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

    <div class="container mx-auto px-4 md:px-8 py-4">
        @auth
            <div class="flex justify-center mb-4">
                <a href="{{ route('events.create') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20z"/></svg>
                    Create Event
                </a>
            </div>
        @endauth

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 md:gap-12">
            @foreach ($events as $event)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if ($event->attachments->isNotEmpty())
                        <div class="relative" style="height:24rem">
                            <img src="{{ asset('storage/' . $event->attachments->first()->data) }}" alt="{{ $event->title }}" class="object-cover w-full h-full">
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-300"></div>
                    @endif
                    <div class="p-6">
                        <a href="{{ route('events.show', $event->id) }}" class="block">
                            <h1 class="text-xl font-medium md:text-4xl font-extrabold mb-2 hover:underline text-blue-600 tracking-tight">{{ $event->name }}</h1>
                        </a>

                        @if ($event->hosts->isNotEmpty())
                            <p class="text-gray-600 text-sm mb-2">
                                Service by
                                <em>
                                    @foreach ($event->hosts as $host)
                                        {{ $host->nickname }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </em>
                                published on {{ $event->created_at->format('d.m.y') }}
                            </p>
                        @endif

                        <p class="text-gray-700 mb-2">{{ $event->description }}</p>
                        <p class="text-sm text-gray-500 mb-1">Date: {{ $event->date }}</p>
                        <p class="text-sm text-gray-500 mb-1">Price: {{ $event->price }}</p>
                        <p class="text-sm text-gray-500">Participants: {{ count($event->participants) }} out of {{ $event->max_amount_of_people }}</p>

                        @can('update-event', $event)
                            <div class="mt-4 flex space-x-2">
                                <form method="POST" action="{{ route('events.destroy', $event->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </form>

                                <form method="GET" action="{{ route('events.edit', $event->id) }}">
                                    @csrf
                                    <button type="submit" class="bg-gray-800 hover:bg-blue-700 ml-4 text-white font-bold py-2 px-4 rounded">Update</button>
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
