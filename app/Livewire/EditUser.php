<?php

namespace App\Livewire;

use Livewire\Component;

class EditUser extends ModalComponent{
    
    public function render()
    {
             session()->flash('alert', 'Please, login.');
        return view('livewire.edit-user');
    }
}
