<?php

namespace App\Livewire\Supervisor;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Teams extends Component
{
    use WithPagination;

    public $mode = 'index';

    public $currentTab = 1;

    public $search = '';

    public $perPage = 10;

    public $teamId;

    public $name;

    public $supervisor_id;

    public $daily_goal;

    public $weekly_goal;

    public $monthly_goal;

    public $userSearch = '';

    public $availableUsers = [];

    public $selectedUsers = [];

    public $teamUsers = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected $rules = [
        'name' => 'required|string|min:3',
        'supervisor_id' => 'nullable|exists:users,id',
        'daily_goal' => 'nullable|integer',
        'weekly_goal' => 'nullable|integer',
        'monthly_goal' => 'nullable|integer',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        if ($this->mode === 'index') {
            $teams = Team::withCount('users')
                ->with('supervisor')
                ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%')
                )
                ->orderBy('id', 'desc')
                ->paginate($this->perPage);

            return view('livewire.supervisor.teams', [
                'teams' => $teams,
            ])->layout('layouts.sidebars.supervisor-sidebar');
        }

        return view('livewire.supervisor.teams')->layout('layouts.sidebars.supervisor-sidebar');
    }

    public function updatedUserSearch()
    {
        if ($this->currentTab === 2) {
            $this->loadAvailableUsers();
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->mode = 'create';
    }

    public function edit($id)
    {
        $this->resetForm();
        $this->mode = 'edit';

        $team = Team::with('users')->findOrFail($id);
        $this->teamId = $team->id;
        $this->name = $team->name;
        $this->supervisor_id = $team->supervisor_id;
        $this->daily_goal = $team->daily_goal;
        $this->weekly_goal = $team->weekly_goal;
        $this->monthly_goal = $team->monthly_goal;

        $this->teamUsers = $team->users->pluck('id')->toArray();
        $this->selectedUsers = $this->teamUsers;
    }

    public function backToList()
    {
        $this->resetForm();
        $this->mode = 'index';
    }

    public function saveTab1()
    {
        $this->validate();

        if ($this->mode === 'create' && ! $this->teamId) {
            $team = Team::create([
                'name' => $this->name,
                'supervisor_id' => $this->supervisor_id,
                'daily_goal' => $this->daily_goal,
                'weekly_goal' => $this->weekly_goal,
                'monthly_goal' => $this->monthly_goal,
            ]);
            $this->teamId = $team->id;
        } else {
            $team = Team::findOrFail($this->teamId);
            $team->update([
                'name' => $this->name,
                'supervisor_id' => $this->supervisor_id,
                'daily_goal' => $this->daily_goal,
                'weekly_goal' => $this->weekly_goal,
                'monthly_goal' => $this->monthly_goal,
            ]);
        }

        $this->currentTab = 2;
        $this->loadAvailableUsers();
    }

    public function saveTab2()
    {
        if (! $this->teamId) {
            return;
        }

        $team = Team::findOrFail($this->teamId);
        DB::transaction(function () use ($team) {
            $team->users()->sync($this->selectedUsers);
        });

        if ($this->mode === 'create') {
            session()->flash('success', 'Equipe cadastrada com sucesso!');
        } else {
            session()->flash('success', 'Equipe atualizada com sucesso!');
        }

        $this->resetForm();
        $this->mode = 'index';
    }

    public function addUserToSelection($userId)
    {
        if (! in_array($userId, $this->selectedUsers)) {
            $this->selectedUsers[] = $userId;
        }
    }

    public function removeUserFromSelection($userId)
    {
        $this->selectedUsers = array_diff($this->selectedUsers, [$userId]);
    }

    private function loadAvailableUsers()
    {
        $this->availableUsers = User::when($this->userSearch, function ($q) {
            $q->where('name', 'like', '%'.$this->userSearch.'%')
                ->orWhere('email', 'like', '%'.$this->userSearch.'%');
        })
            ->orderBy('id', 'desc')
            ->get();
    }

    private function resetForm()
    {
        $this->reset([
            'teamId', 'name', 'supervisor_id', 'daily_goal', 'weekly_goal', 'monthly_goal',
            'selectedUsers', 'teamUsers', 'availableUsers', 'userSearch', 'currentTab',
        ]);
        $this->currentTab = 1;
    }
}
