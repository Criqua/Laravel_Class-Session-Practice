<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-users text-2xl text-indigo-600 dark:text-indigo-400"></i>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100">
                    {{ __('Ciudadanos') }}
                </h2>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('citizens.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition">
                    <i class="fas fa-plus"></i>
                    {{ __('Crear Ciudadano') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg dark:shadow-gray-800 rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Nombre Completo') }}
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Edad') }}
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Ciudad') }}
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Dirección') }}
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Teléfono') }}
                            </th>
                            <th class="px-4 py-2 text-center text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Acciones') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-600">
                        @forelse($citizens as $citizen)
                            <tr class="odd:bg-gray-50 even:bg-white dark:odd:bg-gray-700 dark:even:bg-gray-800 transition">
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                    {{ $citizen->getFullName() }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                    {{ $citizen->getAge() }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                    {{ $citizen->getCity() }}
                                </td>
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                                    {{ $citizen->address }}
                                </td>
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                                    {{ $citizen->phone ?? '—' }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('citizens.edit', $citizen->id) }}" class="inline-flex items-center gap-1 px-4 py-1.5 bg-yellow-400 hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-600 text-gray-900 dark:text-gray-800 font-semibold rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 transition">
                                            <i class="fas fa-edit"></i>
                                            {{ __('Editar') }}
                                        </a>
                                        <form action="{{ route('citizens.destroy', $citizen->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete-citizen inline-flex items-center gap-1 px-4 py-1.5 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white dark:text-gray-100 font-semibold rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-red-300 dark:focus:ring-red-600 transition">
                                                <i class="fas fa-trash-alt"></i>
                                                {{ __('Eliminar') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    {{ __('No hay ciudadanos registrados.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>