<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawsome Connect - Edit Pet</title>
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

    <div class="container mx-auto mt-8 p-4">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Edit Pet Profile</h1>
        <p class="text-gray-600">Update your furry friend's information.</p>

        <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $pet->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="breed" class="block text-gray-700 text-sm font-bold mb-2">Breed:</label>
                    <input type="text" id="breed" name="breed" value="{{ old('breed', $pet->breed) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="pet_type_id" class="block text-gray-700 text-sm font-bold mb-2">Animal Type:</label>
                    <select id="pet_type_id" name="pet_type_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach ($pet_types as $type)
                            <option value="{{ $type->id }}" {{ old('pet_type_id', $pet->pet_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age:</label>
                    <input type="number" id="age" name="age" value="{{ old('age', $pet->age) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>
            <div>
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea id="description" name="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $pet->description) }}</textarea>
            </div>
            <div>
                <label for="attachments" class="block text-gray-700 text-sm font-bold mb-2">Photos:</label>
                <input type="file" id="attachments" name="attachments[]" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div id="image-previews" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>


            <div class="flex justify-center">
                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Update Pet Profile</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        const input = document.getElementById('attachments');
        const imagePreviews = document.getElementById('image-previews');
        const existingAttachments = @json($pet->attachments);
        const assetBaseUrl = "{{ asset('storage') }}/";

        existingAttachments.forEach(attachment => {
            createPreview(attachment.data, attachment.id);
        });

        input.addEventListener('change', () => {
            updatePreviews();
        });

        function updatePreviews() {
            imagePreviews.innerHTML = '';

            existingAttachments.forEach(attachment => {
                createPreview(attachment.data, attachment.id);
            });

            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                createPreview(URL.createObjectURL(file), file);
            }
        }

        function createPreview(src, fileOrId = null) {
            const container = document.createElement('div');
            container.classList.add('relative');
            const img = document.createElement('img');
            img.src = (fileOrId instanceof File) ? src : assetBaseUrl + src;
            img.classList.add('w-full', 'h-32', 'object-cover', 'rounded-md');

            const removeButton = document.createElement('button');
            removeButton.innerHTML = '&times;';
            removeButton.classList.add('absolute', 'top-2', 'right-2', 'bg-red-500', 'text-white', 'rounded-full', 'w-6', 'h-6', 'flex', 'items-center', 'justify-center', 'cursor-pointer');
            removeButton.addEventListener('click', () => removeAttachment(fileOrId, container));

            container.appendChild(img);
            container.appendChild(removeButton);

            imagePreviews.appendChild(container);
        }

        function removeAttachment(fileOrId, container) {
            container.remove();

            if (typeof fileOrId === 'number') {
                axios.delete('/pets/' + {{ $pet->id }} + '/attachments/' + fileOrId)
                    .then(response => {
                        console.log(response.data.message);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                const dt = new DataTransfer();
                for (let i = 0; i < input.files.length; i++) {
                    if (input.files[i] !== fileOrId) {
                        dt.items.add(input.files[i]);
                    }
                }
                input.files = dt.files;
            }
        }
    </script>
</body>
</html>
