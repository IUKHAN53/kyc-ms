<x-app-layout>
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-4">
            <div class="ds-title">
                <h2>Agent</h2>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-8">
            <ul class="ds-sort text-xl-end">
                <li>Filter by:
                    <button><i class="bi bi-search"></i> Name</button>
                </li>
                <li class="active">
                    <button data-bs-toggle="offcanvas" data-bs-target="#agentCreate" aria-controls="agentCreate">
                        <i class="bi bi-plus"></i> Create Agent
                    </button>
                </li>
            </ul>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger my-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Table of Agents -->
    <div class="table-responsive">
        <table class="table align-middle table-ds">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Profile Image</th>
                    <th scope="col">Group</th>
                    <th scope="col">Client</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $agent)
                    <tr>
                        <td>{{ $agent->name }}</td>
                        <td>{{ $agent->email }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $agent->profile_image) }}" alt="{{ $agent->name }}" class="img-fluid" style="max-width: 100px;">
                        </td>
                        <td>{{ optional($agent->group)->name }}</td>
                        <td>{{ optional($agent->client)->name }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn-edit-agent btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#agentEdit" aria-controls="agentEdit"
                                    data-agent-id="{{ $agent->id }}"
                                    data-agent-name="{{ $agent->name }}"
                                    data-agent-email="{{ $agent->email }}"
                                    data-agent-group="{{ $agent->group_id }}"
                                    data-agent-client="{{ $agent->client_id }}"
                                    data-agent-profile="{{ asset('storage/' . $agent->profile_image) }}">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.agents.destroy', $agent->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this agent?');">
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
                        <td colspan="6" class="text-center">No agents available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if(method_exists($users, 'links'))
            <div class="d-flex justify-content-end">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Create Agent Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="agentCreate" aria-labelledby="agentCreateLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="agentCreateLabel">Create Agent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('admin.agents.store') }}" method="POST" class="needs-validation row g-3" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="col-12 fm-item2">
                    <label for="agentName" class="form-label">Name<span>*</span></label>
                    <input type="text" class="form-control" id="agentName" name="name" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="agentEmail" class="form-label">Email<span>*</span></label>
                    <input type="email" class="form-control" id="agentEmail" name="email" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="agentPassword" class="form-label">Password<span>*</span></label>
                    <input type="password" class="form-control" id="agentPassword" name="password" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="agentPasswordConfirmation" class="form-label">Confirm Password<span>*</span></label>
                    <input type="password" class="form-control" id="agentPasswordConfirmation" name="password_confirmation" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="agentGroup" class="form-label">Group<span>*</span></label>
                    <select class="form-select" id="agentGroup" name="group_id" required>
                        <option value="">Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 fm-item2">
                    <label for="agentClient" class="form-label">Client<span>*</span></label>
                    <select class="form-select" id="agentClient" name="client_id" required>
                        <option value="">Select Client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 fm-item2">
                    <label for="agentProfileImage" class="form-label">Profile Image<span>*</span></label>
                    <input type="file" class="form-control" id="agentProfileImage" name="profile_image" accept="image/*" required>
                </div>
                <div class="fm-item2 fm-button col-12">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn-fm">Save Agent</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Agent Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="agentEdit" aria-labelledby="agentEditLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="agentEditLabel">Edit Agent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="editAgentForm" method="POST" class="needs-validation row g-3" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" name="agent_id" id="agent_id">
                <div class="col-12 fm-item2">
                    <label for="editAgentName" class="form-label">Name<span>*</span></label>
                    <input type="text" class="form-control" id="editAgentName" name="name" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="editAgentEmail" class="form-label">Email<span>*</span></label>
                    <input type="email" class="form-control" id="editAgentEmail" name="email" required>
                </div>
                <div class="col-12 fm-item2">
                    <label for="editAgentPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="editAgentPassword" name="password" placeholder="Leave blank to keep current">
                </div>
                <div class="col-12 fm-item2">
                    <label for="editAgentPasswordConfirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="editAgentPasswordConfirmation" name="password_confirmation" placeholder="Leave blank to keep current">
                </div>
                <div class="col-12 fm-item2">
                    <label for="editAgentGroup" class="form-label">Group<span>*</span></label>
                    <select class="form-select" id="editAgentGroup" name="group_id" required>
                        <option value="">Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 fm-item2">
                    <label for="editAgentClient" class="form-label">Client<span>*</span></label>
                    <select class="form-select" id="editAgentClient" name="client_id" required>
                        <option value="">Select Client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 fm-item2">
                    <label for="editAgentProfileImage" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="editAgentProfileImage" name="profile_image" accept="image/*">
                </div>
                <div class="col-12 fm-item2">
                    <label class="form-label">Current Profile Image</label>
                    <div>
                        <img id="editAgentProfileImagePreview" src="" alt="Agent Profile" class="img-fluid" style="max-width: 150px;">
                    </div>
                </div>
                <div class="fm-item2 fm-button col-12">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn-fm">Update Agent</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Populate the Edit Agent Offcanvas with the current agent data.
            var agentEditOffcanvas = document.getElementById('agentEdit');
            agentEditOffcanvas.addEventListener('show.bs.offcanvas', function (event) {
                var button = event.relatedTarget;
                var agentId = button.getAttribute('data-agent-id');
                var agentName = button.getAttribute('data-agent-name');
                var agentEmail = button.getAttribute('data-agent-email');
                var agentGroup = button.getAttribute('data-agent-group');
                var agentClient = button.getAttribute('data-agent-client');
                var agentProfile = button.getAttribute('data-agent-profile');

                document.getElementById('agent_id').value = agentId;
                document.getElementById('editAgentName').value = agentName;
                document.getElementById('editAgentEmail').value = agentEmail;
                document.getElementById('editAgentGroup').value = agentGroup;
                document.getElementById('editAgentClient').value = agentClient;
                document.getElementById('editAgentProfileImagePreview').src = agentProfile;

                var editForm = document.getElementById('editAgentForm');
                editForm.action = "{{ url('admin/agents') }}/" + agentId;
            });

            // Update the image preview in the edit modal when a new file is selected.
            var editAgentProfileImageInput = document.getElementById('editAgentProfileImage');
            editAgentProfileImageInput.addEventListener('change', function(event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('editAgentProfileImagePreview').src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>
    @endpush

</x-app-layout>
