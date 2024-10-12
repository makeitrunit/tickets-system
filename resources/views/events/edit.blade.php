<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Event Update') }}
        </h2>
    </x-slot>
    <section class="mt-6 p-4">
        <div class="flex justify-center ">
            <div class="w-full max-w-md">

                <form method="post" action="{{ route('events.update', $event) }}" class="space-y-6 w-1/2">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="name" :value="__('Name')"/>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                      :value="old('name', $event->name)" required autofocus autocomplete="name"/>
                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                    </div>

                    <div>
                        <x-input-label for="qty" :value="__('Name')"/>
                        <x-text-input id="qty" name="qty" type="text" class="mt-1 block w-full"
                                      :value="old('name', $event->qty)" required autofocus autocomplete="qty"/>
                        <x-input-error class="mt-2" :messages="$errors->get('qty')"/>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'event-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
