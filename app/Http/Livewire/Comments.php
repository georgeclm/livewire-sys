<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
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
    public $userId;
    public $receiver;

    protected $listeners = [
        'fileUpload' => 'handleFileUpload',
        'ticketSelected',
        'userSelected'
    ];


    public function ticketSelected($ticketIdSelected)
    {
        $this->ticketId = $ticketIdSelected;
    }

    public function userSelected($userIdSelected)
    {
        $this->userId = $userIdSelected;
        $this->receiver = User::findOrFail($this->userId);
        $this->emit('scrollToBottom');
    }

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function render()
    {
        $dates = Chat::whereIn('sender', [auth()->id(), $this->userId])->whereIn('receiver', [auth()->id(), $this->userId])
            ->oldest()
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d'); // grouping by months
            });
        // dd($dates);
        $this->emit('refreshTicketView');
        return view('livewire.comments', compact('dates'));
    }
    // this updated function will always be called in updated validation real time check the newComment Field
    public function updated($field)
    {
        $this->validateOnly($field, ['newComment' => ['required', 'max:255']]);
    }

    public function addComment()
    {
        $image = $this->storeImage();
        Chat::create([
            'sender' => auth()->id(),
            'receiver' => $this->userId,
            'image' => $image,
            'text' => $this->newComment
        ]);
        // frontend view data
        // $this->comments->prepend($createdComment);
        $this->newComment = '';
        $this->image = '';
        $this->emit('scrollToBottom');
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
