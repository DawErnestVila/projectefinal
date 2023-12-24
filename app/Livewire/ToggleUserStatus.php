<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ToggleUserStatus extends Component
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function toggleStatus()
    {
        $this->user->update(['habilitat' => !$this->user->habilitat]);
    }

    public function render()
    {
        return view('livewire.toggle-user-status');
    }
}
