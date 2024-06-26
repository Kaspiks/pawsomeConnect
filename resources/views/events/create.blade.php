<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div class="pt-6 container mx-auto px-4 md:px-0 py-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Create Event</h1>
            <p class="text-gray-600">Share your exciting event with the community!</p>
        </div>

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name') }}">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea id="description" name="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                <input type="date" id="start" name="date" value="{{ old('date') }}" min="{{ now()->addDays(2)->format('Y-m-d') }}" max="{{ now()->addMonths(6)->format('Y-m-d') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="max_amount_of_people" class="block text-gray-700 text-sm font-bold mb-2">Max Number of People:</label>
                <input type="number" id="max_amount_of_people" name="max_amount_of_people" value="{{ old('max_amount_of_people') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price:</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Location:</label>
                <input type="text" id="location" name="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('location') }}">
            </div>


            <div class="mb-4">
                <label for="attachments" class="block text-gray-700 text-sm font-bold mb-2">Attachments:</label>
                <input type="file" id="attachments" name="attachments[]" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div id="image-previews" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>

            <div class="mb-4 flex justify-center mt-8">
                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Create Event</button>
            </div>
        </form>
    </div>


    <script>
        const input = document.getElementById('attachments');
        const imagePreviews = document.getElementById('image-previews');

        input.addEventListener('change', () => {
            updatePreviews();
        });

        function updatePreviews() {
            imagePreviews.innerHTML = '';

            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];

                const container = document.createElement('div');
                container.classList.add('relative');

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.classList.add('w-full', 'h-32', 'object-cover', 'rounded-md');
                container.appendChild(img);

                const removeButton = document.createElement('button');
                removeButton.innerHTML = '&times;';
                removeButton.classList.add('absolute', 'top-2', 'right-2', 'bg-red-500', 'text-white', 'rounded-full', 'w-6', 'h-6', 'flex', 'items-center', 'justify-center', 'cursor-pointer');
                removeButton.addEventListener('click', () => {
                    const dt = new DataTransfer();
                    for (let j = 0; j < input.files.length; j++) {
                        if (j !== i) dt.items.add(input.files[j]);
                    }
                    input.files = dt.files;
                    updatePreviews();
                });
                container.appendChild(removeButton);

                imagePreviews.appendChild(container);
            }
        }
    </script>
</body>
</html>
