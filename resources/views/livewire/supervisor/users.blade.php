<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($mode === 'index')
        <div class="pf-item">
            <div class="row">
                <div class="col-12 col-lg-12 col-xl-4">
                    <div class="ds-title">
                        <h2 class="mb-2">Usuários</h2>
                        <p>Cadastre, altere ou edite</p>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-xl-8">
                    <ul class="ds-sort ds-sort2 text-xl-end">
                        <li>
                            <form wire:submit.prevent="render" class="needs-validation" novalidate>
                                <input
                                    type="search"
                                    class="form-control"
                                    wire:model.defer="search"
                                    placeholder="Pesquisar usuário"
                                    required
                                >
                                <button type="submit" class="icon">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </li>
                        <li class="active">
                            <button wire:click="create" class="btn-blk">
                                <i class="bi bi-person-plus-fill"></i>
                                Adicionar usuário
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <table class="table align-middle table-ds">
                <thead>
                <tr>
                    <th scope="col">Usuário</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Equipe</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <th scope="row">
                            <img src="{{ $user->avatar }}" alt="" class="img-fluid">
                            <span class="tb-bet">{{ $user->name }}</span>
                        </th>
                        <td>{{ $user->email }}</td>
                        <td>Nome da equipe 1</td>
                        <td>
                            <button wire:click="edit({{ $user->id }})" title="Editar">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Nenhum usuário encontrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <ul class="tb-page text-lg-end">
                <li>Mostrando {{ $users->firstItem() }}-{{ $users->lastItem() }} de {{ $users->total() }}</li>
                <li>Itens por página:
                    <input
                        type="number"
                        class="form-control"
                        wire:model="perPage"
                        style="width: 60px; display:inline-block;"
                    >
                </li>
                <li>
                    {{ $users->links() }}
                </li>
            </ul>
        </div>
    @elseif ($mode === 'create')
        <div class="pf-item">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a wire:click="backToList" style="cursor:pointer">Configurações</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a wire:click="backToList" style="cursor:pointer">Usuários</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">adicionar novo usuário</li>
                </ol>
            </nav>
            <div class="ds-title">
                <h2 class="mb-2">
                    <a wire:click="backToList" class="link" style="cursor:pointer">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                    Adicionar novo usuário
                </h2>
            </div>
            <form wire:submit.prevent="store" class="needs-validation row gx-3" novalidate>
                <div class="col-12 col-lg-6 col-xl-6">
                    <div class="ds-grap">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-4">
                                <div class="pf-image">
                                    @if ($profile_image)
                                        <img
                                            src="{{ $profile_image->temporaryUrl() }}"
                                            alt="New Photo Preview"
                                            class="img-fluid"
                                        >
                                    @else
                                        <i class="bi bi-person-square"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-lg-12 col-xl-8">
                                <div class="pf-meta mb-3">
                                    <button
                                        type="button"
                                        class="pf-upload mb-2"
                                        onclick="document.getElementById('user_create_photo').click()"
                                    >
                                        <i class="bi bi-upload"></i> Selecione um arquivo
                                    </button>
                                    <p>JPG, PNG, JPEG / 500kb / 500x500</p>
                                </div>
                                <input
                                    type="file"
                                    id="user_create_photo"
                                    style="display:none"
                                    wire:model="profile_image"
                                >
                                @error('profile_image')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="fm-item">
                            <label class="form-label">Tipo de usuário<span>*</span></label>
                            <select class="form-select" wire:model="user_type">
                                <option value="Atendente">Atendente</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Admin">Admin</option>
                            </select>
                            @error('user_type')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="fm-item">
                            <label class="form-label">Nome e sobrenome<span>*</span></label>
                            <input type="text" class="form-control" wire:model="name" required>
                            @error('name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="fm-item">
                            <label class="form-label">E-mail<span>*</span></label>
                            <input type="email" class="form-control" wire:model="email" required>
                            @error('email')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="fm-item mb-0">
                            <label class="form-label">Tipo de Contrato<span>*</span></label>
                            <input type="text" class="form-control" wire:model="contract_type" required>
                            @error('contract_type')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <p class="mt-2">Horário de Brasilia (-03:00)</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-6">
                    <div class="ds-grap">
                        <div class="fm-item">
                            <h2>Equipes de trabalho</h2>
                            <select class="form-select">
                                <option value="">Selecione</option>
                                <option value="1">Equipe Alfa</option>
                            </select>
                        </div>
                        <div class="fm-item mb-0">
                            <label class="form-label">Equipes adicionadas (0)</label>
                            <p>Nenhuma equipe adicionada</p>
                        </div>
                    </div>
                    <div class="ds-grap">
                        <h2>Clientes Conectados</h2>
                        <div class="fm-item mb-0">
                            <select class="form-select">
                                <option value="">Selecione</option>
                                <option value="1">Cliente X</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn-fm" type="submit">
                        <i class="bi bi-person-add"></i>
                        Adicionar usuário
                    </button>
                    <button type="button" wire:click="backToList" class="btn btn-secondary">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    @elseif ($mode === 'edit')
        <div class="pf-item">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a wire:click="backToList" style="cursor:pointer">Configurações</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a wire:click="backToList" style="cursor:pointer">Usuários</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Editar usuário</li>
                </ol>
            </nav>
            <div class="ds-title">
                <h2 class="mb-2">
                    <a wire:click="backToList" class="link" style="cursor:pointer">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                    Editar usuário
                </h2>
            </div>
            <form wire:submit.prevent="update" class="needs-validation row gx-3" novalidate>
                <div class="col-12 col-lg-6 col-xl-6">
                    <div class="ds-grap">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-4">
                                <div class="pf-image pf-image2">
                                    @if ($profile_image)
                                        <img src="{{ $profile_image->temporaryUrl() }}" alt="" class="img-fluid">
                                    @else
                                        <img src="{{ $avatar }}" alt="" class="img-fluid">
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-lg-12 col-xl-8">
                                <div class="pf-meta mb-3">
                                    <button
                                        type="button"
                                        class="pf-upload mb-2"
                                        onclick="document.getElementById('user_edit_photo').click()"
                                    >
                                        <i class="bi bi-upload"></i> Selecione um arquivo
                                    </button>
                                    <p>JPG, PNG, JPEG / 500kb / 500x500</p>
                                </div>
                                <input
                                    type="file"
                                    id="user_edit_photo"
                                    style="display:none"
                                    wire:model="profile_image"
                                >
                                @error('profile_image')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="fm-item">
                            <label class="form-label">Tipo de usuário<span>*</span></label>
                            <select class="form-select" wire:model="user_type">
                                <option value="Atendente">Atendente</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Admin">Admin</option>
                            </select>
                            @error('user_type')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="fm-item">
                            <label class="form-label">Nome e sobrenome<span>*</span></label>
                            <input type="text" class="form-control" wire:model="name" required>
                            @error('name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="fm-item">
                            <label class="form-label">E-mail<span>*</span></label>
                            <input type="email" class="form-control" wire:model="email" required>
                            @error('email')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="fm-item mb-0">
                            <label class="form-label">Tipo de Contrato<span>*</span></label>
                            <input type="text" class="form-control" wire:model="contract_type" required>
                            @error('contract_type')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <p class="mt-2">Horário de Brasilia (-03:00)</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-6">
                    <div class="ds-grap">
                        <div class="fm-item">
                            <h2>Equipe(s) de trabalho</h2>
                            <select class="form-select">
                                <option>Selecione</option>
                                <option value="1">Equipe Alfa</option>
                            </select>
                        </div>
                        <div class="fm-item mb-0">
                            <label class="form-label">Equipe(s) adicionadas (2)</label>
                            <div class="row">
                                <div class="col-12 col-lg-12 col-xl-6">
                                    <p>Equipe Alfa</p>
                                </div>
                                <div class="col-12 col-lg-12 col-xl-6 text-xl-end">
                                    <button type="button" class="pf-upload mb-0">
                                        <i class="bi bi-clipboard2-x"></i> Remover
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-grap">
                        <h2>Clientes Conectados</h2>
                        <ul class="bet-list">
                            <li>
                                <img src="{{asset('asset/img/Logo-Bet.jpg')}}" alt="" class="img-fluid">
                                <span class="tb-bet">7k.bet.br</span>
                                <button type="button" class="pf-upload">
                                    <i class="bi bi-clipboard2-x"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn-fm" type="submit">
                        <i class="bi bi-person-add"></i>
                        Editar usuário
                    </button>
                    <button type="button" wire:click="backToList" class="btn btn-secondary">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
