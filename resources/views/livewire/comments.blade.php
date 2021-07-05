<div>
    <h1>Comments</h1>
    @error('newComment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    <div class="py-3">
        @if (session('message'))
            <div class="p-3 bg-success text-green-800 rounded shadow-sm">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <section>
        @if ($image)
            <img src={{ $image }} width="200" />
        @endif
        {{-- emit on change to call an event in script listener --}}
        <input type="file" id="image" wire:change="$emit('fileChoosen')">
    </section>
    <form class="my-4 d-flex" wire:submit.prevent="addComment">
        {{-- if use lazy then it will only request after it lose focus cant work with search input can use .debounce.500ms --}}
        <input type="text" class="w-100 rounded border shadow p-2 mr-2 my-2" placeholder="What's in your mind."
            wire:model.debounce.500ms="newComment">
        <div class="py-2">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>
    @foreach ($comments as $comment)
        <div class="rounded border shadow p-3 my-2">
            <div class="d-flex justify-content-between my-2">
                <div class="d-flex">
                    <p class="font-bold text-lg">{{ $comment->user->name }}</p>
                    <p class="mx-3 text-muted ">
                        <small>{{ $comment->created_at->diffForHumans() }}</small>
                    </p>
                </div>
                <a href="javascript:void(0)"><i class="fas fa-times text-danger"
                        wire:click="remove({{ $comment->id }})"></i></a>
            </div>
            <p class="text-gray-800">{{ $comment->body }}</p>
            @if ($comment->image)
                <img src="{{ $comment->imagePath }}" width="200" />
            @endif
        </div>
    @endforeach

    {{ $comments->links() }}
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

</script>
