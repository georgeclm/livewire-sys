<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Intervention\Image\ImageManagerStatic;

class Comments extends Component
{
    use WithPagination;

    public $newComment;
    public $image;
    public $ticketId;

    protected $listeners = [
        'fileUpload' => 'handleFileUpload',
        'ticketSelected'
    ];

    public function ticketSelected($ticketIdSelected)
    {
        $this->ticketId = $ticketIdSelected;
    }

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function render()
    {
        $comments = Comment::where('support_ticket_id', $this->ticketId)->latest()->paginate(5);
        return view('livewire.comments', compact('comments'));
    }
    // this updated function will always be called in updated validation real time check the newComment Field
    public function updated($field)
    {
        $this->validateOnly($field, ['newComment' => ['required', 'max:255']]);
    }

    public function addComment()
    {
        $image = $this->storeImage();
        Comment::create([
            'body' => $this->newComment,
            'user_id' => auth()->id(),
            'image' => $image,
            'support_ticket_id' => $this->ticketId
        ]);
        // frontend view data
        // $this->comments->prepend($createdComment);
        $this->newComment = '';
        $this->image = '';
        session()->flash('message', 'Comment added successfully');
    }

    public function storeImage()
    {
        if (!$this->image) {
            return null;
        }
        $img = ImageManagerStatic::make($this->image)->encode('jpg');
        $name = Str::random() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;
    }

    public function remove(Comment $comment)
    {
        $comment->delete();
        Storage::disk('public')->delete($comment->image);
        // remove from the data in frontend
        // $this->comments = $this->comments->except($comment->id);
        session()->flash('message', 'Comment deleted successfully');
    }
}
