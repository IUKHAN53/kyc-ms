<x-app-layout>
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-4">
            <div class="ds-title">
                <h2>Auditors</h2>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-8">
            <ul class="ds-sort text-xl-end">
                <li>Filter by:
                    <button><i class="bi bi-search"></i> Name</button>
                </li>
                <li class="active">
                    <button data-bs-toggle="offcanvas" data-bs-target="#auditorCreate" aria-controls="auditorCreate">
                        <i class="bi bi-plus"></i> Create Auditor
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

    <!-- Table of Auditors -->
    <div class="table-responsive">
        <table class="table align-middle table-ds">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Profile Image</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($auditors as $auditor)
                    <tr>
                        <td>{{ $auditor->name }}</td>
                        <td>{{ $auditor->email }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $auditor->profile_image) }}" alt="{{ $auditor->name }}" class="img-fluid" style="max-width: 100px;">
                        </td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn-edit-auditor btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#auditorEdit" aria-controls="auditorEdit"
                                data-auditor-id="{{ $auditor->id }}"
                                data-auditor-name="{{ $auditor->name }}"
                                data-auditor-email="{{ $auditor->email }}"
                                data-auditor-profile="{{ asset('storage/' . $auditor->profile_image) }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <!-- Delete Button -->
                            <form action="{{ route('admin.auditors.destroy', $auditor->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this auditor?');">
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
                        <td colspan="4" class="text-center">No auditors available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if(method_exists($auditors, 'links'))
            <div class="d-flex justify-content-end">
                {{ $auditors->links() }}
            </div>
        @endif
    </div>

    <!-- Create Auditor Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="auditorCreate" aria-labelledby="auditorCreateLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="auditorCreateLabel">Create Auditor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('admin.auditors.store') }}" method="POST" class="needs-validation row g-3" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="col-12 fm-item2">
                    <label for="auditorName" class="form-label">Name<span>*</span></label>
                    <input type="text" class="form-control" id="auditorName" name="name" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="auditorEmail" class="form-label">Email<span>*</span></label>
                    <input type="email" class="form-control" id="auditorEmail" name="email" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="auditorPassword" class="form-label">Password<span>*</span></label>
                    <input type="password" class="form-control" id="auditorPassword" name="password" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="auditorPasswordConfirmation" class="form-label">Confirm Password<span>*</span></label>
                    <input type="password" class="form-control" id="auditorPasswordConfirmation" name="password_confirmation" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="auditorProfileImage" class="form-label">Profile Image<span>*</span></label>
                    <input type="file" class="form-control" id="auditorProfileImage" name="profile_image" accept="image/*" required>
                </div>
                <div class="fm-item2 fm-button col-12">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn-fm">Save Auditor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Auditor Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="auditorEdit" aria-labelledby="auditorEditLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="auditorEditLabel">Edit Auditor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="editAuditorForm" method="POST" class="needs-validation row g-3" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" name="auditor_id" id="auditor_id">
                <div class="col-12 fm-item2">
                    <label for="editAuditorName" class="form-label">Name<span>*</span></label>
                    <input type="text" class="form-control" id="editAuditorName" name="name" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="editAuditorEmail" class="form-label">Email<span>*</span></label>
                    <input type="email" class="form-control" id="editAuditorEmail" name="email" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="editAuditorPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="editAuditorPassword" name="password" placeholder="Leave blank to keep current">
                </div>
                <div class="col-12 fm-item2">
                    <label for="editAuditorPasswordConfirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="editAuditorPasswordConfirmation" name="password_confirmation" placeholder="Leave blank to keep current">
                </div>
                <div class="col-12 fm-item2">
                    <label for="editAuditorProfileImage" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="editAuditorProfileImage" name="profile_image" accept="image/*">
                </div>
                <div class="col-12 fm-item2">
                    <label class="form-label">Current Profile Image</label>
                    <div>
                        <img id="editAuditorProfileImagePreview" src="" alt="Auditor Profile" class="img-fluid" style="max-width: 150px;">
                    </div>
                </div>
                <div class="fm-item2 fm-button col-12">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn-fm">Update Auditor</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Populate the Edit Auditor Offcanvas with the current auditor data.
                var auditorEditOffcanvas = document.getElementById('auditorEdit');
                auditorEditOffcanvas.addEventListener('show.bs.offcanvas', function (event) {
                    var button = event.relatedTarget;
                    var auditorId = button.getAttribute('data-auditor-id');
                    var auditorName = button.getAttribute('data-auditor-name');
                    var auditorEmail = button.getAttribute('data-auditor-email');
                    var auditorProfile = button.getAttribute('data-auditor-profile');

                    document.getElementById('auditor_id').value = auditorId;
                    document.getElementById('editAuditorName').value = auditorName;
                    document.getElementById('editAuditorEmail').value = auditorEmail;
                    document.getElementById('editAuditorProfileImagePreview').src = auditorProfile;

                    var editForm = document.getElementById('editAuditorForm');
                    editForm.action = "{{ url('admin/auditors') }}/" + auditorId;
                });

                // Update the image preview when a new file is selected in the edit modal.
                var editAuditorProfileImageInput = document.getElementById('editAuditorProfileImage');
                editAuditorProfileImageInput.addEventListener('change', function(event) {
                    var input = event.target;
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('editAuditorProfileImagePreview').src = e.target.result;
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>
