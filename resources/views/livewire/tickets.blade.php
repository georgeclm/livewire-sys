<div>
    <h1>Chats</h1>
    <input type="text" class="w-100 rounded border shadow p-2 mr-2 my-2" placeholder="Search User"
        wire:model.debounce.500ms="searchUser">
    @foreach ($users as $user)
        @php
            $chats = App\Models\Chat::whereIn('sender', [auth()->id(), $user->id])->whereIn('receiver', [auth()->id(), $user->id]);
            $unread = $user->unread_chats($user->id);
            $last_chat = $chats->latest()->first();
        @endphp
        <div class="rounded border shadow p-3 my-1 {{ $activeUser == $user->id ? 'bg-secondary' : '' }}"
            wire:click="$emit('userSelected',{{ $user->id }})">
            <div class="d-flex justify-content-between">
                <div class="text-gray-800">{{ $user->name }}
                    @if ($unread != 0)
                        <span class="badge badge-success">{{ $unread }}</span>
                    @endif
                </div>
                <div>
                    @if ($last_chat != null)
                        {{ @$last_chat->created_at->toDateString() == now()->toDateString() ? $last_chat->created_at->format('G:i') : $transaction->created_at->format('Y-m-d') }}
                    @endif
                </div>
            </div>
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
