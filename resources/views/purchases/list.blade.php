<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Purchases List') }}
        </h2>
    </x-slot>

    @if ($errors->any())
        <div class=" items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 " role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Ha ocurrido un error!</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <section class="mt-6 space-y-6 p-4">
        <!-- Filtro -->
        <form method="GET" action="{{ route('events.purchases') }}" class="flex gap-4 ml-1 mb-2">
            <div>
                <x-input-label for="event_id" :value="__('Seleccionar Evento')" />
                <select id="event_id" name="event_id" class="mt-1 block w-full">
                    <option value="">Seleccione un evento</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" {{ request()->get('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <x-primary-button>{{ __('Filter') }}</x-primary-button>
            </div>
        </form>

        <!-- Lista de Compras -->
        <div class="overflow-x-auto">
            <table class="w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <thead>
                <tr class="text-left text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-900">
                    <th class="py-3 px-4 font-medium">{{ __('#') }}</th>
                    <th class="py-3 px-4 font-medium">{{ __('Event Name') }}</th>
                    <th class="py-3 px-4 font-medium">{{ __('Status') }}</th>
                    <th class="py-3 px-4 font-medium">{{ __('Buyer') }}</th>
                    <th class="py-3 px-4 font-medium">{{ __('Email') }}</th>
                    <th class="py-3 px-4 font-medium">{{ __('Quantity') }}</th>
                </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-300">
                @forelse ($purchases as $purchase)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="py-3 px-4">{{ $purchase->id }}</td>
                        <td class="py-3 px-4">{{ $purchase->event->name }}</td>
                        <td class="py-3 px-4">{{ $purchase->status }}</td>
                        <td class="py-3 px-4">{{ $purchase->user->name }}</td>
                        <td class="py-3 px-4">{{ $purchase->user->email }}</td>
                        <td class="py-3 px-4">
                            {{ $purchase->qty }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-3 px-4 text-center text-gray-500 dark:text-gray-400">
                            {{ __('No events found.') }}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $purchases->links() }}
        </div>
    </section>
</x-app-layout>
