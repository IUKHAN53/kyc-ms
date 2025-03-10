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
                <li class="active">
                    <button><i class="bi bi-table"></i> Exportar relatório</button>
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
                            <img src="{{ asset('storage/' . $sale->client->logo) }}"
                                 alt="{{ $sale->client->name }}"
                                 class="img-fluid"
                                 style="max-width: 50px;">
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
                        <!-- Edit Button now repurposed for Auditor to see details -->
                        <button class="btn-edit-conversion btn btn-primary btn-sm"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#conversionEdit"
                                aria-controls="conversionEdit"
                                data-sale-id="{{ $sale->id }}"
                                data-sale-client="{{ $sale->client ? $sale->client->name : 'N/A' }}"
                                data-sale-group="{{ $sale->group ? $sale->group->name : 'N/A' }}"
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
                            <i class="bi bi-eye"></i>
                        </button>
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

    <!-- Edit Conversion Offcanvas (Read-only for the Auditor, plus comments & approval) -->
    <div class="offcanvas offcanvas-end sidebar-ds" tabindex="-1" id="conversionEdit"
         aria-labelledby="conversionEditLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="conversionEditLabel">Detalhes da Conversão</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- We'll have a single form that sets the 'description' (auditor comments).
                 Approval/Rejection is determined by which button is clicked (value for 'status'). -->
            <form id="changeStatusForm" method="POST" class="needs-validation row g-3" novalidate>
                @csrf
                <!-- The route will be set dynamically in JavaScript when the offcanvas is opened. -->

                <!-- Client (Read-only) -->
                <div class="col-12 fm-item2">
                    <label class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="conversionClient" name="client_name" readonly>
                </div>

                <!-- Group (Read-only) -->
                <div class="col-12 fm-item2">
                    <label class="form-label">Grupo</label>
                    <input type="text" class="form-control" id="editConversionGroup" name="group_name" readonly>
                </div>

                <!-- Jira Status (Read-only) -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label class="form-label">Status no Jira</label>
                    <input type="text" class="form-control" id="conversionJiraStatus" name="jira_status" readonly>
                </div>

                <!-- Backoffice ID (Read-only) -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label class="form-label">ID Backoffice</label>
                    <input type="text" class="form-control" id="conversionBackofficeId" name="backoffice_id" readonly>
                </div>

                <!-- Date (Read-only) -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label class="form-label">Data</label>
                    <input type="date" class="form-control" id="conversionDate" name="date" readonly>
                </div>

                <!-- Hour (Read-only) -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label class="form-label">Hora</label>
                    <input type="time" class="form-control" id="conversionHour" name="hour" readonly>
                </div>

                <!-- Jira ID (Read-only) -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label class="form-label">ID Jira</label>
                    <input type="text" class="form-control" id="conversionJiraId" name="jira_id" readonly>
                </div>

                <!-- Bonus (Read-only) -->
                <div class="col-12 col-lg-6 fm-item2">
                    <label class="form-label">Bônus</label>
                    <input type="text" class="form-control" id="conversionBonus" name="bonus" readonly>
                </div>

                <!-- Voucher (Read-only link if you need) -->
                <div class="col-12 fm-item2">
                    <label class="form-label">Comprovante</label>
                    <div>
                        <a href="" id="conversionVoucherLink" target="_blank">Visualizar Comprovante</a>
                    </div>
                </div>

                <!-- Current Audit Status (Read-only) -->
                <div class="col-12 fm-item2">
                    <label class="form-label">Status da Auditoria</label>
                    <input type="text" class="form-control" id="conversionStatus" name="status" readonly>
                </div>

                <!-- Auditor Comments (writeable) -->
                <div class="col-12 fm-item2">
                    <label for="conversionDescription" class="form-label">Comentário do Auditor</label>
                    <textarea class="form-control" id="conversionDescription" name="description" rows="3"></textarea>
                </div>

                <div class="fm-item2 fm-button col lign-self-end mt-3">
                    <!-- Two buttons: Approve or Reject -->
                    <button type="submit" class="btn-fm btn me-3" name="status" value="approved">
                        Aprovar
                    </button>
                    <button type="submit" class="btn-cn btn" name="status" value="rejected">
                        Rejeitar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var conversionEditOffcanvas = document.getElementById('conversionEdit');

                conversionEditOffcanvas.addEventListener('show.bs.offcanvas', function (event) {
                    var button = event.relatedTarget;
                    // Retrieve attributes
                    var saleId = button.getAttribute('data-sale-id');
                    var clientName = button.getAttribute('data-sale-client');
                    var groupName = button.getAttribute('data-sale-group');
                    var jiraId = button.getAttribute('data-sale-jira-id');
                    var jiraStatus = button.getAttribute('data-sale-jira-status');
                    var backofficeId = button.getAttribute('data-sale-backoffice-id');
                    var date = button.getAttribute('data-sale-date');
                    var hour = button.getAttribute('data-sale-hour');
                    var bonus = button.getAttribute('data-sale-bonus');
                    var voucher = button.getAttribute('data-sale-voucher');
                    var status = button.getAttribute('data-sale-status');
                    var description = button.getAttribute('data-sale-description');

                    // Populate fields
                    document.getElementById('conversionClient').value = clientName;
                    document.getElementById('editConversionGroup').value = groupName;
                    document.getElementById('conversionJiraId').value = jiraId;
                    document.getElementById('conversionJiraStatus').value = jiraStatus;
                    document.getElementById('conversionBackofficeId').value = backofficeId;
                    document.getElementById('conversionDate').value = date;
                    document.getElementById('conversionHour').value = hour;
                    document.getElementById('conversionBonus').value = bonus;
                    document.getElementById('conversionStatus').value = status;
                    document.getElementById('conversionDescription').value = description;

                    // Voucher link
                    document.getElementById('conversionVoucherLink').setAttribute('href', voucher);

                    // Dynamically set form action for status update
                    var changeStatusForm = document.getElementById('changeStatusForm');
                    changeStatusForm.action = "{{ url('auditor/change-status') }}/" + saleId;
                });
            });
        </script>
    @endpush

</x-app-layout>
