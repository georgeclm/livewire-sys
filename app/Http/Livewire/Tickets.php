<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\SupportTicket;
use App\Models\User;
use Livewire\Component;

class Tickets extends Component
{
    public $active;
    public $activeUser;
    public $searchUser = '';
    public $userIds;

    protected $listeners = ['ticketSelected', 'userSelected', 'refreshTicketView'];

    public function refreshTicketView()
    {
        $this->render();
    }

    public function ticketSelected($ticketIdSelected)
    {
        $this->active = $ticketIdSelected;
    }

    public function userSelected($userId)
    {
        $this->activeUser = $userId;
    }


    public function mount()
    {
        $chats = Chat::where('sender', auth()->id())->orWhere('receiver', auth()->id());
        $this->userIds = array_unique(array_merge($chats->pluck('sender')->toArray(), $chats->pluck('receiver')->toArray()));
    }

    public function render()
    {
        $users = User::where('id', '!=', auth()->id());
        $users = $users->when($this->searchUser != '', function ($query) {
            $query->where('name', 'LIKE', "%{$this->searchUser}%");
        });
        if ($this->searchUser == '' && !empty($this->userIds)) {
            $users = $users->whereIn('id', $this->userIds);
        }
        $users = $users->get();
        return view('livewire.tickets', compact('users'));
    }
}
