<?php

namespace App\Livewire\Admin\Configurations;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Users extends Component
{
    use WithFileUploads, WithPagination;

    public $mode = 'index';

    public $search = '';

    public $perPage = 10;

    public $userId;

    public $avatar;

    public $name;

    public $email;

    public $role = 'user';

    public $contract_type;

    public $user_type;

    public $profile_image;

    public $teams = [];

    public $clients = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,'.$this->userId,
            'role' => 'required|in:user,supervisor,auditor,admin',
            'contract_type' => 'nullable|string|max:100',
            'user_type' => 'nullable|string|max:50',

            'profile_image' => 'nullable|image|max:2048',
        ];
    }

    public function render()
    {
        if ($this->mode === 'index') {
            $users = User::query()
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%');
                    });
                })
                ->orderBy('id', 'desc')
                ->paginate($this->perPage);

            return view('livewire.admin.configurations.users', [
                'users' => $users,
            ])->layout('layouts.admin-configurations');
        }

        return view('livewire.admin.configurations.users')
            ->layout('layouts.admin-configurations');
    }

    public function create()
    {
        $this->resetForm();
        $this->mode = 'create';
    }

    /**
     * Store a new user.
     */
    public function store()
    {
        $this->validate();

        $user = new User;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;
        // If you have a separate “user_type” column, store it. Otherwise you might store it as role or something else.
        // e.g. $user->user_type = $this->user_type;
        // If you track contract type:
        // $user->contract_type = $this->contract_type;

        // Set a default password or random password for new user
        $user->password = Hash::make('password123');

        // If a profile_image was uploaded, store it
        if ($this->profile_image) {
            $path = $this->profile_image->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        // Potentially attach teams/clients, if you have pivot tables:
        // $user->teams()->sync($this->teams);
        // $user->clients()->sync($this->clients);

        session()->flash('success', 'Novo usuário adicionado com sucesso!');

        // Return to index
        $this->resetForm();
        $this->mode = 'index';
    }

    /**
     * Switch to “edit” mode for a particular user ID.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        // $this->contract_type = $user->contract_type;
        // $this->user_type = $user->user_type;
        $this->profile_image = null;     // new upload
        $this->avatar = $user->avatar;   // from accessor

        // If you have relationships:
        // $this->teams = $user->teams->pluck('id')->toArray();
        // $this->clients = $user->clients->pluck('id')->toArray();

        $this->mode = 'edit';
    }

    /**
     * Update existing user in DB.
     */
    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;
        // $user->contract_type = $this->contract_type;
        // $user->user_type = $this->user_type;

        if ($this->profile_image) {
            $path = $this->profile_image->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        // $user->teams()->sync($this->teams);
        // $user->clients()->sync($this->clients);

        session()->flash('success', 'Usuário atualizado com sucesso!');

        $this->resetForm();
        $this->mode = 'index';
    }

    /**
     * Return to the index (list) mode without saving changes.
     */
    public function backToList()
    {
        $this->resetForm();
        $this->mode = 'index';
    }

    /**
     * Clear form fields so they don't linger after toggling modes.
     */
    private function resetForm()
    {
        $this->reset([
            'userId', 'name', 'email', 'role', 'profile_image',
            'contract_type', 'user_type', 'avatar', 'teams', 'clients',
        ]);
    }
}
