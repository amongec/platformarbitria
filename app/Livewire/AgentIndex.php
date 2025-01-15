<?php

namespace App\Livewire;

use App\Models\Agent;
use Livewire\Component;
use Livewire\WithPagination;

class AgentIndex extends Component
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
		$agents = Agent::where('name', 'LIKE', '%' . $this->search . '%')
            ->where('phone', 'LIKE', '%' . $this->search . '%')
            ->where('zipcode', 'LIKE', '%' . $this->search . '%')
            ->where('city', 'LIKE', '%' . $this->search . '%')
            ->where('country', 'LIKE', '%' . $this->search . '%')
            ->where('agent_zone', 'LIKE', '%' . $this->search . '%')
			->latest('id')
			->paginate();
		
		return view('livewire.agent-index', compact('agents'));
	}
}