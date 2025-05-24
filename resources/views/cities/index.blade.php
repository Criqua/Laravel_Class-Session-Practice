<x-app-layout>
   <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-city text-2xl text-indigo-600 dark:text-indigo-400"></i>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100">
                    {{ __('Cities') }}
                </h2>
            </div>
            <a href="{{ route('cities.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600
                      text-white font-semibold rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                      dark:focus:ring-offset-gray-900 transition">
                <i class="fas fa-plus"></i>
                {{ __('Create City') }}
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen py-8 bg-gray-50 dark:bg-gray-900 transition-colors">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($cities as $city)
                    <div
                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md
                               hover:shadow-xl transform hover:scale-105 transition p-6 flex flex-col justify-between"
                    >
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                                {{ $city->name }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                {{ $city->description }}
                            </p>
                        </div>

                        <div class="flex space-x-4 justify-end">
                            <a href="{{ route('cities.edit', $city->id) }}"
                               class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200
                                      font-medium transition">
                                <i class="fas fa-edit"></i>
                                {{ __('Edit') }}
                            </a>

                            @if(request('delete') == $city->id)
                                <form action="{{ route('cities.destroy', $city->id) }}" method="POST" class="flex space-x-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-1 bg-red-600 hover:bg-red-700
                                                   text-white rounded-lg font-medium focus:outline-none focus:ring-2
                                                   focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-900 transition">
                                        <i class="fas fa-trash-alt"></i>
                                        {{ __('Confirm Delete') }}
                                    </button>
                                    <a href="{{ route('cities.index') }}"
                                       class="inline-flex items-center gap-1 px-3 py-1 bg-gray-200 hover:bg-gray-300
                                              dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300
                                              rounded-lg font-medium transition">
                                        <i class="fas fa-times"></i>
                                        {{ __('Cancel') }}
                                    </a>
                                </form>
                            @else
                                <a href="{{ route('cities.index', ['delete' => $city->id]) }}"
                                   class="inline-flex items-center gap-1 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200
                                          font-medium transition">
                                    <i class="fas fa-trash-alt"></i>
                                    {{ __('Delete') }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $cities->links() }}
            </div>
        </div>
    </div>
    @if(session('success'))
    @push('scripts')
    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        });

        Toast.fire({
        icon: "success",
        title: "{{ session('success') }}"
        });
    </script>
    @endpush
    @endif
</x-app-layout>
