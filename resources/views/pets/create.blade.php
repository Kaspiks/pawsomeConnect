<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawsome Connect - Create Pet</title>
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
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Create Pet Profile</h1>
            <p class="text-gray-600">Introduce your furry friend to the community!</p>
        </div>

        <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="breed" class="block text-gray-700 text-sm font-bold mb-2">Breed:</label>
                    <input type="text" id="breed" name="breed" value="{{ old('breed') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="pet_type_id" class="block text-gray-700 text-sm font-bold mb-2">Animal Type:</label>
                    <select id="pet_type_id" name="pet_type_id"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach ($pet_types as $type)
                            <option value="{{ $type->id }}" {{ old('pet_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age:</label>
                    <input type="number" id="age" name="age" value="{{ old('age') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea id="description" name="description" rows="5"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="attachments" class="block text-gray-700 text-sm font-bold mb-2">Photos:</label>
                <input type="file" id="attachments" name="attachments[]" multiple
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div id="image-previews" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>

            <div class="mb-4 flex justify-center mt-8">
                <button type="submit"
                    class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Create Pet Profile</button>
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
