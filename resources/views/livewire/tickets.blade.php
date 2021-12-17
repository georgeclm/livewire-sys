<div>
    <h1>Chats</h1>
    <input type="text" class="w-100 rounded border shadow p-2 mr-2 my-2" placeholder="Search User"
        wire:model.debounce.500ms="searchUser">
    @foreach ($users as $user)
        @php
            $chats = App\Models\Chat::where(function ($query) {
                $query->where('sender', auth()->id())->orWhere('receiver', auth()->id());
            })->where(function ($query) use ($user) {
                $query->where('sender', $user->id)->orWhere('receiver', $user->id);
            });
            $chats_unread = clone $chats;
            $unread = $chats_unread
                ->where('sender', $user->id)
                ->where('read', 0)
                ->count();
            $last_chat = $chats->latest()->first();
        @endphp
        <div class="rounded border shadow p-3 my-1 {{ $activeUser == $user->id ? 'bg-secondary' : '' }}"
            wire:click="$emit('userSelected',{{ $user->id }})">
            <p class="text-gray-800">{{ $user->name }}
                @if ($unread != 0)
                    <span class="badge badge-success">{{ $unread }}</span>
                @endif
            </p>
            <div class="row mx-auto">
                @if (@$last_chat->the_sender->id == auth()->id())
                    @if ($last_chat->read == 1)
                        <img src="{{ asset('images/double-check-seen.svg') }}" />
                    @else
                        <img src="{{ asset('images/double-check-unseen.svg') }}" />
                    @endif
                @endif
                <small>{{ $last_chat->text ?? '' }}</small>
            </div>
        </div>
    @endforeach
</div>
