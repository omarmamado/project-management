@extends('layouts.master')

@section('title', 'Annual Employee EvaluationList')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.min.css" rel="stylesheet">


@endsection



@section('breadcrumb-title')
    <h3>Project Inquiry Phases </h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Project Inquiry</li>
    <li class="breadcrumb-item active">Project Inquiry Phases</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">


                <div class="card">
                    <div class="card-body">

                        <form method="POST" action="{{ route('project_inquiry.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-6">
                                    <label for="name">Project Name:</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="col-6">
                                    <label for="manager_id">Project Manager:</label>
                                    <select name="manager_id" class="form-control">
                                        @foreach ($users as $user)
                                            {{-- @if ($user->is_manager) --}}
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            {{-- @endif --}}
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>

                            <table class="table table-bordered" id="phases-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Manager</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Form</th>
                                        <th>Tags</th>

                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="phases-body">
                                    <!-- سيتم إضافة الصفوف هنا -->
                                    <tr>
                                        <td><input type="text" name="phases[0][name]" class="form-control" required>
                                        </td>
                                        <td>
                                            <select name="phases[0][manager_id]" class="form-control" required>
                                                <option value="" disabled selected>Select Manager</option>
                                                @foreach ($users as $user)
                                                    @if ($user->is_manager)
                                                        <option value="{{ $user->id }}">{{ $user->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="date" name="phases[0][start_date]" class="form-control">
                                        </td>
                                        <td><input type="date" name="phases[0][end_date]" class="form-control">
                                        </td>
                                        <td>
                                            <select name="phases[0][form_id]" class="form-control" required>
                                                <option value="" disabled selected>Select Form</option>

                                                @foreach ($forms as $form)
                                                    <option value="{{ $form->id }}">{{ $form->form_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>

                                            <input type="text" id="tags" name="phases[0][tags][]"
                                                class=" form-control selectize-close-btn">
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="removeRow(this)">Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- زر إضافة مرحلة جديدة -->
                            <button type="button" class="mb-3 btn btn-success" onclick="addPhaseRow()">Add
                                Phase</button>

                            <br>

                            <!-- زر الحفظ -->
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>

                    </div>
                    <!-- end settings content-->

                </div>
            </div> <!-- end card-->

        </div> <!-- end col -->
    </div>
    <!-- end row-->

    </div> <!-- container -->

    </div> <!-- content -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>


    <script>
        let phaseIndex = 0;

        function addPhaseRow() {
            phaseIndex++;
            const row = `
    <tr>
        <td><input type="text" name="phases[${phaseIndex}][name]" class="form-control" required></td>
        <td>
            <select name="phases[${phaseIndex}][manager_id]" class="form-control" required>
                <option value="" disabled selected>Select Manager</option>
                @foreach ($users as $user)
                @if ($user->is_manager)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endif
                @endforeach
            </select>
        </td>
        <td><input type="date" name="phases[${phaseIndex}][start_date]" class="form-control"></td>
        <td><input type="date" name="phases[${phaseIndex}][end_date]" class="form-control"></td>
        <td>
            <select name="phases[${phaseIndex}][form_id]" class="form-control" required>
                <option value="" disabled selected>Select Form</option>
                @foreach ($forms as $form)
                    <option value="{{ $form->id }}">{{ $form->form_name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="phases[${phaseIndex}][tags][]" class="form-control tags-input" placeholder="Add Tags">
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button>
        </td>
    </tr>
    `;

            const tbody = document.getElementById('phases-body');
            tbody.insertAdjacentHTML('beforeend', row);
            initializeLastTagsInput();
        }

        function initializeLastTagsInput() {
            document.querySelectorAll('.tags-input').forEach((input) => {
                if (!input.classList.contains('tagify-initialized')) {
                    new Tagify(input, {
                        whitelist: @json($existingTags),
                        enforceWhitelist: false,
                        dropdown: {
                            enabled: 1,
                            position: 'input',
                            closeOnSelect: false
                        }
                    });
                    input.classList.add('tagify-initialized');
                }
            });
        }

        function removeRow(button) {
            button.closest('tr').remove();
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeLastTagsInput();
        });
    </script>

    <script>
        const existingTags = @json($existingTags);
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('#tags');
            const tagify = new Tagify(input, {
                whitelist: existingTags,
                enforceWhitelist: false,
                dropdown: {
                    enabled: 1,
                    position: 'input',
                    closeOnSelect: false
                },
                placeholder: ""
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.css">
@endsection
