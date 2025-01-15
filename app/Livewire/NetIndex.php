<?php

namespace App\Livewire;

use App\Models\Net;
use Livewire\Component;
use Livewire\WithPagination;

class NetIndex extends Component
{
	use WithPagination;
	
	//protected $paginationTheme = "bootstrap";
	
	public $search;
	
	public function updatingSearch()
	{
		$this->resetPage();
	}
	
	public function render()
	{
		$nets = Net::where('name', 'LIKE', '%' . $this->search . '%')
            ->where('phone', 'LIKE', '%' . $this->search . '%')
            ->where('zipcode', 'LIKE', '%' . $this->search . '%')
            ->where('city', 'LIKE', '%' . $this->search . '%')
            ->where('country', 'LIKE', '%' . $this->search . '%')
			->latest('id')
			->paginate();
		
		return view('livewire.net-index', compact('nets'));
	}
}