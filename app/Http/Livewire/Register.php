<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Register extends Component
{

    public $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function submit()
    {
        $this->validate([
            'form.email'    => 'required|email|unique:users,email',
            'form.name'     => 'required|unique:users,name',
            'form.password' => 'required|confirmed',
        ]);

        User::create($this->form);
        Auth::attempt(['email' => $this->form['email'], 'password' => $this->form['password']], true);
        return redirect(route('home'));
    }

    public function render()
    {
        return view('livewire.register');
    }
}
