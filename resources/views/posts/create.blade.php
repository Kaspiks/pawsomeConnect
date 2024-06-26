<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Post</title>
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

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Create New Post</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                <input type="text" id="title" name="title" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('title') }}">
            </div>

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Body:</label>
                <textarea id="body" name="body" rows="10" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('body') }}</textarea>
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Category:</label>
                <select id="category" name="category_id" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="attachments" class="block text-gray-700 text-sm font-bold mb-2">Attachments:</label>
                <input type="file" id="attachments" name="attachments[]" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div id="image-previews" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>

            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Create</button> 
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
