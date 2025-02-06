<x-app-layout>
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-4">
            <div class="ds-title">
                <h2>Clients</h2>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-8">
            <ul class="ds-sort text-xl-end">
                <li>Filter by:
                    <button><i class="bi bi-search"></i> Name</button>
                </li>
                <li class="active">
                    <button data-bs-toggle="offcanvas" data-bs-target="#clientCreate" aria-controls="clientCreate">
                        <i class="bi bi-plus"></i> Create Client
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

    <!-- Table of Clients -->
    <div class="table-responsive">
        <table class="table align-middle table-ds">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr>
                        <th scope="row">
                            <span class="tb-client">{{ $client->name }}</span>
                        </th>
                        <td>
                            <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}" class="img-fluid">
                        </td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn-edit-client btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#clientEdit" aria-controls="clientEdit"
                                    data-client-id="{{ $client->id }}"
                                    data-client-name="{{ $client->name }}"
                                    data-client-image="{{ asset('storage/' . $client->image) }}">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this client?');">
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
                        <td colspan="3" class="text-center">No clients available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination (if using pagination) -->
        @if(method_exists($clients, 'links'))
            <div class="d-flex justify-content-end">
                {{ $clients->links() }}
            </div>
        @endif
    </div>

    <!-- Create Client Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="clientCreate" aria-labelledby="clientCreateLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="clientCreateLabel">Create Client</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('admin.clients.store') }}" method="POST" class="needs-validation row g-3" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="col-12 fm-item2">
                    <label for="clientName" class="form-label">Name<span>*</span></label>
                    <input type="text" class="form-control" id="clientName" name="name" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="clientImage" class="form-label">Image<span>*</span></label>
                    <input type="file" class="form-control" id="clientImage" name="image" accept="image/*" required>
                </div>
                <div class="fm-item2 fm-button col-12">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn-fm">Save Client</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Client Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="clientEdit" aria-labelledby="clientEditLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="clientEditLabel">Edit Client</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- The form action is set dynamically via JS -->
            <form id="editClientForm" method="POST" class="needs-validation row g-3" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" name="client_id" id="client_id">
                <div class="col-12 fm-item2">
                    <label for="editClientName" class="form-label">Name<span>*</span></label>
                    <input type="text" class="form-control" id="editClientName" name="name" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="editClientImage" class="form-label">Image</label>
                    <input type="file" class="form-control" id="editClientImage" name="image" accept="image/*">
                </div>
                <div class="col-12 fm-item2">
                    <label class="form-label">Current Image</label>
                    <div>
                        <img id="editClientImagePreview" src="" alt="Client Image" style="max-width: 150px;">
                    </div>
                </div>
                <div class="fm-item2 fm-button col-12">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn-fm">Update Client</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Populate the Edit Client Offcanvas with the current client data.
                var clientEditOffcanvas = document.getElementById('clientEdit');
                clientEditOffcanvas.addEventListener('show.bs.offcanvas', function (event) {
                    var button = event.relatedTarget;
                    var clientId = button.getAttribute('data-client-id');
                    var clientName = button.getAttribute('data-client-name');
                    var clientImage = button.getAttribute('data-client-image');

                    // Set form values based on the clicked client's data
                    document.getElementById('client_id').value = clientId;
                    document.getElementById('editClientName').value = clientName;
                    document.getElementById('editClientImagePreview').src = clientImage;

                    // Update the form's action URL dynamically
                    var editForm = document.getElementById('editClientForm');
                    editForm.action = "{{ url('admin/clients') }}/" + clientId;
                });

                // Listen for changes on the file input to update the image preview
                var editClientImageInput = document.getElementById('editClientImage');
                editClientImageInput.addEventListener('change', function (event) {
                    var input = event.target;
                    if (input.files && input.files[0]) {
                        console.log("New image file selected");
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            console.log("Image preview updated");
                            document.getElementById('editClientImagePreview').src = e.target.result;
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>
