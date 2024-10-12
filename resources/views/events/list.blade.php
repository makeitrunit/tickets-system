<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Events List') }}
        </h2>
    </x-slot>

    <section class="mt-6 space-y-6 p-4">
        <!-- Filtro -->
        <form method="GET" action="{{ route('events.index') }}" class="flex gap-4 ml-1 mb-2">
            <div>
                <x-input-label for="name" :value="__('Event Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="request()->get('name')" autofocus />
            </div>
            <div>
                <x-input-label for="qty" :value="__('Quantity')" />
                <x-text-input id="qty" name="qty" type="number" class="mt-1 block w-full" :value="request()->get('qty')" />
            </div>
            <div class="flex items-end">
                <x-primary-button>{{ __('Filter') }}</x-primary-button>
            </div>
        </form>

        <!-- Lista de Eventos -->
        <div class="overflow-x-auto">
            <table class="w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <thead>
                <tr class="text-left text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-900">
                    <th class="py-3 px-4 font-medium">{{ __('Event Name') }}</th>
                    <th class="py-3 px-4 font-medium">{{ __('Quantity') }}</th>
                    <th class="py-3 px-4 font-medium">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-300">
                @forelse ($events as $event)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="py-3 px-4">{{ $event->name }}</td>
                        <td class="py-3 px-4">{{ $event->qty }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('events.edit', $event->id) }}" class="text-blue-600 dark:text-blue-400">{{ __('Edit') }}</a>
                            <form method="POST" action="{{ route('events.destroy', $event->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 dark:text-red-400 ml-2">{{ __('Delete') }}</button>
                            </form>
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
            {{ $events->links() }}
        </div>
    </section>
</x-app-layout>
