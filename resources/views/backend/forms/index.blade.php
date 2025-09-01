@extends('layouts.master')

@section('title', 'Employee Evaluation List')

@section('css')

@endsection

@section('breadcrumb-title')
    <h3>Forms List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Project inquiry</li>
    <li class="breadcrumb-item active">Forms List</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addNewCard">
                                <i class="icon-plus"></i>


                                Add New
                            </button>
                            <div class="table-responsive">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                               
                                            <th>Processes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach ($forms as $form)
                                            <tr>
                                                <?php $i++; ?>
                                                <td>{{ $i }}</td>
                                                <td>{{ $form->form_name }}</td>

                                                <td>
                                                   
                                                    <a href="{{ route('forms.show', $form->id) }}">
                                                        <i class="icon-eye text-warning"></i> 
                                                    </a>
                                                </td>
                                            </tr>
                                            {{-- Edit model --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- add model --}}
                        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="bg-transparent modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="pb-5 modal-body px-sm-5 mx-50">
                                        <h4 class="mb-1 text-center" id="addNewCardTitle">Add New Forms</h4>

                                        <!-- form -->
                                        <form action="{{ route('forms.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <label>Form Name</label>
                                                <input type="text" name="form_name" class="form-control" required>
                                            </div>

                                            <div id="fields-container" class="row">
                                                <!-- all input form-->
                                            </div>
                                            <br>
                                            <button type="button" id="add-field" class="btn btn-secondary"> Add
                                                Field</button>
                                            <button type="submit" class="btn btn-primary"> Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ add new card modal  -->
                        <!--/ add new card modal  -->
                    </div>
                </div>
            </div>
        </div>
    </div>

                    <script>
                        let fieldCount = 0;

                        document.getElementById('add-field').addEventListener('click', () => {
                            const container = document.getElementById('fields-container');
                            fieldCount++;

                            const fieldHtml = `
    <div class="mb-3 col-md-12 field" id="field-${fieldCount}">
        <div class="row">
            <div class="col-md-5">
                <label>Name:</label>
                <input type="text" name="fields[${fieldCount}][name]" class="form-control" required>
            </div>
            <div class="col-md-5">
                <label>Type Name:</label>
                <select name="fields[${fieldCount}][type]" class="form-control">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="textarea">Note</option>
                    <option value="date">Date</option>
                    <option value="checkbox">Checkbox</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-field" onclick="removeField(${fieldCount})">
                    Remove
                </button>
            </div>
        </div>
    </div>
    `;

                            container.insertAdjacentHTML('beforeend', fieldHtml);
                        });

                        function removeField(fieldId) {
                            const field = document.getElementById(`field-${fieldId}`);
                            if (field) {
                                field.remove();
                            }
                        }
                    </script>
                @endsection
