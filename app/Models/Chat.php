<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function the_sender()
    {
        return $this->belongsTo(User::class, 'sender');
    }
    public function the_receiver()
    {
        return $this->belongsTo(User::class, 'receiver');
    }
}
