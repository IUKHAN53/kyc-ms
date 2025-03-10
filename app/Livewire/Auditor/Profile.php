<?php

namespace App\Livewire\Auditor;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $name;

    public $email;

    public $password;

    public $role;

    public $profile_image;

    public $avatar;

    public function mount()
    {
        $user = auth()->user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
        $this->role = $user->role;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'password' => [
                'nullable',
                'min:8',
                function ($attribute, $value, $fail) {
                    if ($value && ! preg_match('/[A-Z]/', $value)) {
                        $fail('A senha deve ter pelo menos uma letra maiúscula.');
                    }
                    if ($value && ! preg_match('/[a-z]/', $value)) {
                        $fail('A senha deve ter pelo menos uma letra minúscula.');
                    }
                    if ($value && ! preg_match('/\d/', $value)) {
                        $fail('A senha deve ter pelo menos um número.');
                    }
                    if ($value && ! preg_match('/[^A-Za-z0-9]/', $value)) {
                        $fail('A senha deve ter pelo menos um caractere especial.');
                    }
                },
            ],

            'profile_image' => 'nullable|image|max:2048',
        ];
    }

    #[Computed]
    public function passwordLengthOk()
    {
        return strlen($this->password ?? '') >= 8;
    }

    #[Computed]
    public function passwordUppercaseOk()
    {
        return (bool) preg_match('/[A-Z]/', $this->password ?? '');
    }

    #[Computed]
    public function passwordLowercaseOk()
    {
        return (bool) preg_match('/[a-z]/', $this->password ?? '');
    }

    #[Computed]
    public function passwordNumberOk()
    {
        return (bool) preg_match('/\d/', $this->password ?? '');
    }

    #[Computed]
    public function passwordSpecialOk()
    {
        return (bool) preg_match('/[^A-Za-z0-9]/', $this->password ?? '');
    }

    /**
     * Handle form submission
     */
    public function updateProfile()
    {
        $this->validate();

        $user = auth()->user();

        $user->name = $this->name;
        if ($this->password) {
            $user->password = Hash::make($this->password);
        }
        if ($this->profile_image) {
            $path = $this->profile_image->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->save();
        $this->existingProfileImage = $user->avatar;

        session()->flash('success', 'Perfil atualizado com sucesso!');
    }

    public function render()
    {
        return view('livewire.auditor.profile')
            ->layout('layouts.sidebars.auditor-sidebar');
    }
}
