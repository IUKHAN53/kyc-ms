<x-app-layout>
    <!-- Header & Filters -->
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-4">
            <div class="ds-title">
                <h2>Minhas Conversões</h2>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-8">
            <ul class="ds-sort text-xl-end">
                <li>Filtrar por:
                    <button><i class="bi bi-star"></i> Bet</button>
                </li>
                <li>
                    <button><i class="bi bi-square"></i> Status Jira</button>
                </li>
                <li>
                    <button><i class="bi bi-clipboard-check"></i> Auditoria</button>
                </li>
                <!-- Replaced Export button with Create Conversion button -->
                <li class="active">
                    <button data-bs-toggle="offcanvas" data-bs-target="#conversionCreate" aria-controls="conversionCreate">
                        <i class="bi bi-plus"></i> Criar Conversão
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger my-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Table of Conversions -->
    <div class="table-responsive">
        <table class="table align-middle table-ds">
            <thead>
                <tr>
                    <th scope="col">Bet</th>
                    <th scope="col">Jira</th>
                    <th scope="col">Data da Conversão</th>
                    <th scope="col">Comissão</th>
                    <th scope="col">Auditoria</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <th scope="row">
                        @if($sale->client && isset($sale->client->logo))
                          <img src="{{ asset('storage/' . $sale->client->logo) }}" alt="{{ $sale->client->name }}" class="img-fluid" style="max-width: 50px;">
                        @endif
                        <span class="tb-bet">{{ $sale->client ? $sale->client->name : 'N/A' }}</span>
                    </th>
                    <td>
                        <span class="
                        @if(strtolower($sale->jira_status)=='aguardando') tb-gray
                        @elseif(strtolower($sale->jira_status)=='resolvido') tb-green
                        @else tb-orange @endif
                        ">
                            {{ $sale->jira_status }} ({{ $sale->jira_id }})
                        </span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }} às {{ $sale->hour }}
                    </td>
                    <td>
                        R$ {{ $sale->bonus }}
                    </td>
                    <td>
                        <span class="
                        @if($sale->status=='approved') tb-green
                        @elseif($sale->status=='rejected') tb-red
                        @else tb-orange @endif
                        ">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </td>
                    <td>
                        <!-- Edit Button with extra data attribute for group_id -->
                        <button class="btn-edit-conversion btn btn-primary btn-sm"
                            data-bs-toggle="offcanvas" data-bs-target="#conversionEdit" aria-controls="conversionEdit"
                            data-sale-id="{{ $sale->id }}"
                            data-sale-client="{{ $sale->client_id }}"
                            data-sale-group="{{ $sale->group_id }}"
                            data-sale-jira-id="{{ $sale->jira_id }}"
                            data-sale-jira-status="{{ $sale->jira_status }}"
                            data-sale-backoffice-id="{{ $sale->backoffice_id }}"
                            data-sale-date="{{ $sale->date }}"
                            data-sale-hour="{{ $sale->hour }}"
                            data-sale-bonus="{{ $sale->bonus }}"
                            data-sale-voucher="{{ asset('storage/' . $sale->voucher_image) }}"
                            data-sale-status="{{ $sale->status }}"
                            data-sale-description="{{ $sale->description }}"
                        >
                            <i class="bi bi-pencil"></i>
                        </button>
                        <!-- Delete Button -->
                        <form action="{{ route('admin.sales.destroy', $sale->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Tem certeza que deseja deletar esta conversão?');">
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
                    <td colspan="6" class="text-center">Nenhuma conversão encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if(method_exists($sales, 'links'))
        <div class="d-flex justify-content-end">
            {{ $sales->links() }}
        </div>
        @endif
    </div>

    <!-- Create Conversion Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="conversionCreate" aria-labelledby="conversionCreateLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="conversionCreateLabel">Cadastrar Conversão</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('admin.sales.store') }}" method="POST" class="needs-validation row g-3" enctype="multipart/form-data" novalidate>
                @csrf
                <!-- Client Dropdown -->
                <div class="col-12 fm-item2">
                    <label for="createConversionClient" class="form-label">Qual o Cliente?<span>*</span></label>
                    <select class="form-select" id="createConversionClient" name="client_id" required>
                        <option value="">Select Client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Group Dropdown (new) -->
                <div class="col-12 fm-item2">
                    <label for="createConversionGroup" class="form-label">Grupo<span>*</span></label>
                    <select class="form-select" id="createConversionGroup" name="group_id" required>
                        <option value="">Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Jira Status -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="createConversionJiraStatus" class="form-label">Status no Jira<span>*</span></label>
                    <select class="form-select" id="createConversionJiraStatus" name="jira_status" required>
                        <option value="aguardando">Aguardando atendimento</option>
                        <option value="resolvido">Resolvido</option>
                    </select>
                </div>
                <!-- Backoffice ID -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="createConversionBackofficeId" class="form-label">ID Backoffice<span>*</span></label>
                    <input type="text" class="form-control" id="createConversionBackofficeId" name="backoffice_id" required>
                </div>
                <!-- Date -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="createConversionDate" class="form-label">Data<span>*</span></label>
                    <input type="date" class="form-control" id="createConversionDate" name="date" required>
                </div>
                <!-- Hour -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="createConversionHour" class="form-label">Hora<span>*</span></label>
                    <input type="time" class="form-control" id="createConversionHour" name="hour" required>
                </div>
                <!-- Jira ID -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="createConversionJiraId" class="form-label">ID Jira<span>*</span></label>
                    <input type="text" class="form-control" id="createConversionJiraId" name="jira_id" required>
                    <p>Ex: CDT-532</p>
                </div>
                <!-- Bonus -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="createConversionBonus" class="form-label">Bônus<span>*</span></label>
                    <input type="text" class="form-control" id="createConversionBonus" name="bonus" required>
                </div>
                <!-- Voucher Upload -->
                <div class="col-12 fm-item2">
                    <label for="createConversionVoucher" class="form-label">Upload do Comprovante<span>*</span></label>
                    <input type="file" class="form-control" id="createConversionVoucher" name="voucher_image" accept="image/*,application/pdf" required>
                    <p>JPG, PNG, JPEG e PDF</p>
                </div>
                <!-- Conversion Status -->
                <div class="col-12 fm-item2">
                    <label for="createConversionStatus" class="form-label">Auditoria<span>*</span></label>
                    <select class="form-select" id="createConversionStatus" name="status" required>
                        <option value="pending" selected>Pendente</option>
                        <option value="approved">Aprovado</option>
                        <option value="rejected">Recusado</option>
                    </select>
                </div>
                <!-- Description -->
                <div class="col-12 fm-item2">
                    <label for="createConversionDescription" class="form-label">Descrição</label>
                    <textarea class="form-control" id="createConversionDescription" name="description"></textarea>
                </div>
                <div class="fm-item2 fm-button col lign-self-end">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancelar</button>
                    <button type="submit" class="btn-fm">Salvar Conversão</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Conversion Offcanvas -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="conversionEdit" aria-labelledby="conversionEditLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="conversionEditLabel">Cadastro de Conversão Realizada</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="editConversionForm" method="POST" class="needs-validation row g-3" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" name="sale_id" id="sale_id">
                <!-- Client Dropdown -->
                <div class="col-12 fm-item2">
                    <label for="conversionClient" class="form-label">Qual o Cliente?<span>*</span></label>
                    <select class="form-select" id="conversionClient" name="client_id" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Group Dropdown -->
                <div class="col-12 fm-item2">
                    <label for="editConversionGroup" class="form-label">Grupo<span>*</span></label>
                    <select class="form-select" id="editConversionGroup" name="group_id" required>
                        <option value="">Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Jira Status -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="conversionJiraStatus" class="form-label">Status no Jira<span>*</span></label>
                    <select class="form-select" id="conversionJiraStatus" name="jira_status" required>
                        <option value="aguardando">Aguardando atendimento</option>
                        <option value="resolvido">Resolvido</option>
                    </select>
                </div>
                <!-- Backoffice ID -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="conversionBackofficeId" class="form-label">ID Backoffice<span>*</span></label>
                    <input type="text" class="form-control" id="conversionBackofficeId" name="backoffice_id" required>
                </div>
                <!-- Date -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="conversionDate" class="form-label">Data<span>*</span></label>
                    <input type="date" class="form-control" id="conversionDate" name="date" required>
                </div>
                <!-- Hour -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="conversionHour" class="form-label">Hora<span>*</span></label>
                    <input type="time" class="form-control" id="conversionHour" name="hour" required>
                </div>
                <!-- Jira ID -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="conversionJiraId" class="form-label">ID Jira<span>*</span></label>
                    <input type="text" class="form-control" id="conversionJiraId" name="jira_id" required>
                    <p>Ex: CDT-532</p>
                </div>
                <!-- Bonus -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label for="conversionBonus" class="form-label">Bônus<span>*</span></label>
                    <input type="text" class="form-control" id="conversionBonus" name="bonus" required>
                </div>
                <!-- Voucher Upload -->
                <div class="col-12 fm-item2">
                    <label for="conversionVoucher" class="form-label">Upload do Comprovante<span>*</span></label>
                    <input type="file" class="form-control" id="conversionVoucher" name="voucher_image" accept="image/*,application/pdf">
                    <p>JPG, PNG, JPEG e PDF</p>
                </div>
                <!-- Conversion Status -->
                <div class="col-12 fm-item2">
                    <label for="conversionStatus" class="form-label">Auditoria<span>*</span></label>
                    <select class="form-select" id="conversionStatus" name="status" required>
                        <option value="pending">Pendente</option>
                        <option value="approved">Aprovado</option>
                        <option value="rejected">Recusado</option>
                    </select>
                </div>
                <!-- Description -->
                <div class="col-12 fm-item2">
                    <label for="conversionDescription" class="form-label">Descrição</label>
                    <textarea class="form-control" id="conversionDescription" name="description"></textarea>
                </div>
                <div class="fm-item2 fm-button col lign-self-end">
                    <button type="button" class="btn-cn" data-bs-dismiss="offcanvas">Cancelar</button>
                    <button type="submit" class="btn-fm">Salvar Conversão</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Populate the Edit Conversion Offcanvas with the current sale data.
            var conversionEditOffcanvas = document.getElementById('conversionEdit');
            conversionEditOffcanvas.addEventListener('show.bs.offcanvas', function (event) {
                var button = event.relatedTarget;
                var saleId = button.getAttribute('data-sale-id');
                var clientId = button.getAttribute('data-sale-client');
                var groupId = button.getAttribute('data-sale-group'); // New attribute for group
                var jiraId = button.getAttribute('data-sale-jira-id');
                var jiraStatus = button.getAttribute('data-sale-jira-status');
                var backofficeId = button.getAttribute('data-sale-backoffice-id');
                var date = button.getAttribute('data-sale-date');
                var hour = button.getAttribute('data-sale-hour');
                var bonus = button.getAttribute('data-sale-bonus');
                var voucher = button.getAttribute('data-sale-voucher');
                var status = button.getAttribute('data-sale-status');
                var description = button.getAttribute('data-sale-description');

                document.getElementById('sale_id').value = saleId;
                document.getElementById('conversionClient').value = clientId;
                document.getElementById('editConversionGroup').value = groupId;
                document.getElementById('conversionJiraId').value = jiraId;
                document.getElementById('conversionJiraStatus').value = jiraStatus;
                document.getElementById('conversionBackofficeId').value = backofficeId;
                document.getElementById('conversionDate').value = date;
                document.getElementById('conversionHour').value = hour;
                document.getElementById('conversionBonus').value = bonus;
                document.getElementById('conversionStatus').value = status;
                document.getElementById('conversionDescription').value = description;

                var editForm = document.getElementById('editConversionForm');
                editForm.action = "{{ url('admin/sales') }}/" + saleId;
            });

            // You can add an event listener for voucher image preview update here if desired.
        });
    </script>
    @endpush

</x-app-layout>
