<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Cities') }}
        </h2>
    </x-slot>

    <div>
        <div>
            <h3>{{ $city->name }}</h3>
            <p>{{ $city->description }}</p>
        </div>
        <div>
            <a href="#">Back to list</a>
        </div>
    </div>
</x-app-layout>

