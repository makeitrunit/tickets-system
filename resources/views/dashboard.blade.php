<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{url('dashboard/events')}}" class="bg-blue-500 text-white flex items-center justify-center h-32 w-full rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">
                            <svg class="w-16 h-16 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="text-xl">Eventos</span>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <a href="{{url('dashboard/purchases')}}" class="bg-blue-500 text-white flex items-center justify-center h-32 w-full rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">
                            <svg class="w-16 h-16 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="text-xl">Compras</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
