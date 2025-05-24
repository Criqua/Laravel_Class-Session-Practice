<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i class="fas fa-city text-2xl text-indigo-600 dark:text-indigo-400"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100">
                {{ __('Create City') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen py-12 bg-gray-50 dark:bg-gray-900 transition-colors">
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-lg p-8 space-y-6" style="border-radius: 1rem;">
            <form action="{{ route('cities.store') }}" method="POST" class="space-y-6" novalidate>
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        {{ __('City Name') }}
                    </label>
                    <input
                        type="text" name="name" id="name" required
                        placeholder="Ejemplo: Managua"
                        class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    />
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        {{ __('Description') }}
                    </label>
                    <textarea
                        name="description" id="description" rows="4"
                        placeholder="Describe la ciudad..."
                        class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none"
                    ></textarea>
                </div>

                <div>
                    <button
                        type="submit"
                        class="w-full inline-flex justify-center items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-md
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-all"
                    >
                        <i class="fas fa-plus"></i>
                        {{ __('Create City') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@if($errors->any())
  @push('scripts')
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Corrige los errores',
      html: '{!! implode("<br>", $errors->all()) !!}',
      confirmButtonText: 'Entendido'
    });
  </script>
  @endpush
@endif
</x-app-layout>
