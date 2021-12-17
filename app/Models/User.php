<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function receive_chats()
    {
        return $this->hasMany(Chat::class, 'receiver');
    }

    public function sender_chats()
    {
        return $this->hasMany(Chat::class, 'sender');
    }

    public function unread_chats($receiver_user_id)
    {
        return Chat::where('sender', $receiver_user_id)->whereIn('receiver', [auth()->id(), $receiver_user_id])
            ->where('read', 0)
            ->count();
    }

    // public function chats($receiver_user_id)
    // {
    //     # code...
    // }
}
