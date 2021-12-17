<div wire:poll.visible.5s>
    <h1>{{ $receiver->name ?? 'Select User To Chat With' }}</h1>
    @error('newComment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    <div class="py-3">
        @if (session('message'))
            <div class="p-3 bg-success text-green-800 rounded shadow-sm">
                {{ session('message') }}
            </div>
        @endif
    </div>


    <div style="height:455px; overflow-y:auto" id="chat-container">
        @foreach ($dates as $date => $chats)
            <div class="rounded border shadow text-center py-1">
                <div class="">{{ $date == now()->format('Y-m-d') ? 'Today' : $date }}</div>
            </div>
            @foreach ($chats as $chat)
                @php
                    if ($chat->the_receiver->id == auth()->id()) {
                        $chat->read = 1;
                        $chat->save();
                    }
                @endphp
                <div class="rounded border shadow p-3 my-2 @if ($chat->the_sender->id == auth()->id()) bg-teal-green  @endif">
                    <div class="d-flex float-right">
                        <div class="flex-grow-1"></div>
                        {{-- <p class="font-bold text-lg">{{ $chat->the_sender->name }}</p> --}}
                        <small>{{ $chat->created_at->format('G:i') }} </small>
                        @if ($chat->the_sender->id == auth()->id())
                            @if ($chat->read == 1)
                                <img src="{{ asset('images/double-check-seen.svg') }}" />
                            @else
                                <img src="{{ asset('images/double-check-unseen.svg') }}" />
                            @endif
                        @endif
                    </div>
                    <p class="text-gray-800">{{ $chat->text }}</p>
                    {{-- <a href="javascript:void(0)"><i class="fas fa-times text-danger"
                        wire:click="remove({{ $chat->id }})"></i></a> --}}
                    @if ($chat->image)
                        <img src="{{ asset("storage/{$chat->image}") }}" width="200" />
                    @endif
                </div>
            @endforeach
        @endforeach
    </div>

    {{-- emit on change to call an event in script listener --}}
    @if ($receiver)
        <form class="my-4 d-flex" wire:submit.prevent="addComment">
            {{-- if use lazy then it will only request after it lose focus cant work with search input can use .debounce.500ms --}}
            <label for="image" style="cursor: pointer;"><i class="fas fa-image mt-4 mr-2"></i></label>
            <input type="text" class="w-100 rounded border shadow p-2 mr-2 my-2" placeholder="Say Something..."
                wire:model.debounce.500ms="newComment">
            <div class="py-2">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
        @if ($image)
            <img src={{ $image }} height="50" />
        @endif
        <input style="display:none;" type="file" id="image" wire:change="$emit('fileChoosen')">
    @endif
</div>

<script>
    // for the listeners for image reader in javascript will called on listeners than happend on change image
    window.livewire.on('fileChoosen', () => {
        let inputField = document.getElementById('image')
        let file = inputField.files[0]
        let reader = new FileReader();
        reader.onloadend = () => {
            window.livewire.emit('fileUpload', reader.result)
        }
        reader.readAsDataURL(file);
    })
    window.livewire.on('scrollToBottom', () => {
        var objDiv = document.getElementById("chat-container");
        objDiv.scrollTop = objDiv.scrollHeight;
    });
</script>
