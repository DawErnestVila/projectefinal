<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-evenly">
            <h2 class="font-semibold  text-gray-800 leading-tight">
                <a href="#gestionar-reserves" class="hover:underline focus:underline">
                    {{ __('Gestionar Reserves') }}
                </a>
            </h2>
            @if (auth()->user()->name == 'Professorat')
                <h2 class="font-semibold  text-gray-800 leading-tight">
                    <a href="#cancelar-reserves" class="hover:underline focus:underline">
                        {{ __('Cancelar Reserves') }}
                    </a>
                </h2>
            @endif
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

    <div class="py-15 mt-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="font-black overflow-hidden sm:rounded-lg">
                <div id="flash-message" class="alert alert-success my-7 text-center"></div>
            </div>
        </div>
    </div>

    <div class="py-12" id="gestionar-reserves">
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


    @if (auth()->user()->name == 'Professorat')
        <div class="py-12" id="cancelar-reserves">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-4xl font-black text-center mb-7">Cancel·lar Reserva</h1>
                        <div class="mx-auto">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3">Client</th>
                                            <th class="px-6 py-3">Tractament</th>
                                            <th class="px-6 py-3">Data</th>
                                            <th class="px-6 py-3">Hora</th>
                                            <th class="px-6 py-3">Acció</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reserves-cancelar">
                                        @foreach ($reserves as $reserva)
                                            <tr
                                                class="border-t {{ $loop->iteration % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $reserva->client->nom }}</td>
                                                <td class="px-6 py-4">{{ $reserva->tractament->nom }}</td>
                                                <td class="px-6 py-4">
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $reserva->data)->format('d/m/Y') }}
                                                </td>
                                                <td class="px-6 py-4">{{ substr($reserva->hora, 0, 5) }}h</td>
                                                <td class="px-6 py-4">
                                                    <button
                                                        class="cancelar-reserva bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300"
                                                        onclick="openCancelRow({{ $reserva->id }})"
                                                        data-id="{{ $reserva->id }}">Cancel·lar</button>
                                                </td>
                                            </tr>
                                            <tr id="cancelRow{{ $reserva->id }}"
                                                class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} overflow-hidden transform transition-transform duration-300 scale-y-0 hidden">
                                                <td colspan="5" class="px-6 py-4 border-b">
                                                    <form method="POST"
                                                        action="{{ route('cancelar-reserva', ['reserva_id' => $reserva->id]) }}">
                                                        @csrf
                                                        <input type="text" name="motiu"
                                                            placeholder="Motiu de la cancel·lació" required
                                                            class="w-3/4">
                                                        <button type="submit"
                                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">Enviar</button>
                                                    </form>
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
    @endif



    <script src="{{ asset('js/dashboard.mjs') }}"></script>
    <script>
        function openCancelRow(id) {
            const row = document.getElementById('cancelRow' + id);
            if (row.classList.contains('scale-y-0')) {
                // Mostrem la fila i l'animem
                row.classList.remove('hidden');
                setTimeout(() => {
                    row.classList.remove('scale-y-0');
                    row.classList.add('scale-y-100');
                }, 100);

            } else {
                // Amaguem la fila i l'animem
                row.classList.remove('scale-y-100');
                row.classList.add('scale-y-0');

                // Afegim la classe hidden després de l'animació
                setTimeout(() => {
                    row.classList.add('hidden');
                }, 300); // 300 mil·lisegons igual que la duració de l'animació
            }
        }
    </script>
</x-app-layout>
