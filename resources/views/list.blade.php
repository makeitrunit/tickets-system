@extends('layout')

@section('title', 'Página Principal')
@section('content')
    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Eventos</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://placehold.co/600x400"
                         alt="Evento {{ $event->name  }}"
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $event->name }}</h2>
                        <p class="text-gray-600 mb-4">{{ $event->description }}</p>
                        <div class="flex justify-between items-center">
                            @if($event->available_qty > 0)
                                <a href="{{ url("/events/{$event->id}") }}">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Ver evento
                                    </button>
                                </a>
                            @else
                                <span class="inline-flex items-center rounded-md bg-indigo-50 px-5 py-4 text-xs font-medium text-pink-700 ring-1 ring-inset ring-pink-700/10">Agotado</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </main>
@endsection
