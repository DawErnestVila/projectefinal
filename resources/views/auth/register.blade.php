<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-evenly">
            <h2 class="font-semibold  text-gray-800 leading-tight">
                <a href="#afegir" class="hover:underline focus:underline">
                    {{ __('Afegir Alumne') }}
                </a>
            </h2>
            <h2 class="font-semibold  text-gray-800 leading-tight">
                <a href="#gestionar" class="hover:underline focus:underline">
                    {{ __('Gestionar Alumnes') }}
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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-4xl font-black text-center mb-7" id="afegir">Afegir Alumne</h1>
                    <div class="mx-auto">
                        <div class="w-1/3 mx-auto">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Name -->
                                <div>
                                    <x-input-label for="name" :value="__('Nom')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                        :value="old('name')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Email Address -->
                                <div class="mt-4">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                        :value="old('email')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="mt-4">
                                    <x-input-label for="password" :value="__('Contrasenya')" />

                                    <x-text-input id="password" class="block mt-1 w-full" type="password"
                                        name="password" required autocomplete="new-password" />

                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="mt-4">
                                    <x-input-label for="password_confirmation" :value="__('Confirma la Contrasenya')" />

                                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                        name="password_confirmation" required autocomplete="new-password" />

                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">

                                    <x-primary-button class="ms-4">
                                        {{ __('Registra') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-4xl font-black text-center mb-7" id="gestionar">Gestionar Alumnes</h1>
                    <div class="mx-auto">
                        <div class="mx-auto mb-4 flex-col flex w-1/3">
                            <x-input-label for="searchInput">Filtrar per Alumne</x-input-label>
                            <x-text-input type="text" id="searchInput" placeholder="Cerca per nom"
                                class="rounded-md" />
                        </div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table id="userTable" class="w-full text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Nom
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Reserves Assignades
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Accions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @if ($user['user']->name != 'Professorat')
                                            <tr class="bg-white border-b hover:bg-gray-200">
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $user['user']->name }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $user['user']->email }}
                                                </td>
                                                <td class="px-6 py-4">

                                                    {{ $user['historials'] }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex space-x-2">
                                                        <livewire:toggle-user-status :user="$user['user']" />

                                                        <x-danger-button x-data=""
                                                            x-on:click.prevent="
                                                            if (confirm('{{ __('Estàs segur de que vols aliminar aquest alumne?') }}')) {
                                                                $dispatch('open-modal', 'confirm-user-deletion-{{ $user['user']->id }}');
                                                            }
                                                            ">
                                                            {{ __('Eliminar Alumne') }}
                                                        </x-danger-button>
                                                    </div>

                                                    <x-modal :name="'confirm-user-deletion-' . $user['user']->id" :show="request()->routeIs('delete.user', $user['user'])">
                                                        <form method="post" action="{{ route('delete.user') }}"
                                                            class="p-6">
                                                            @csrf
                                                            @method('delete')

                                                            <input type="hidden" name="user_id"
                                                                value="{{ $user['user']->id }}">

                                                            <h2 class="text-lg font-medium text-gray-900">
                                                                {{ __('Estàs segur de que vols aliminar aquest alumne?') }}
                                                            </h2>

                                                            <p class="mt-1 text-sm text-gray-600">
                                                                {{ __("Un cop l'alumne s'hagi eliminat, tots els seus recursos i data seràn eliminats permanentment") }}
                                                            </p>

                                                            <div class="mt-6">
                                                                <x-input-label for="password"
                                                                    value="{{ __('Password') }}" class="sr-only" />
                                                                <x-text-input id="password" name="password"
                                                                    type="password" class="mt-1 block w-3/4"
                                                                    placeholder="{{ __('Contrasenya') }}" />
                                                                <x-input-error :messages="$errors->userDeletion->get(
                                                                    $user['user']->id . '.password',
                                                                )" class="mt-2" />
                                                            </div>

                                                            <div class="mt-6 flex justify-end">
                                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                                    {{ __('Cancel·lar') }}
                                                                </x-secondary-button>

                                                                <x-danger-button class="ms-3">
                                                                    {{ __('Eliminar Alumne') }}
                                                                </x-danger-button>
                                                            </div>
                                                        </form>
                                                    </x-modal>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function filterTable() {
            let input, filter, table, tbody, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("userTable");
            tbody = table.getElementsByTagName("tbody")[0];
            tr = tbody.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("th")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Afegir l'esdeveniment input per fer la cerca dinàmica
        document.getElementById("searchInput").addEventListener("input", filterTable);
    </script>



</x-app-layout>
