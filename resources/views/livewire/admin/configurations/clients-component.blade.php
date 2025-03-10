<div>
    @if (session()->has('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($mode === 'index')
        <div class="pf-item">
            <div class="row">
                <div class="col-12 col-lg-12 col-xl-4">
                    <div class="ds-title">
                        <h2 class="mb-2">Clientes</h2>
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
                                    placeholder="Pesquisar cliente"
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
                                Adicionar cliente
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <table class="table align-middle table-ds">
                <thead>
                <tr>
                    <th scope="col">Cliente</th>
                    <th scope="col">Conversão consultor</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($clients as $client)
                    <tr>
                        <th scope="row">
                            <img
                                src="{{ $client->image ? asset('storage/'.$client->image) : 'access/img/Logo-Bet.jpg' }}"
                                alt=""
                                class="img-fluid"
                            >
                            <span class="tb-bet">{{ $client->name }}</span>
                        </th>
                        <td>
                            R$ {{ number_format($client->conversion_value ?? 0, 2, ',', '.') }}
                        </td>
                        <td>
                            <button wire:click="edit({{ $client->id }})">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Nenhum cliente encontrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <ul class="tb-page text-lg-end">
            <li>
                Mostrando {{ $clients->firstItem() }}-{{ $clients->lastItem() }}
                de {{ $clients->total() }}
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
                {{ $clients->links() }}
            </li>
        </ul>
    @elseif ($mode === 'create')
        <div class="pf-item">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a wire:click="backToList" style="cursor:pointer">Configurações</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a wire:click="backToList" style="cursor:pointer">Clientes</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">adicionar novo cliente</li>
                </ol>
            </nav>
            <div class="ds-title">
                <h2 class="mb-2">
                    <a wire:click="backToList" class="link" style="cursor:pointer">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                    Adicionar novo cliente
                </h2>
            </div>
            <form wire:submit.prevent="store" class="needs-validation row gx-3" novalidate>
                <div class="col-12 col-lg-7 col-xl-7">
                    <div class="ds-grap">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-4">
                                <div class="pf-image">
                                    @if ($image)
                                        <img
                                            src="{{ $image->temporaryUrl() }}"
                                            alt="Preview"
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
                                        onclick="document.getElementById('client_image_input').click()"
                                    >
                                        <i class="bi bi-upload"></i>
                                        Selecione um arquivo
                                    </button>
                                    <p>JPG, PNG, JPEG / 500kb / 500x500</p>
                                </div>
                                <input
                                    type="file"
                                    id="client_image_input"
                                    style="display:none"
                                    wire:model="image"
                                >
                                @error('image')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="fm-item">
                            <label class="form-label">Nome<span>*</span></label>
                            <input
                                type="text"
                                class="form-control"
                                wire:model="name"
                                required
                            >
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="fm-item mb-0">
                            <label class="form-label">Valor de conversão<span>*</span></label>
                            <input
                                type="text"
                                class="form-control"
                                wire:model="conversion_value"
                                required
                            >
                            @error('conversion_value') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn-fm">
                        <i class="bi bi-person-add"></i>
                        Adicionar cliente
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
                        <a wire:click="backToList" style="cursor:pointer">Clientes</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Editar cliente</li>
                </ol>
            </nav>
            <div class="ds-title">
                <h2 class="mb-2">
                    <a wire:click="backToList" class="link" style="cursor:pointer">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                    Editar cliente
                </h2>
            </div>
            <form wire:submit.prevent="update" class="needs-validation row gx-3" novalidate>
                <div class="col-12 col-lg-7 col-xl-7">
                    <div class="ds-grap">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-4">
                                <div class="pf-image">
                                    @if ($image)
                                        <img
                                            src="{{ $image->temporaryUrl() }}"
                                            alt="Preview"
                                            class="img-fluid"
                                        >
                                    @elseif ($existingImage)
                                        <img
                                            src="{{ asset('storage/'.$existingImage) }}"
                                            alt=""
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
                                        onclick="document.getElementById('client_image_input_edit').click()"
                                    >
                                        <i class="bi bi-upload"></i>
                                        Selecione um arquivo
                                    </button>
                                    <p>JPG, PNG, JPEG / 500kb / 500x500</p>
                                </div>
                                <input
                                    type="file"
                                    id="client_image_input_edit"
                                    style="display:none"
                                    wire:model="image"
                                >
                                @error('image')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="fm-item">
                            <label class="form-label">Nome<span>*</span></label>
                            <input
                                type="text"
                                class="form-control"
                                wire:model="name"
                                required
                            >
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="fm-item mb-0">
                            <label class="form-label">Valor de conversão<span>*</span></label>
                            <input
                                type="text"
                                class="form-control"
                                wire:model="conversion_value"
                                required
                            >
                            @error('conversion_value') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn-fm">
                        <i class="bi bi-person-add"></i>
                        Atualizar cliente
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
