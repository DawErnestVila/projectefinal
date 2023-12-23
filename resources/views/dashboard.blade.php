<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <input type="hidden" name="user_id" id="user_id" value={{ auth()->user()->id }}>
    <link rel="stylesheet" href="{{ asset('css/reserves.css') }}">

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
    @if (session('error'))
        <div class="py-15 mt-6">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-red-800 font-black text-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="alert alert-success my-7 text-center" role="alert">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-15 mt-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="font-black overflow-hidden shadow-sm sm:rounded-lg">
                <div id="flash-message" class="alert alert-success my-7 text-center"></div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-4xl font-black text-center mb-7">Assignar Reserva</h1>
                    <div class="mx-auto">
                        <div class="w-1/3 mx-auto"> <!-- Add mx-auto class to this container -->
                            <input type="tel" id="phone"
                                class="w-full bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#ffd699] focus:border-[#ffd699] block p-2.5"
                                placeholder="123456789" pattern="[0-9]{9}">
                        </div>
                    </div>
                    <div class="reserves flex flex-col items-center pt-7" id="reserves"></div>
                </div>
            </div>
        </div>
    </div>



    <script src="{{ asset('js/dashboard.mjs') }}"></script>
</x-app-layout>
