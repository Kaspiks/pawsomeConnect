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


    @auth
        <div class="flex items-center justify-center mt-4">
            @auth
                <a href="{{ route('services.create') }}" style="width:11rem" class="bg-gray-800 align-middle select-none font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg bg-gradient-to-tr from-gray-900 to-gray-800 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 active:opacity-[0.85] flex items-center gap-3" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z">
                        </path>
                    </svg>
                    Create Service
                </a>
            @endauth

            <form action="{{ route('services.index') }}" method="GET" class="flex items-center">
                <select name="category_id" class="ml-2 form-select p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option value="">All Categories</option>
                    @foreach ($service_categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="ml-2 px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded">
                    Filter
                </button>
            </form>
        </div>
    @endauth

    <div class="pt-4 px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-4">
        @foreach ($services as $service)
            <div class="bg-white rounded-lg shadow-md p-4">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('services.show', $service->id) }}" class="hover:text-blue-500">{{ $service->name }}</a>
                </h2>
                @if ($service->owners->isNotEmpty())
                    <p class="text-gray-600 text-sm mb-2">
                        Service by
                        <em>
                            @foreach ($service->owners as $owner)
                                <a href="{{ route('profile.show', $owner->id) }}" class="text-gray-600">
                                    <em>{{ $owner->nickname }}</em>
                                </a>
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </em>
                        published on {{ $service->created_at->format('d.m.y') }}
                    </p>
                @endif
                <p class="mb-4">{{ $service->description }}</p>

                @can('update-services', $service)
                    <div class="flex space-x-2">
                        <form method="GET" action="{{ route('services.edit', $service->id) }}">
                            @csrf
                            <button type="submit" class="mr-2 px-4 py-2 bg-gray-800 text-white rounded-full hover:bg-gray-700">Edit</button>
                        </form>
                        <form method="POST" action="{{ route('services.destroy', $service->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-700">Delete</button>
                        </form>
                    </div>
                @endcan
            </div>
        @endforeach
    </div>

</body>
</html>
