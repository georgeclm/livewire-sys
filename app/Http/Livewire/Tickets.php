<?php

namespace App\Http\Livewire;

use App\Models\SupportTicket;
use Livewire\Component;

class Tickets extends Component
{
    public $active;

    protected $listeners = ['ticketSelected'];

    public function ticketSelected($ticketIdSelected)
    {
        $this->active = $ticketIdSelected;
    }

    public function render()
    {
        $tickets = SupportTicket::latest()->get();
        return view('livewire.tickets', compact('tickets'));
    }
}
