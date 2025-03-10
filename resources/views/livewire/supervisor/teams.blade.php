<div x-data="{ currentTab: @entangle('currentTab') }">
    @if (session()->has('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($mode === 'index')
        <div class="pf-item pf-form">
            <div class="row">
                <div class="col-12 col-lg-12 col-xl-4">
                    <div class="ds-title">
                        <h2>Equipes</h2>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-xl-8">
                    <ul class="ds-sort ds-sort2 text-xl-end">
                        <li class="active">
                            <button wire:click="create">
                                <i class="bi bi-person-plus-fill"></i>
                                Adicionar nova equipe
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <table class="table align-middle table-ds">
                <thead>
                <tr>
                    <th>Equipe</th>
                    <th>Usuários</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($teams as $team)
                    <tr>
                        <th scope="row" class="per-name">
                            <h4>{{ $team->name }}</h4>
                            <p>
                                <i class="bi bi-person-square"></i>
                                @if ($team->supervisor)
                                    {{ $team->supervisor->name }} (Supervisor)
                                @endif
                                <br>
                                {{ $team->users_count }} usuários
                            </p>
                        </th>
                        <td>
                            @php
                                $preview = $team->users->take(4);
                                $countAll = $team->users_count;
                            @endphp
                            <ul class="per-list">
                                @foreach($preview as $u)
                                    <li>
                                        <img src="{{ $u->avatar ?? 'access/img/user2.png' }}"
                                             alt=""
                                             class="img-fluid"
                                        >
                                    </li>
                                @endforeach
                                @if($countAll > 4)
                                    <li><span>+{{ $countAll - 4 }}</span></li>
                                @endif
                            </ul>
                        </td>
                        <td>
                            <button class="per-btn">
                                <i class="bi bi-person-plus"></i>
                                Adicionar usuário
                            </button>
                        </td>
                        <td>
                            <button wire:click="edit({{ $team->id }})">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Nenhuma equipe encontrada.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <ul class="tb-page text-lg-end">
                <li>
                    Mostrando {{ $teams->firstItem() }}-{{ $teams->lastItem() }}
                    de {{ $teams->total() }}
                </li>
                <li>
                    Itens por página:
                    <input
                        type="number"
                        class="form-control"
                        style="width:60px; display:inline-block;"
                        wire:model="perPage"
                    >
                </li>
                <li>
                    {{ $teams->links() }}
                </li>
            </ul>
        </div>
    @elseif ($mode === 'create' || $mode === 'edit')
        <div class="pf-item">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a wire:click="backToList" style="cursor:pointer">Configurações</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a wire:click="backToList" style="cursor:pointer">Equipes</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if($mode === 'create')
                            Adicionar nova equipe
                        @else
                            Editar equipe
                        @endif
                    </li>
                </ol>
            </nav>
            <div class="ds-title">
                <h2 class="mb-2">
                    <a wire:click="backToList" class="link" style="cursor:pointer">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                    @if($mode === 'create')
                        Adicionar nova equipe
                    @else
                        Editar equipe
                    @endif
                </h2>
                <ul class="pf-tab">
                    <li :class="{ 'active': currentTab == 1 }">
                        <a @click="currentTab=1">Informações gerais</a>
                    </li>
                    <li :class="{ 'active': currentTab == 2 }">
                        <a @click="currentTab=2">Usuários</a>
                    </li>
                </ul>
            </div>

            <!-- TAB 1 -->
            <div x-show="currentTab == 1" style="display:none;">
                <form wire:submit.prevent="saveTab1" class="needs-validation" novalidate>
                    <div class="ds-grap ds-grap3 row gx-3">
                        <div class="col-12 col-lg-6 fm-item3">
                            <label class="form-label">Nome do equipe<span>*</span></label>
                            <input
                                type="text"
                                class="form-control"
                                wire:model="name"
                                required
                            >
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-12 col-lg-6 fm-item3">
                            <label class="form-label">Supervisor (role=supervisor)</label>
                            <select class="form-select" wire:model="supervisor_id">
                                <option value="">Selecione</option>
                                @foreach(\App\Models\User::where('role','supervisor')->get() as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->name }} ({{ $sup->email }})</option>
                                @endforeach
                            </select>
                            @error('supervisor_id') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-12 col-lg-4 fm-item3">
                            <label class="form-label">Meta diária</label>
                            <input
                                type="number"
                                class="form-control"
                                wire:model="daily_goal"
                            >
                            @error('daily_goal') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-12 col-lg-4 fm-item3">
                            <label class="form-label">Meta semanal</label>
                            <input
                                type="number"
                                class="form-control"
                                wire:model="weekly_goal"
                            >
                            @error('weekly_goal') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-12 col-lg-4 fm-item3">
                            <label class="form-label">Meta mensal</label>
                            <input
                                type="number"
                                class="form-control"
                                wire:model="monthly_goal"
                            >
                            @error('monthly_goal') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <button class="btn-fm">
                        @if($mode === 'create')
                            Próximo
                        @else
                            Salvar e ir para Usuários
                        @endif
                    </button>
                </form>
            </div>

            <!-- TAB 2 -->
            <div x-show="currentTab == 2" style="display:none;">
                <div class="ds-grap">
                    <div class="ds-title ds-title2">
                        <h2>Adicionar novos usuários</h2>
                    </div>
                    <ul class="ds-sort ds-sort2 ds-sort3">
                        <li>
                            <input
                                type="search"
                                class="form-control w-100"
                                placeholder="Pesquisar usuário"
                                wire:model.debounce.300ms="userSearch"
                            >
                        </li>
                    </ul>
                    <div class="fm-item3 mb-0">
                        <label class="form-label">Usuários cadastrados</label>
                        <div class="row gx-2">
                            @foreach($availableUsers as $usr)
                                @if(! in_array($usr->id, $selectedUsers))
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="fm-plist">
                                            <img
                                                src="{{ $usr->avatar ?? 'access/img/user2.png' }}"
                                                alt=""
                                                class="img-fluid"
                                            >
                                            <p>{{ $usr->name }}</p>
                                            <button
                                                type="button"
                                                wire:click="addUserToSelection({{ $usr->id }})"
                                            >
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="ds-grap">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-12 col-xl-7">
                            <div class="ds-title ds-title2">
                                <h2>Usuários adicionados à equipe ({{ count($selectedUsers) }})</h2>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 col-xl-5">
                            <ul class="ds-sort ds-sort2 text-xl-end">
                                <li>
                                    <input
                                        type="search"
                                        class="form-control"
                                        wire:model.debounce.300ms="userSearch"
                                        placeholder="Pesquisar usuário"
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                    <table class="table align-middle table-ds">
                        <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Equipe</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($availableUsers as $u)
                            @if(in_array($u->id, $selectedUsers))
                                <tr>
                                    <th scope="row">
                                        <img
                                            src="{{ $u->avatar ?? 'access/img/user2.png' }}"
                                            alt=""
                                            class="img-fluid"
                                        >
                                        <span class="tb-bet">{{ $u->name }}</span>
                                    </th>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $name }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            wire:click="removeUserFromSelection({{ $u->id }})"
                                        >
                                            <i class="bi bi-clipboard2-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <button class="btn-fm" wire:click="saveTab2">
                    @if($mode === 'create')
                        Cadastrar nova equipe
                    @else
                        Atualizar equipe
                    @endif
                </button>
            </div>
        </div>
    @endif
</div>
