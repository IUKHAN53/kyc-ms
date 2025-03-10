<div>
    <!-- Optional success message -->
    @if (session()->has('success'))
        <div class="alert alert-success mb-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="pf-item pf-user mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-3 col-lg-4 col-xl-3">
                {{-- If user picks a new file, show temporary preview; otherwise show accessor-based avatar --}}
                @if ($profile_image)
                    <img src="{{ $profile_image->temporaryUrl() }}" alt="New Preview" class="img-fluid">
                @else
                    <img src="{{ $avatar }}" alt="User Avatar" class="img-fluid">
                @endif
            </div>

            <div class="col-12 col-md-9 col-lg-8 col-xl-9">
                <h2>{{ $name }}</h2>
                <p>{{$role}}</p>

                <!-- Button triggers hidden file input -->
                <button class="pf-upload"
                        type="button"
                        onclick="document.getElementById('profile_image_input').click()">
                    <i class="bi bi-person-bounding-box"></i> Alterar foto
                </button>

                <!-- Hidden file input -->
                <input
                    type="file"
                    style="display:none"
                    id="profile_image_input"
                    wire:model="profile_image"
                >
                @error('profile_image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-4">
                    <h3>Tipo de Contrato</h3>
                    <p class="mb-sm-0">Prestador de Serviço</p>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <h3>Equipe</h3>
                    <p class="mb-sm-0">Alpha</p>
                </div>
            </div>
        </div>
    </div>

    <div class="pf-item pf-form">
        <h2 class="mb-4">Login e senha</h2>
        <form wire:submit.prevent="updateProfile" class="needs-validation" novalidate>
            <!-- EMAIL (read-only) -->
            <div class="fm-item3 mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email"
                       wire:model.defer="email"
                       readonly>
                <p>Seu e-mail não pode ser alterado</p>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- NAME -->
            <div class="fm-item3 mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name"
                       wire:model.defer="name">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="fm-item3 mb-3">
                <label for="password" class="form-label">Senha</label>
                <!-- Change to wire:model="password" for immediate updates -->
                <input type="password"
                       class="form-control"
                       id="password"
                       wire:model="password">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- REAL-TIME VALIDATION HINTS (green if pass, grey if fail) -->
            <div class="valid-pass mb-4">
                <h3>Sua senha deve conter:</h3>
                <ul>
                    <li class="{{ $this->passwordLengthOk ? 'text-success' : 'text-muted' }}">
                        <i class="bi {{ $this->passwordLengthOk ? 'bi-check' : 'bi-x' }}"></i>
                        Mais de 8 caracteres
                    </li>
                    <li class="{{ $this->passwordUppercaseOk ? 'text-success' : 'text-muted' }}">
                        <i class="bi {{ $this->passwordUppercaseOk ? 'bi-check' : 'bi-x' }}"></i>
                        Letras maiúsculas (A-Z)
                    </li>
                    <li class="{{ $this->passwordLowercaseOk ? 'text-success' : 'text-muted' }}">
                        <i class="bi {{ $this->passwordLowercaseOk ? 'bi-check' : 'bi-x' }}"></i>
                        Letras minúsculas (a-z)
                    </li>
                    <li class="{{ $this->passwordNumberOk ? 'text-success' : 'text-muted' }}">
                        <i class="bi {{ $this->passwordNumberOk ? 'bi-check' : 'bi-x' }}"></i>
                        Números (0-9)
                    </li>
                    <li class="{{ $this->passwordSpecialOk ? 'text-success' : 'text-muted' }}">
                        <i class="bi {{ $this->passwordSpecialOk ? 'bi-check' : 'bi-x' }}"></i>
                        Caracteres especiais
                    </li>
                </ul>
            </div>

            <div class="fm-item3">
                <button type="submit" class="btn-fm">Salvar alterações</button>
            </div>
        </form>
    </div>
</div>
