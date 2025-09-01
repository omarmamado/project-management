@extends('admin_dashboard')
@section('admin')
    <!-- content -->
    <div class="pagetitle">
        <h1>Project Inquiry List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Project Inquiry List</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                {{-- @include('_message') --}}
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addNewCard">
                                <i data-feather='file-plus'></i> Add New
                            </button>

                            <a href="{{ route('project_inquiry.create') }}" type="button" class="btn btn-primary btn-sm">
                                <i data-feather='file-plus'></i> Add New Project
                            </a>
                        </h5>

                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Project Owner</th>
                                    <th>Assign Manager</th>
                                    <th>Name</th>
                                    <th>Form</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $project->creator->name }}</td>
                                        <td>{{ $project->manager->name }}</td>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->form->form_name ?? '' }}</td>
                                        <td>
                                            @if ($project->status == 'approved')
                                                <span class="badge badge-glow bg-success">Approved</span>
                                            @elseif($project->status == 'rejected')
                                                <span class="badge badge-glow bg-danger">Rejected</span>
                                            @else
                                                <span class="badge badge-glow bg-primary">Pending</span>
                                            @endif
                                        </td>
                        
                                        <td>
                                            <!-- زر تعديل المشروع -->
                                            <a href="{{ route('project_inquiry.edit', ['project_inquiry' => $project->id]) }}" class="btn btn-info btn-sm">
                                                <i data-feather="file-plus"></i> Edit
                                            </a>
                        
                                            <!-- زر عرض تفاصيل المشروع -->
                                            <a href="{{ route('project_inquiry.show', ['project_inquiry' => $project->id]) }}" class="btn btn-warning btn-sm">
                                                <i data-feather="eye"></i> View
                                            </a>

                                            <a href="{{ route('project_inquiry_phase.show', ['project_inquiry' => $project->id]) }}" class="btn btn-secondary btn-sm">
                                                <i data-feather="list"></i> View Phases
                                            </a>
                        
                                            <!-- زر عرض مراحل المشروع -->
                                            {{-- <button type="button" class="btn btn-secondary btn-sm" data-toggle="collapse"
                                                    data-target="#phases-{{ $project->id }}" aria-expanded="false" aria-controls="phases-{{ $project->id }}">
                                                <i data-feather="list"></i> View Phases
                                            </button> --}}
                                        </td>
                                    </tr>
                        
                                    <!-- المراحل المرتبطة بالمشروع -->
                                    <tr class="collapse" id="phases-{{ $project->id }}">
                                        <td colspan="7">
                                            <table class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Phase Name</th>
                                                        <th>Manager</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($project->phases as $index => $phase)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $phase->name }}</td>
                                                            <td>{{ $phase->manager->name ?? 'N/A' }}</td>
                                                            <td>{{ $phase->start_date }}</td>
                                                            <td>{{ $phase->end_date }}</td>
                                                            <td></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">No phases found for this project.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $projects->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
                {{-- add model --}}
                <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="bg-transparent modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="pb-5 modal-body px-sm-5 mx-50">
                                <h4 class="mb-1 text-center" id="addNewCardTitle">Add New Project Inquiry</h4>

                                <!-- form -->
                                <form action="{{ route('project_inquiry.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label" for="modalAddCardNumber">Name</label>
                                            <div class="input-group input-group-merge">
                                                <input id="modalAddCardNumber" name="name"
                                                    class="form-control add-credit-card-mask" type="text"
                                                    placeholder="Name" aria-describedby="modalAddCard2"
                                                    data-msg="Please enter your credit card number" required />
                                                <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                    <span class="add-card-type"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="modalAddCardNumber">Forms</label>
                                            <div class="input-group input-group-merge">
                                                <select id="form_id" name="form_id"
                                                    class="form-control add-credit-card-mask" id="modalAddCardNumber"
                                                    class="my-1 custom-select mr-sm-2" required>
                                                    <option value="" disabled selected>
                                                        Forms</option>

                                                    @foreach ($forms as $form)
                                                        <option value="{{ $form->id }}">{{ $form->form_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                    <span class="add-card-type"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-manager_id" for="modalAddCardNumber">Manger</label>
                                        <div class="input-group input-group-merge">
                                            <select id="manager_id" name="manager_id"
                                                class="form-control add-credit-card-mask" id="modalAddCardNumber"
                                                class="my-1 custom-select mr-sm-2" required>
                                                <option value="" disabled selected>
                                                    Forms</option>
                                                <option value="">Select Manger</option>

                                                @foreach ($managers as $manager)
                                                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                <span class="add-card-type"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label" for="modalAddCardNumber">Start Date</label>
                                            <div class="input-group input-group-merge">
                                                <input id="modalAddCardNumber" name="start_date"
                                                    class="form-control add-credit-card-mask" type="date"
                                                    placeholder="Name" aria-describedby="modalAddCard2"
                                                    data-msg="Please enter your credit card number" required />
                                                <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                    <span class="add-card-type"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="modalAddCardNumber">End Date</label>
                                            <div class="input-group input-group-merge">
                                                <input id="modalAddCardNumber" name="end_date"
                                                    class="form-control add-credit-card-mask" type="date"
                                                    placeholder="Name" aria-describedby="modalAddCard2"
                                                    data-msg="Please enter your credit card number" required />
                                                <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                    <span class="add-card-type"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- مكان عرض الحقول الديناميكية -->
                                    <br>
                                    <div id="dynamic-form-fields"></div>
                                    <br>



                                    <div class="text-center col-12">
                                        <button type="submit" class="mt-1 btn btn-warning me-1">
                                            <i data-feather='save'></i> Submit
                                        </button>
                                        <button type="reset" class="mt-1 btn btn-outline-secondary"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather='x-circle'></i> Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ add new card modal  -->
            </div>
    </section>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4 -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




    <script>
        function generateFieldHtml(field) {
            const attrs = `id="${field.name}" name="dynamic_data[${field.name}]" class="form-control" required`;
            let fieldHtml =
                `<div class="mb-3 col-md-6"><label class="form-label" for="${field.name}">${field.label || field.name}</label><div class="input-group input-group-merge">`;

            if (field.type === 'text' || field.type === 'number') {
                fieldHtml += `<input ${attrs} type="${field.type}" placeholder="${field.placeholder || field.name}" />`;
            } else if (field.type === 'textarea') {
                fieldHtml += `<textarea ${attrs} placeholder="${field.placeholder || field.name}"></textarea>`;
            } else if (field.type === 'select') {
                const options = field.options?.split(',').map(option =>
                    `<option value="${option.trim()}">${option.trim()}</option>`).join('') || '';
                fieldHtml += `<select ${attrs}>${options}</select>`;
            } else if (field.type === 'date') {
                fieldHtml += `<input ${attrs} type="date" />`;
            } else if (field.type === 'checkbox') {
                fieldHtml +=
                    `<div><input type="checkbox" id="${field.name}" name="dynamic_data[${field.name}]" value="1" /> <label for="${field.name}">${field.label || field.name}</label></div>`;
            }

            return fieldHtml + `</div></div>`;
        }

        function loadFormFields() {
            const formId = document.getElementById('form_id').value;
            if (!formId) return;

            fetch(`/forms/${formId}/fields`)
                .then(response => response.json())
                .then(data => {
                    const fieldsContainer = document.getElementById('dynamic-form-fields');
                    fieldsContainer.innerHTML = '';
                    if (data?.fields) {
                        const fields = Object.values(data.fields);
                        let rowHtml = '<div class="row">';
                        fields.forEach((field, index) => {
                            rowHtml += generateFieldHtml(field);
                            if ((index + 1) % 2 === 0) rowHtml += '</div><div class="row">';
                        });
                        rowHtml += '</div>';
                        fieldsContainer.innerHTML = rowHtml;
                    }
                })
                .catch(error => console.error('Error loading form fields:', error));
        }

        document.getElementById('form_id').addEventListener('change', loadFormFields);

        // تشغيل الوظيفة عند التحميل الأولي للصفحة.
        document.addEventListener('DOMContentLoaded', () => {
            const formSelect = document.getElementById('form_id');
            if (formSelect && formSelect.value) {
                loadFormFields();
            }
        });
    </script>
@endsection
