<div>
    <form wire:submit.prevent="toggleStatus">
        @csrf
        @method('put')

        <x-danger-button type="submit"
            class="{{ $user->habilitat ? 'bg-orange-500 hover:bg-orange-700 focus:ring-2 focus:ring-orange-500' : 'bg-green-500 hover:bg-green-700 focus:ring-2 focus:ring-green-500' }} text-white">
            {{ $user->habilitat ? __('Deshabilitar Alumne') : __('Habilitar Alumne') }}
        </x-danger-button>
    </form>
</div>
