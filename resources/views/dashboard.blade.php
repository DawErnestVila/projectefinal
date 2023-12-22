<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="py-15 mt-6">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-green-800 font-black text-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="alert alert-success my-7 text-center" role="alert">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-4xl font-black text-center mb-7">Assignar Reserva</h1>
                    <form action="" method="post">
                        @rcsrf
                        <input type="tel" id="phone"
                            class="w-1/3 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                            placeholder="123456789" pattern="[0-9]{9}">
                        <input type="submit" value="Buscar Reserva"
                            class="w-1/3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    </form>
                    <div class="reserves" id="reserves"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/dashboard.mjs') }}"></script>
</x-app-layout>
