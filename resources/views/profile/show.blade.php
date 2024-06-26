<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Detail</title>
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

    <main class="container mx-auto mt-8 flex flex-col min-h-screen">
        <section class="user-detail">
            <h2 style="font-size:2.25rem;line-height: 2.5rem;" class="font-bold mb-6">My Profile</h2>

            <div class="bg-white shadow-md rounded-lg p-8 mb-12">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">User Information</h3>
                <dl class="grid grid-cols-2 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <dt class="text-base font-medium text-gray-600">Username</dt>
                        <dd class="mt-1 text-lg text-gray-900" id="username">{{ $user->nickname }}</dd>
                    </div>
                    <div>
                        <dt class="text-base font-medium text-gray-600">Email</dt>
                        <dd class="mt-1 text-lg text-gray-900" id="email">{{ $user->email }}</dd>
                    </div>
                </dl>
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-4">My Pets</h3>
            <div class="pet-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="user-pets">
                @foreach($pets as $pet)
                    <div class="pet-card bg-white rounded-lg shadow-md overflow-hidden">
                        <a href="{{ route('pets.show', $pet->id) }}">
                            @if ($pet->attachments->first())
                                <img src="{{ asset('storage/' . $pet->attachments->first()->data) }}" alt="Pet image" style="height: 12rem;" class="w-full object-cover"> 
                            @endif
                            <div class="p-4">
                                <h4 class="text-lg font-medium">{{ $pet->name }}</h4>
                                <p class="text-gray-600"><strong>Breed:</strong> {{ $pet->breed }}</p>
                                <p>{{ Str::limit($pet->description, 50) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-12">My Posts</h3>
            <div class="post-grid grid grid-cols-1 md:grid-cols-2 gap-8" id="user-posts">
                @if ($posts)
                    @foreach($posts as $post)
                        <div class="post-card bg-white rounded-lg shadow-md overflow-hidden">
                            <a href="{{ route('posts.show', $post->id) }}">
                                <div class="p-4">
                                    <h4 class="text-lg font-medium">{{ $post->title }}</h4>
                                    <p class="text-gray-600">{{ $post->created_at->format('M d, Y') }}</p>
                                    <p>{{ Str::limit($post->body, 100) }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <p>No posts found.</p>
                @endif
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-12">My Events</h3>
            <div class="post-grid grid grid-cols-1 md:grid-cols-2 gap-8" id="user-events">
                @if ($events)
                    @foreach($events as $event)
                        <div class="post-card bg-white rounded-lg shadow-md overflow-hidden {{ $event != $events->first() ? 'mt-4' : '' }} {{ $event == $events->last() ? 'mb-4' : ''}}">
                            <a href="{{ route('events.show', $event->id) }}">
                                <div class="p-4">
                                    <h4 class="text-lg font-medium">{{ $event->name }}</h4>
                                    <p class="text-gray-600">{{ $event->date }}</p>
                                    <p>{{ Str::limit($event->description, 100) }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <p>No events found.</p>
                @endif
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-12">My Services</h3>
            <div class="post-grid grid grid-cols-1 md:grid-cols-2 gap-8" id="user-services">
                @if ($services)
                    @foreach($services as $service)
                        <div class="post-card bg-white rounded-lg shadow-md overflow-hidden {{ $service != $services->first() ? 'mt-4' : '' }} {{ $service == $services->last() ? 'mb-12' : ''}}">
                            <a href="{{ route('services.show', $service->id) }}">
                                <div class="p-4">
                                    <h4 class="text-lg font-medium">{{ $service->name }}</h4>
                                    <p class="text-gray-600">{{ $service->price }}</p>
                                    <p>{{ Str::limit($service->description, 100) }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <p>No services found.</p>
                @endif
            </div>
        </section>
    </main>

    <footer class="bg-gray-100 py-8 mt-auto">
        <div class="container mx-auto text-center">
            <p class="text-gray-600">Disclaimer: The information provided on this website is for informational purposes only.</p>
            <span class="text-gray-600 mt-2 block">Copyright © {{ date('Y') }} All Rights Reserved.</span>
        </div>
    </footer>
</body>
</html>
