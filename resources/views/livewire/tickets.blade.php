<div>
    <h1>Support Tickets</h1>
    @foreach ($tickets as $ticket)

        <div class="rounded border shadow p-3 my-2 {{ $active == $ticket->id ? 'bg-primary' : '' }}"
            wire:click="$emit('ticketSelected',{{ $ticket->id }})">
            <p class="text-gray-800">{{ $ticket->question }}</p>
        </div>
    @endforeach
</div>
