{{-- resources/views/citizens/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i class="fas fa-user-edit text-2xl text-indigo-600 dark:text-indigo-400"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100">
                {{ __('Editar Ciudadano') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen py-12 bg-gray-50 dark:bg-gray-900 transition-colors">
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-lg rounded-2xl p-8 space-y-6" style="border-radius: 1rem;">
            <form action="{{ route('citizens.update', $citizen->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        {{ __('Nombres') }}
                    </label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $citizen->first_name) }}" placeholder="Ejemplo: Juan" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"/>
                    @error('first_name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        {{ __('Apellidos') }}
                    </label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $citizen->last_name) }}"  placeholder="Ejemplo: Pérez" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    />
                    @error('last_name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        {{ __('Fecha de Nacimiento') }}
                    </label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $citizen->birth_date) }}" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition filter [&::-webkit-calendar-picker-indicator]:invert"
                    />
                    @error('birth_date')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        {{ __('Ciudad') }}
                    </label>
                    <select name="city_id" id="city_id" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">{{ __('Seleccionar una ciudad') }}</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id', $citizen->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        {{ __('Dirección') }}
                    </label>
                    <input type="text" name="address" id="address" value="{{ old('address', $citizen->address) }}"placeholder="Ejemplo: Calle 123"
                        class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    />
                    @error('address')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        {{ __('Teléfono') }}
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $citizen->phone) }}" placeholder="Ejemplo: +505 1234-5678" class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    />
                    @error('phone')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-all">
                        <i class="fa-solid fa-rotate"></i>
                        {{ __('Actualizar Ciudadano') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
