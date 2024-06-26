<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pawsome connect</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
</head>

<body>
    @php
        $menuItems = app(\App\Http\Controllers\NavigationController::class)->getMenuItems();
    @endphp

    <div>
        @include('layouts.nav', ['menuItems' => $menuItems])
    </div>

    <div class="container mx-auto px-4 md:px-8 py-8 pt-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $event->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $event->description }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-gray-700 font-bold">Date:</p>
                        <p class="text-gray-600">{{ $event->date }}</p>
                    </div>

                    <div>
                        <p class="text-gray-700 font-bold">Price:</p>
                        <p class="text-gray-600">{{ $event->price }}</p>
                    </div>

                    <div>
                        <p class="text-gray-700 font-bold">Location:</p>
                        <p class="text-gray-600">{{ $event->location }}</p>
                    </div>

                    <div>
                        <p class="text-gray-700 font-bold">Participants:</p>
                        <p class="text-gray-600">{{ count($event->participants) }} out of {{ $event->max_amount_of_people }}</p>
                    </div>
                </div>

                <div class="mt-4">
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
                </div>
            </div>

            @if (!$event->hosts->contains(Auth::user()) && !$event->participants->contains(Auth::user()))
                <div class="flex justify-center mt-4 mb-8">
                    <form action="{{ route('events.apply', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Apply for this event
                        </button>
                    </form>
                </div>
            @endif
            {{-- <div class="flex justify-center mt-4 mb-8">
                <form method="POST" action="{{ route('events.apply', $event) }}">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Apply
                    </button>
                </form>
            </div> --}}
        </div>

        @if ($event->attachments->isNotEmpty())
            <div class="mt-8 mb-12 border rounded-lg overflow-hidden">
                <div class="grid grid-cols-2 md:grid-cols-2 gap-4 md:gap-6 px-4 md:px-8 py-4">
                    @foreach ($event->attachments as $attachment)
                        <div class="relative overflow-hidden rounded-lg shadow-md">
                            <a href="{{ asset('storage/' . $attachment->data) }}" data-lightbox="event-gallery">
                                <img class="object-cover w-full h-full" src="{{ asset('storage/' . $attachment->data) }}" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</body>
</html>

