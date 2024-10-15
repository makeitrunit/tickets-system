<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Event Create') }}
        </h2>
    </x-slot>
    <section class="mt-6 p-4">
        <div class="flex justify-center ">
            <div class="w-full max-w-md">
                <form method="post" action="{{ route('events.store') }}" class="space-y-6 w-1/2">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')"/>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name"/>
                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                    </div>

                    <div>
                        <x-input-label for="qty" :value="__('Cantidad')"/>
                        <x-text-input id="qty" name="qty" type="text" class="mt-1 block w-full" required autofocus autocomplete="qty"/>
                        <x-input-error class="mt-2" :messages="$errors->get('qty')"/>
                    </div>

                    <div>
                        <x-input-label for="available_qty" :value="__('Cantidad disponible')"/>
                        <x-text-input id="available_qty" name="available_qty" type="text" class="mt-1 block w-full" required autofocus autocomplete="available_qty"/>
                        <x-input-error class="mt-2" :messages="$errors->get('available_qty')"/>
                    </div>

                    <div>
                        <x-input-label for="date_from" :value="__('From')"/>
                        <x-text-input
                            id="date_from"
                            name="date_from"
                            type="datetime-local"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('date_from')"/>
                    </div>

                    <div>
                        <x-input-label for="date_until" :value="__('Until')"/>
                        <x-text-input
                            id="date_until"
                            name="date_until"
                            type="datetime-local"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('date_until')"/>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'event-created')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Created.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
