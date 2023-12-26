<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-evenly">
            <h2 class="font-semibold  text-gray-800 leading-tight">
                <a href="#historial" class="hover:underline focus:underline">
                    {{ __('Historial de Resreves') }}
                </a>
            </h2>
            <h2 class="font-semibold  text-gray-800 leading-tight">
                <a href="#buscar-historial" class="hover:underline focus:underline">
                    {{ __('Historial de Resreves') }}
                </a>
            </h2>
        </div>
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
                    <h1 id="historial" class="text-4xl font-black text-center mb-7">Historial de Reserves</h1>
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
                    {{ $historials->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <h1 id="buscar-historial" class="text-4xl font-black text-center mb-7">Buscar a l'Historial</h1>

                    <!-- Secció de cerca -->
                    <div class="mb-4 mx-2 overflow-x-auto">
                        <div class="flex flex-col items-end overflow-x-auto">
                            <div class="flex flex-wrap items-center space-x-4 overflow-x-auto sm:flex-row">
                                <!-- Input per buscar per nom de client -->
                                <input type="text" id="clientSearch" placeholder="Nom del Client"
                                    class="px-4 border border-gray-300 rounded mb-2">

                                <!-- Input per buscar per nom de tractament -->
                                <select name="tractaments" id="tractaments"
                                    class="px-4 border border-gray-300 rounded mb-2">
                                    <option value="" selected>Tractament</option>
                                </select>

                                <!-- Input per buscar per data -->
                                <input type="text" id="dateSearch" placeholder="Data (DD/MM/YYYY)"
                                    class="px-4 border border-gray-300 rounded mb-2">

                                <!-- Input per buscar per nom de l'alumne -->
                                <input type="text" id="studentSearch" placeholder="Nom de l'Alumne"
                                    class="px-4 border border-gray-300 rounded mb-2">

                                <!-- Input per buscar per reserves cancelades -->
                                <div class="flex flex-col items-center mb-2">
                                    <label for="cancelada">Cancelada</label>
                                    <input type="checkbox" name="cancelada" id="cancelada" class="mr-2">
                                </div>
                            </div>

                            <!-- Botó per realitzar la cerca -->
                            <button onclick="realitzarCerca()"
                                class="px-4 py-2 bg-blue-500 hover:bg-blue-700 transition-colors duration-200 text-white rounded mt-2">Cerca</button>
                        </div>
                    </div>

                    <!-- Taula d'historials -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-left rtl:text-right text-gray-500">
                            <!-- Encapçalament de la taula -->
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
                            <tbody id="tbody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/historial.mjs') }}"></script>
</x-app-layout>
