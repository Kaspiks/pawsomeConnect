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

    <div class="container mx-auto mt-8 p-4 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Edit Service</h1>

        <form action="{{ route('services.update', $service->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-gray-700">Service name:</label>
                <input type="text" id="name" name="name" class="w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300" value="{{ $service->name }}">
            </div>

            <div>
                <label for="description" class="block text-gray-700">Body:</label>
                <textarea id="description" name="description" rows="10" class="w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">{{ $service->description }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="service_category" class="block text-gray-700">Category:</label>
                    <select id="service_category" name="service_category_id" class="w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                        @foreach ($service_categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $service->service_category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="price" class="block text-gray-700">Price:</label>
                    <input type="number" id="price" name="price" class="w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300" value="{{ $service->price }}" required>
                </div>
           </div>


           <div class="flex justify-center"> <div>
                <button type="submit" class="mt-4 bg-gray-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
</body>
</html>
