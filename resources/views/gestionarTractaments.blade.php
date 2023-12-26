<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-evenly">
            <h2 class="font-semibold  text-gray-800 leading-tight">
                <a href="#historial" class="hover:underline focus:underline">
                    {{ __('Tractaments') }}
                </a>
            </h2>
            <h2 class="font-semibold  text-gray-800 leading-tight">
                <a href="#editar-tractament" class="hover:underline focus:underline">
                    {{ __('Editar Tractament') }}
                </a>
            </h2>
            <h2 class="font-semibold  text-gray-800 leading-tight">
                <a href="#afegir-tractament" class="hover:underline focus:underline">
                    {{ __('Afegir Tractament') }}
                </a>
            </h2>
        </div>
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
            <div class="font-black overflow-hidden sm:rounded-lg">
                <div id="flash-message" class="alert alert-success my-7 text-center"></div>
            </div>
        </div>
    </div>

    <div class="py-12" id="tractaments">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 id="historial" class="text-4xl font-black text-center mb-7">Tractaments</h1>
                    <div class="mx-auto">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Nom
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Descripció
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Durada
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Accions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tractaments as $tractament)
                                        <tr class="bg-white" data-tractament-id="{{ $tractament->id }}">
                                            <td scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $tractament->nom }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $tractament->descripcio }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ substr($tractament->durada, 0, 5) }}h
                                            </td>
                                            <td class="px-6 py-4">
                                                <button id="edita-tractament" data-tractament-id="{{ $tractament->id }}"
                                                    class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white  focus:ring-4 focus:outline-none focus:ring-blue-300">
                                                    <span
                                                        class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white  rounded-md group-hover:bg-opacity-0">
                                                        Edita
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12" id="editar-tractament" style="display: none;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <h1 class="text-4xl font-black text-center mb-7">Editar Tractament</h1>
                    <div class="relative overflow-x-auto sm:rounded-lg pb-5">
                        <div class="w-1/3 mx-auto">
                            <form method="POST" action="{{ route('editar-tractament') }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tractament_id" id="tractament_id">

                                <!-- Nom -->
                                <div class="mb-4">
                                    <label for="nom" class="text-gray-700 text-sm">Nom</label>
                                    <input id="nom"
                                        class="block mt-1 w-full border border-gray-300 rounded-md p-2.5" type="text"
                                        name="nom" value="{{ old('nom') }}" required>
                                </div>

                                <!-- Descripcio -->
                                <div class="mb-4">
                                    <label for="descripcio" class="text-gray-700 text-sm">Descripció</label>
                                    <input id="descripcio"
                                        class="block mt-1 w-full border border-gray-300 rounded-md p-2.5" type="text"
                                        name="descripcio" value="{{ old('descripcio') }}" required>
                                </div>

                                <!-- Durada -->
                                <div class="mb-4 flex items-center">
                                    <div class="flex-1">
                                        <label for="hores" class="text-gray-700 text-sm">Hores</label>
                                        <input id="hores"
                                            class="block mt-1 w-full border border-gray-300 rounded-md p-2.5"
                                            min="0" type="number" name="hores" value="{{ old('hores') }}"
                                            required>
                                    </div>

                                    <span class="mx-2"></span>

                                    <div class="flex-1">
                                        <label for="minuts" class="text-gray-700 text-sm">Minuts</label>
                                        <input id="minuts" min="0"
                                            class="block mt-1 w-full border border-gray-300 rounded-md p-2.5"
                                            type="number" name="minuts" value="{{ old('minuts') }}" required>
                                    </div>
                                </div>

                                <div id="editar-tractament" class="flex items-center justify-between mt-4">
                                    <button type="submit" id="editar-tractament-btn"
                                        class="bg-blue-500 hover:bg-blue-700 transition-colors duration-200 text-white py-2 px-4 rounded-md">{{ __('Editar') }}</button>
                                    <button id="eliminar-tractament" type="button"
                                        class="bg-red-500 hover:bg-red-700 transition-colors duration-200 text-white py-2 px-4 rounded-md">{{ __('Eliminar Tractament') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12" id="afegir-tractament">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <h1 class="text-4xl font-black text-center mb-7">Afegir Tractament</h1>
                    <div class="relative overflow-x-auto sm:rounded-lg pb-5">
                        <div class="w-1/3 mx-auto">
                            <form method="POST" action="{{ route('crear-tractament') }}">
                                @csrf
                                <input type="hidden" name="tractament_id" id="tractament_id">

                                <!-- Nom -->
                                <div class="mb-4">
                                    <label for="nom" class="text-gray-700 text-sm">Nom</label>
                                    <input id="nom"
                                        class="block mt-1 w-full border border-gray-300 rounded-md p-2.5"
                                        type="text" name="nom" value="{{ old('nom') }}" required>
                                </div>

                                <!-- Descripcio -->
                                <div class="mb-4">
                                    <label for="descripcio" class="text-gray-700 text-sm">Descripció</label>
                                    <input id="descripcio"
                                        class="block mt-1 w-full border border-gray-300 rounded-md p-2.5"
                                        type="text" name="descripcio" value="{{ old('descripcio') }}" required>
                                </div>

                                <!-- Durada -->
                                <div class="mb-4 flex items-center">
                                    <div class="flex-1">
                                        <label for="hores" class="text-gray-700 text-sm">Hores</label>
                                        <input id="hores"
                                            class="block mt-1 w-full border border-gray-300 rounded-md p-2.5"
                                            min="0" type="number" name="hores"
                                            value="{{ old('hores') }}" required>
                                    </div>

                                    <span class="mx-2"></span>

                                    <div class="flex-1">
                                        <label for="minuts" class="text-gray-700 text-sm">Minuts</label>
                                        <input id="minuts" min="0"
                                            class="block mt-1 w-full border border-gray-300 rounded-md p-2.5"
                                            type="number" name="minuts" value="{{ old('minuts') }}" required>
                                    </div>
                                </div>

                                <div id="editar-tractament" class="flex items-center justify-between mt-4">
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-700 transition-colors duration-200 text-white py-2 px-4 rounded-md">{{ __('Afegir Tractament') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/tractaments.mjs') }}"></script>
</x-app-layout>
