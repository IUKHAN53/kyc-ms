<x-app-layout>
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-4">
            <div class="ds-title">
                <h2>Grupos</h2>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-8">
            <ul class="ds-sort text-xl-end">
                <li>Filtrar por:
                    <button><i class="bi bi-search"></i> Nome</button>
                </li>
                <li>
                    <button><i class="bi bi-speedometer2"></i> Meta Diária</button>
                </li>
                <li>
                    <button><i class="bi bi-speedometer2"></i> Meta Semanal</button>
                </li>
                <li>
                    <button><i class="bi bi-speedometer2"></i> Meta Mensal</button>
                </li>
                <li class="active">
                    <button data-bs-toggle="offcanvas" data-bs-target="#groupCreate" aria-controls="groupCreate">
                        <i class="bi bi-plus"></i> Criar Grupo
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

    <!-- Table of Groups -->
    <div class="table-responsive">
        <table class="table align-middle table-ds">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Meta Diária</th>
                    <th scope="col">Meta Semanal</th>
                    <th scope="col">Meta Mensal</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($groups as $group)
                    <tr>
                        <th scope="row">
                            <span class="tb-group">{{ $group->name }}</span>
                        </th>
                        <td>{{ $group->daily_goal }}</td>
                        <td>{{ $group->weekly_goal }}</td>
                        <td>{{ $group->monthly_goal }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn-edit-group btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#groupEdit"
                                    aria-controls="groupEdit"
                                    data-group-id="{{ $group->id }}"
                                    data-group-name="{{ $group->name }}"
                                    data-daily-goal="{{ $group->daily_goal }}"
                                    data-weekly-goal="{{ $group->weekly_goal }}"
                                    data-monthly-goal="{{ $group->monthly_goal }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <!-- Delete Button -->
                            <form action="{{ route('admin.groups.destroy', $group->id) }}" method="POST" style="display:inline-block;"
                                  onsubmit="return confirm('Tem certeza que deseja deletar este grupo?');">
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
                        <td colspan="5" class="text-center">Nenhum grupo cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination (if using pagination) -->
        @if(method_exists($groups, 'links'))
            <div class="d-flex justify-content-end">
                {{ $groups->links() }}
            </div>
        @endif
    </div>

    <!-- Create Group Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="groupCreate" aria-labelledby="groupCreateLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="groupCreateLabel">Cadastro de Grupo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('admin.groups.store') }}" method="POST" class="needs-validation row g-3" novalidate>
                @csrf
                <div class="col-12 fm-item2">
                    <label for="groupName" class="form-label">Nome do Grupo<span>*</span></label>
                    <input type="text" class="form-control" id="groupName" name="name" required>
                </div>
                <div class="col-12 col-lg-4 fm-item2">
                    <label for="dailyGoal" class="form-label">Meta Diária<span>*</span></label>
                    <input type="number" class="form-control" id="dailyGoal" name="daily_goal" required>
                </div>
                <div class="col-12 col-lg-4 fm-item2">
                    <label for="weeklyGoal" class="form-label">Meta Semanal<span>*</span></label>
                    <input type="number" class="form-control" id="weeklyGoal" name="weekly_goal" required>
                </div>
                <div class="col-12 col-lg-4 fm-item2">
                    <label for="monthlyGoal" class="form-label">Meta Mensal<span>*</span></label>
                    <input type="number" class="form-control" id="monthlyGoal" name="monthly_goal" required>
                </div>
                <div class="fm-item2 fm-button col-12">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancelar</button>
                    <button type="submit" class="btn-fm">Salvar Grupo</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Group Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="groupEdit" aria-labelledby="groupEditLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="groupEditLabel">Editar Grupo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- The form action is set dynamically via JS -->
            <form id="editGroupForm" method="POST" class="needs-validation row g-3" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" name="group_id" id="group_id">
                <div class="col-12 fm-item2">
                    <label for="editGroupName" class="form-label">Nome do Grupo<span>*</span></label>
                    <input type="text" class="form-control" id="editGroupName" name="name" required>
                </div>
                <div class="col-12 col-lg-4 fm-item2">
                    <label for="editDailyGoal" class="form-label">Meta Diária<span>*</span></label>
                    <input type="number" class="form-control" id="editDailyGoal" name="daily_goal" required>
                </div>
                <div class="col-12 col-lg-4 fm-item2">
                    <label for="editWeeklyGoal" class="form-label">Meta Semanal<span>*</span></label>
                    <input type="number" class="form-control" id="editWeeklyGoal" name="weekly_goal" required>
                </div>
                <div class="col-12 col-lg-4 fm-item2">
                    <label for="editMonthlyGoal" class="form-label">Meta Mensal<span>*</span></label>
                    <input type="number" class="form-control" id="editMonthlyGoal" name="monthly_goal" required>
                </div>
                <div class="fm-item2 fm-button col-12">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancelar</button>
                    <button type="submit" class="btn-fm">Atualizar Grupo</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var groupEditOffcanvas = document.getElementById('groupEdit');
                groupEditOffcanvas.addEventListener('show.bs.offcanvas', function (event) {
                    // Get the button that triggered the offcanvas
                    var button = event.relatedTarget;
                    // Retrieve group data from the button's data attributes
                    var groupId = button.getAttribute('data-group-id');
                    var groupName = button.getAttribute('data-group-name');
                    var dailyGoal = button.getAttribute('data-daily-goal');
                    var weeklyGoal = button.getAttribute('data-weekly-goal');
                    var monthlyGoal = button.getAttribute('data-monthly-goal');

                    // Populate the form fields in the edit modal
                    document.getElementById('group_id').value = groupId;
                    document.getElementById('editGroupName').value = groupName;
                    document.getElementById('editDailyGoal').value = dailyGoal;
                    document.getElementById('editWeeklyGoal').value = weeklyGoal;
                    document.getElementById('editMonthlyGoal').value = monthlyGoal;

                    // Update the form's action URL dynamically
                    var form = document.getElementById('editGroupForm');
                    form.action = "{{ url('admin/groups') }}/" + groupId;
                });
            });
        </script>
    @endpush

</x-app-layout>
