<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestionar Alumnes') }}
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-4xl font-black text-center mb-7">Historial de Reserves</h1>
                    <div class="mx-auto">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Client
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Tractament
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Alumne
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Data
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Hora
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Data cancel·lació
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Motiu cancel·lació
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historials as $historial)
                                        <tr class="bg-white border-b hover:bg-gray-200">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $historial->client_name }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $historial->tractament_name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $historial->user_name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ \Carbon\Carbon::parse($historial->data)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ \Carbon\Carbon::parse($historial->hora)->format('H:i') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($historial->data_cancelacio)
                                                    {{ \Carbon\Carbon::parse($historial->data_cancelacio)->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($historial->motiu_cancelacio)
                                                    {{ $historial->motiu_cancelacio }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="reserves flex flex-col items-center pt-7" id="reserves"></div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
