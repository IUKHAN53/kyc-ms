<x-app-layout>
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-4">
            <div class="ds-title">
                <h2>Supervisores</h2>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-8">
            <ul class="ds-sort text-xl-end">
                <li>Filtrar por:
                    <button>
                        <i class="bi bi-search"></i> Nome</button>
                </li>
                <li class="active">
                    <button data-bs-toggle="offcanvas" data-bs-target="#supervisorCreate" aria-controls="supervisorCreate">
                        <i class="bi bi-plus"></i> Criar Supervisor
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger my-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Table of Supervisors -->
    <div class="table-responsive">
        <table class="table align-middle table-ds">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Profile Image</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($supervisors as $supervisor)
                    <tr>
                        <td>{{ $supervisor->name }}</td>
                        <td>{{ $supervisor->email }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $supervisor->profile_image) }}" alt="{{ $supervisor->name }}" class="img-fluid" style="max-width: 100px;">
                        </td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn-edit-supervisor btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#supervisorEdit" aria-controls="supervisorEdit"
                                data-supervisor-id="{{ $supervisor->id }}"
                                data-supervisor-name="{{ $supervisor->name }}"
                                data-supervisor-email="{{ $supervisor->email }}"
                                data-supervisor-group="{{ $supervisor->group_id }}"
                                data-supervisor-profile="{{ asset('storage/' . $supervisor->profile_image) }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <!-- Delete Button -->
                            <form action="{{ route('admin.supervisors.destroy', $supervisor->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Tem certeza que deseja deletar este supervisor?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Nenhum supervisor cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination (if using pagination) -->
        @if(method_exists($supervisors, 'links'))
            <div class="d-flex justify-content-end">
                {{ $supervisors->links() }}
            </div>
        @endif
    </div>

    <!-- Create Supervisor Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="supervisorCreate" aria-labelledby="supervisorCreateLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="supervisorCreateLabel">Criar Supervisor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('admin.supervisors.store') }}" method="POST" class="needs-validation row g-3" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="col-12 fm-item2">
                    <label for="supervisorName" class="form-label">Nome<span>*</span></label>
                    <input type="text" class="form-control" id="supervisorName" name="name" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="supervisorEmail" class="form-label">Email<span>*</span></label>
                    <input type="email" class="form-control" id="supervisorEmail" name="email" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="supervisorPassword" class="form-label">Senha<span>*</span></label>
                    <input type="password" class="form-control" id="supervisorPassword" name="password" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="supervisorPasswordConfirmation" class="form-label">Confirmar Senha<span>*</span></label>
                    <input type="password" class="form-control" id="supervisorPasswordConfirmation" name="password_confirmation" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="supervisorGroup" class="form-label">Group<span>*</span></label>
                    <select class="form-select" id="supervisorGroup" name="group_id" required>
                        <option value="">Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 fm-item2">
                    <label for="supervisorProfileImage" class="form-label">Profile Image<span>*</span></label>
                    <input type="file" class="form-control" id="supervisorProfileImage" name="profile_image" accept="image/*" required>
                </div>
                <div class="fm-item2 fm-button col-12">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancelar</button>
                    <button type="submit" class="btn-fm">Salvar Supervisor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Supervisor Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="supervisorEdit" aria-labelledby="supervisorEditLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="supervisorEditLabel">Editar Supervisor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="editSupervisorForm" method="POST" class="needs-validation row g-3" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" name="supervisor_id" id="supervisor_id">
                <div class="col-12 fm-item2">
                    <label for="editSupervisorName" class="form-label">Nome<span>*</span></label>
                    <input type="text" class="form-control" id="editSupervisorName" name="name" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="editSupervisorEmail" class="form-label">Email<span>*</span></label>
                    <input type="email" class="form-control" id="editSupervisorEmail" name="email" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="editSupervisorPassword" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="editSupervisorPassword" name="password" placeholder="Deixe em branco para manter atual">
                </div>
                <div class="col-12 fm-item2">
                    <label for="editSupervisorPasswordConfirmation" class="form-label">Confirmar Senha</label>
                    <input type="password" class="form-control" id="editSupervisorPasswordConfirmation" name="password_confirmation" placeholder="Deixe em branco para manter atual">
                </div>
                <div class="col-12 fm-item2">
                    <label for="editSupervisorGroup" class="form-label">Group<span>*</span></label>
                    <select class="form-select" id="editSupervisorGroup" name="group_id" required>
                        <option value="">Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 fm-item2">
                    <label for="editSupervisorProfileImage" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="editSupervisorProfileImage" name="profile_image" accept="image/*">
                </div>
                <div class="col-12 fm-item2">
                    <label class="form-label">Current Profile Image</label>
                    <div>
                        <img id="editSupervisorProfileImagePreview" src="" alt="Supervisor Profile" class="img-fluid" style="max-width: 150px;">
                    </div>
                </div>
                <div class="fm-item2 fm-button col-12">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancelar</button>
                    <button type="submit" class="btn-fm">Atualizar Supervisor</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Populate the Edit Supervisor Offcanvas with the current supervisor data.
                var supervisorEditOffcanvas = document.getElementById('supervisorEdit');
                supervisorEditOffcanvas.addEventListener('show.bs.offcanvas', function (event) {
                    var button = event.relatedTarget;
                    var supervisorId = button.getAttribute('data-supervisor-id');
                    var supervisorName = button.getAttribute('data-supervisor-name');
                    var supervisorEmail = button.getAttribute('data-supervisor-email');
                    var supervisorGroup = button.getAttribute('data-supervisor-group'); // New attribute for group id
                    var supervisorProfile = button.getAttribute('data-supervisor-profile');

                    document.getElementById('supervisor_id').value = supervisorId;
                    document.getElementById('editSupervisorName').value = supervisorName;
                    document.getElementById('editSupervisorEmail').value = supervisorEmail;
                    document.getElementById('editSupervisorGroup').value = supervisorGroup;
                    document.getElementById('editSupervisorProfileImagePreview').src = supervisorProfile;

                    var editForm = document.getElementById('editSupervisorForm');
                    editForm.action = "{{ url('admin/supervisors') }}/" + supervisorId;
                });

                // Update the image preview when a new file is selected in the edit modal.
                var editSupervisorProfileImageInput = document.getElementById('editSupervisorProfileImage');
                editSupervisorProfileImageInput.addEventListener('change', function(event) {
                    var input = event.target;
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('editSupervisorProfileImagePreview').src = e.target.result;
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>
