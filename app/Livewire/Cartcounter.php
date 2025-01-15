<?php

namespace App\Livewire;

use App\Models\Shoppingcart;
use Livewire\Component;

class Cartcounter extends Component
{
    public $total = 0;

    protected $listeners = ['updateCartCount'=> 'getCartItemCount'];
    
    public function render()
    {
        $this->getCartItemCount();
        return view('livewire.cartcounter');
    }
    public function getCartItemCount(){
        $this->total = shoppingcart::whereUserId(auth()->user()->id)
            ->where('status', '!=', shoppingcart::STATUS['success'])
            ->count();
    }
}
