<?php

namespace App\Livewire\Admin\Configurations;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ClientsComponent extends Component
{
    use WithFileUploads, WithPagination;

    public $mode = 'index'; // 'index'|'create'|'edit'

    public $search = '';

    public $perPage = 10;

    public $clientId;

    public $name;

    public $conversion_value;

    public $image;         // For new file uploads

    public $existingImage; // Path in DB, to show in edit if it exists

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function rules()
    {
        return [
            'name' => 'required|string|min:2',
            'conversion_value' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048', // 2MB max
        ];
    }

    public function render()
    {
        if ($this->mode === 'index') {
            $clients = Client::query()
                ->when($this->search, function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                })
                ->orderBy('id', 'desc')
                ->paginate($this->perPage);

            return view('livewire.admin.configurations.clients-component', [
                'clients' => $clients,
            ])->layout('layouts.admin-configurations');
        }

        return view('livewire.admin.configurations.clients-component')->layout('layouts.admin-configurations');
    }

    public function create()
    {
        $this->resetForm();
        $this->mode = 'create';
    }

    public function store()
    {
        $this->validate();

        $client = new Client;
        $client->name = $this->name;
        $client->conversion_value = $this->conversion_value;

        if ($this->image) {
            $path = $this->image->store('client_images', 'public');
            $client->image = $path;
        }

        $client->save();

        session()->flash('success', 'Cliente cadastrado com sucesso!');
        $this->resetForm();
        $this->mode = 'index';
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);

        $this->clientId = $client->id;
        $this->name = $client->name;
        $this->conversion_value = $client->conversion_value;
        $this->existingImage = $client->image; // store path if you want to show preview

        $this->image = null; // new upload is optional
        $this->mode = 'edit';
    }

    public function update()
    {
        $this->validate();

        $client = Client::findOrFail($this->clientId);
        $client->name = $this->name;
        $client->conversion_value = $this->conversion_value;

        if ($this->image) {
            $path = $this->image->store('client_images', 'public');
            $client->image = $path;
        }

        $client->save();

        session()->flash('success', 'Cliente atualizado com sucesso!');
        $this->resetForm();
        $this->mode = 'index';
    }

    public function backToList()
    {
        $this->resetForm();
        $this->mode = 'index';
    }

    private function resetForm()
    {
        $this->reset([
            'clientId', 'name', 'conversion_value',
            'image', 'existingImage',
        ]);
    }
}
