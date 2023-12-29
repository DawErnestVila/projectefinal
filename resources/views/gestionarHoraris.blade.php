<x-app-layout>
    {{-- <x-slot name="header">
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
    </x-slot> --}}

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

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 id="historial" class="text-4xl font-black text-center mb-7">Dies de Festa</h1>
                    <form action="{{ route('actualitzar-dies-deshabilitats') }}" method="POST">
                        @csrf
                        <div class="mx-auto">
                            <div class="flex flex-col items-center space-y-4">
                                <div class="relative w-full overflow-x-auto shadow-md ">
                                    <x-flatpickr name="dates" :config="[
                                        'dateFormat' => 'd/m/Y',
                                        'locale' => [
                                            'firstDayOfWeek' => 1,
                                            'weekdays' => [
                                                'shorthand' => ['Dg', 'Dl', 'Dm', 'Dx', 'Dj', 'Dv', 'Ds'],
                                                'longhand' => [
                                                    'Diumenge',
                                                    'Dilluns',
                                                    'Dimarts',
                                                    'Dimecres',
                                                    'Dijous',
                                                    'Divendres',
                                                    'Dissabte',
                                                ],
                                            ],
                                            'months' => [
                                                'shorthand' => [
                                                    'Gen',
                                                    'Feb',
                                                    'Mar',
                                                    'Abr',
                                                    'Maig',
                                                    'Juny',
                                                    'Jul',
                                                    'Ago',
                                                    'Set',
                                                    'Oct',
                                                    'Nov',
                                                    'Des',
                                                ],
                                                'longhand' => [
                                                    'Gener',
                                                    'Febrer',
                                                    'Març',
                                                    'Abril',
                                                    'Maig',
                                                    'Juny',
                                                    'Juliol',
                                                    'Agost',
                                                    'Setembre',
                                                    'Octubre',
                                                    'Novembre',
                                                    'Desembre',
                                                ],
                                            ],
                                        ],
                                        'disableMobile' => true,
                                        'mode' => 'multiple',
                                        'minDate' => 'today',
                                        'defaultDate' => $diesDeshabilitats,
                                    ]" />
                                </div>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flatpickrInstance = flatpickr("#flatpickr", {
                dateFormat: 'd/m/Y',
                locale: {
                    // Configuració de la localització
                },
                disableMobile: true,
                mode: 'multiple',
                minDate: 'today',
                defaultDate: $diesDeshabilitats,
                onChange: function(selectedDates, dateStr, instance) {
                    // Quan les dates seleccionades canviïn, actualitza un camp ocult amb les dates seleccionades
                    document.getElementById('selected-dates').value = selectedDates.map(date => date
                        .toLocaleDateString()).join(',');
                }
            });
        });
    </script>


    <div class="py-12" id="tractaments">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 id="historial" class="text-4xl font-black text-center mb-7">Gestionar Horaris</h1>
                    <div class="mx-auto">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <form method="post" action="{{ route('actualitza-horaris') }}"
                                class="w-full max-w-md mx-auto mt-8 mb-8">
                                @csrf
                                @method('PUT')

                                @php
                                    $nomsDiesSetmana = ['Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres'];
                                @endphp

                                @for ($dia = 1; $dia <= count($nomsDiesSetmana); $dia++)
                                    @php
                                        $horariDia = collect($horaris)
                                            ->where('dia', $dia)
                                            ->first();
                                    @endphp

                                    <div class="mb-6 p-4 bg-gray-100 rounded grid grid-cols-2">
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700">{{ $nomsDiesSetmana[$dia - 1] }}</label>
                                            <div class="flex items-center mt-2">
                                                <input type="checkbox" name="dies[]" value="{{ $dia }}"
                                                    {{ $horariDia ? 'checked' : '' }}
                                                    class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                                <span class="ml-2 text-sm text-gray-600">Obert</span>
                                            </div>
                                        </div>

                                        <div class="flex flex-col">
                                            <label for="hora_obertura_{{ $dia }}"
                                                class="block text-sm font-medium text-gray-700">Hora d'obertura</label>
                                            <input type="text" name="hores[{{ $dia }}][hora_obertura]"
                                                value="{{ $horariDia ? \Carbon\Carbon::parse($horariDia['hora_obertura'])->format('H:i') : '' }}"
                                                class="form-input mt-1 hora-input" pattern="[0-2][0-9]:[0-5][0-9]"
                                                placeholder="08:00" title="Format: HH:mm">
                                            @error("hores.$dia.hora_obertura")
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flex flex-col mt-4">
                                            <label for="hora_tancament_{{ $dia }}"
                                                class="block text-sm font-medium text-gray-700">Hora de
                                                tancament</label>
                                            <input type="text" name="hores[{{ $dia }}][hora_tancament]"
                                                value="{{ $horariDia ? \Carbon\Carbon::parse($horariDia['hora_tancament'])->format('H:i') : '' }}"
                                                class="form-input mt-1 hora-input" pattern="[0-2][0-9]:[0-5][0-9]"
                                                placeholder="20:00" title="Format: HH:mm">

                                            @error("hores.$dia.hora_tancament")
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endfor

                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Actualitzar Horaris
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-flatpickr::style />
    <x-flatpickr::script />

    <script src="{{ asset('js/horaris.mjs') }}"></script>
</x-app-layout>
