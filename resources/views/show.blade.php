@extends('layout')

@section('title', 'Página Principal')
@section('content')

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="https://placehold.co/600x400" alt="Imagen del Evento" class="w-full h-80 object-cover">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-4">{{ $event->name }}</h2>
                <p class="text-gray-600 mb-4">{{ $event->description }}</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{url("/events/{$event->id}/purchase")}}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="">
                        <label for="qty" class="block mb-2 text-sm font-medium text-gray-900">Cantidad de
                            Tickets</label>
                        <input type="number" name="qty" id="qty" min="1"
                               max="{{ $event->available_qty }}" value="1"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-300 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="John" required/>
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Email comprador</label>
                        <input type="email" name="email" id="email" required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-300 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="tu@email.com">
                    </div>
                    <div class="flex items-center justify-between">
                        @if($event->available_qty > 0)
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Comprar Ahora
                            </button>
                        @else
                            <span class="inline-flex items-center rounded-md bg-indigo-50 px-5 py-4 text-xs font-medium text-pink-700 ring-1 ring-inset ring-pink-700/10">Sin existencias</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
