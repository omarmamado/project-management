@extends('layouts.master')

@section('title', 'Users ')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Users List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">Users List</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addNewCard">
                                <i class="icon-plus"></i> Add New
                            </button>

                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addNewCard1">
                                <i class ='icon-file'></i> Add Export File
                            </button>
                        </h5>
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Company</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Is Manager</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($users as $user)
                                        <tr>
                                            <?php $i++; ?>
                                            <th>{{ $i }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->Company ? $user->Company->name : 'N/A' }}</td>
                                            <td>{{ $user->department ? $user->department->name : 'N/A' }}</td>
                                            <td>{{ ucfirst($user->role) }}</td>
                                            <td>{{ $user->is_manager ? 'Yes' : 'No' }}</td>
                                            <td>

                                                <ul class="action">
                                                    <li class="edit">
                                                        <a href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#edit{{ $user->id }}">
                                                            <i class="icon-pencil-alt"></i>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </td>
                                        </tr>
                                        {{-- edit model --}}

                                        <div class="modal fade" id="edit{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="addNewCardTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="bg-transparent modal-header">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="pb-5 modal-body px-sm-5 mx-50">
                                                        <h4 class="mb-1 text-center" id="addNewCardTitle">Edit
                                                            Uesr</h4>
                                                        <!-- form -->
                                                        <form id="editUserForm"
                                                            action="{{ route('users.update', $user->id) }}"
                                                            class="row gy-1 gx-2 mt-75" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <!-- Name Field -->
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label class="form-label" for="userName">Name</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <input id="userName" name="name"
                                                                            class="form-control" type="text"
                                                                            placeholder="User Name"
                                                                            value="{{ $user->name }}" required />

                                                                    </div>
                                                                </div>
                                                                <!-- Email Field -->
                                                                <div class="col-6">
                                                                    <label class="form-label" for="userEmail">Email</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <input id="userEmail" name="email"
                                                                            class="form-control" type="email"
                                                                            placeholder="User Email"
                                                                            value="{{ $user->email }}" required />

                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <!-- Phone Field -->
                                                                <div class="col-6">
                                                                    <label class="form-label" for="userPhone">Phone</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <input id="userPhone" name="phone"
                                                                            class="form-control" type="text"
                                                                            placeholder="Phone"
                                                                            value="{{ $user->phone }}" />
                                                                       
                                                                    </div>
                                                                </div>

                                                                <!-- Company Field -->
                                                                <div class="col-6">
                                                                    <label class="form-label"
                                                                        for="company_id">Company</label>
                                                                    <select id="company_id" name="company_id"
                                                                        class="form-control" required>
                                                                        <option value="" disabled>Select Company
                                                                        </option>
                                                                        @foreach ($companies as $company)
                                                                            <option value="{{ $company->id }}"
                                                                                {{ $user->company_id == $company->id ? 'selected' : '' }}>
                                                                                {{ $company->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>



                                                            <div class="row">
                                                                <!-- Department Field -->
                                                                <div class="col-6">
                                                                    <label class="form-label"
                                                                        for="department_id">Department</label>
                                                                    <select id="department_id" name="department_id"
                                                                        class="form-control">
                                                                        @foreach ($departments as $department)
                                                                            <option value="{{ $department->id }}"
                                                                                {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                                                                {{ $department->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-6">
                                                                    <label class="form-label" for="team_id">Team</label>
                                                                    <select id="team_id" name="team_id"
                                                                        class="form-control">
                                                                        @foreach ($teams as $team)
                                                                            <option value="{{ $team->id }}"
                                                                                {{ $user->team_id == $team->id ? 'selected' : '' }}>
                                                                                {{ $team->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                  <!-- Job Title Field -->
                                                            <div class="col-6">
                                                                <label class="form-label" for="jobTitle">Job Title</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input id="job_title" name="job_title"
                                                                        class="form-control" type="text"
                                                                        placeholder="Job Title"
                                                                        value="{{ $user->job_title }}" />
                                                                  
                                                                </div>
                                                            </div>
                                                             <!-- User Role Field -->
                                                             <div class="col-6">
                                                                <label class="form-label" for="userRole">User Role</label>
                                                                <div class="input-group input-group-merge">
                                                                    <select id="userRole" name="role"
                                                                        class="form-control" required>
                                                                        <option value="" disabled>Select Role
                                                                        </option>
                                                                        <option value="employee"
                                                                            {{ $user->role == 'employee' ? 'selected' : '' }}>
                                                                            Employee</option>
                                                                        <option value="hr"
                                                                            {{ $user->role == 'hr' ? 'selected' : '' }}>HR
                                                                        </option>
                                                                        <option value="accounts"
                                                                            {{ $user->role == 'accounts' ? 'selected' : '' }}>
                                                                            Accounts</option>
                                                                        <option value="gm"
                                                                            {{ $user->role == 'gm' ? 'selected' : '' }}>GM
                                                                        </option>
                                                                    </select>
                                                                   
                                                                </div>
                                                            </div>

                                                            </div>

                                                            <div class="col-12">
                                                                <label class="form-label" for="isManager">Is Manager</label>
                                                                <div class="d-flex">
                                                                    <div class="text-end icon-state switch-outline">
                                                                        <label class="switch mb-0">
                                                                            <input type="checkbox" id="isManager" name="is_manager" value="1" {{ $user->is_manager ? 'checked' : '' }}>
                                                                            <span class="switch-state bg-primary"></span>
                                                                        </label>
                                                                    </div>
                                                                    <label for="isManager" class="col-form-label m-l-10">Yes</label>
                                                                </div>
                                                            </div>

                                                           

                                                            <div class="text-center col-12">
                                                                <button type="submit" class="mt-1 btn btn-success me-1">
                                                                    <i class="icon-save"></i> Submit
                                                                </button>
                                                                <button type="reset"
                                                                    class="mt-1 btn btn-outline-secondary"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="icon-cancel"></i>Cancel
                                                                </button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- delete model --}}
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    {{-- add model --}}
                    <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCard"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="bg-transparent modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="pb-5 modal-body px-sm-5 mx-50">
                                    <h4 class="mb-1 text-center" id="addNewUserTitle">Add New User</h4>

                                    <!-- form -->
                                    <form id="addNewUserForm" action="{{ route('users.store') }}"
                                        class="row gy-1 gx-2 mt-75" method="POST">
                                        @csrf
                                        <!-- Name Field -->
                                        <div class="col-6">
                                            <label class="form-label" for="userName">Name</label>
                                            <div class="input-group input-group-merge">
                                                <input id="userName" name="name" class="form-control" type="text"
                                                    placeholder="User Name" required />

                                            </div>
                                        </div>

                                        <!-- Email Field -->
                                        <div class="col-6">
                                            <label class="form-label" for="userEmail">Email</label>
                                            <div class="input-group input-group-merge">
                                                <input id="userEmail" name="email" class="form-control" type="email"
                                                    placeholder="User Email" required />

                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="userName">Phone</label>
                                            <div class="input-group input-group-merge">
                                                <input id="userName" name="phone" class="form-control" type="text"
                                                    placeholder="phone " required />

                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label class="form-label" for="company_id">Company</label>
                                            <select id="company_id" name="company_id" class="form-control" required>
                                                <option value="" selected>Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <label class="form-label" for="department_id">Department</label>
                                            <select id="department_id" name="department_id" class="form-control">
                                                <option value="" disabled selected>Select Department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="team_id">Team</label>
                                            <select name="team_id" id="team_id" class="form-control">
                                                <option value="" disabled selected>Select Team </option>
                                                @foreach ($teams as $team)
                                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <!-- Job Title Field -->
                                        <div class="col-6">
                                            <label class="form-label" for="job_title">Job Title</label>
                                            <div class="input-group input-group-merge">
                                                <input id="job_title" name="job_title" class="form-control"
                                                    type="text" placeholder="Job Title" />

                                            </div>
                                        </div>

                                        <!-- User Role Field -->
                                        <div class="col-6">
                                            <label class="form-label" for="userRole">User Role</label>
                                            <div class="input-group input-group-merge">
                                                <select id="userRole" name="role" class="form-control" required>
                                                    <option value=""selected>Select Role</option>
                                                    <option value="employee">Employee</option>
                                                    <option value="hr">HR</option>
                                                    <option value="accounts">Accounts</option>
                                                    <option value="gm">GM</option>
                                                </select>

                                            </div>
                                        </div>


                                        <!-- Is Manager Field -->

                                        <div class="col-12">
                                            <div class="d-flex">
                                                <div class="text-end icon-state switch-outline">
                                                    <label class="switch mb-0">
                                                        <input type="checkbox" id="isManager" name="is_manager"
                                                            value="1">
                                                        <span class="switch-state bg-primary"></span>
                                                    </label>
                                                </div>
                                                <label for="isManager" class="col-form-label m-l-10"> Is Manager</label>
                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <label class="form-label" for="isManager">Is Manager</label>
                                            <div class="input-group input-group-merge">
                                                <input type="checkbox" id="isManager" name="is_manager"
                                                    value="1" />
                                                <label for="isManager">Yes</label>
                                            </div>
                                        </div> --}}



                                        <div class="text-center col-12">
                                            <button type="submit" class="mt-1 btn btn-success me-1">
                                                <i class="icon-save"></i> Submit
                                            </button>
                                            <button type="reset" class="mt-1 btn btn-outline-secondary"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                <i class="icon-cancel"></i>Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- add Export file  model --}}
                    {{-- استيراد المستخدمين من ملف إكسيل --}}
                    <div class="modal fade" id="addNewCard1" tabindex="-1" aria-labelledby="addNewCard"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <!-- رأس الـ modal -->
                                <div class="bg-transparent modal-header">
                                    <h5 class="modal-title" id="addNewCard"> </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <!-- جسم الـ modal -->
                                <div class="pb-5 modal-body px-sm-5 mx-50">
                                    <h4 class="mb-1 text-center">Add Export file</h4>

                                    <!-- نموذج رفع الملف -->
                                    <form action="{{ route('users.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <!-- حقل اختيار ملف -->
                                        <div class="mb-3">
                                            <label for="file" class="form-label">File </label>
                                            <input type="file" name="file" id="file" class="form-control"
                                                required>
                                        </div>

                                        <!-- زر استيراد -->
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary"> Export file </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!--/ add new card modal  -->
            </div>
            </section>

            <!-- AJAX Script -->

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#company_id').on('change', function() {
                var companyId = $(this).val();
                if (companyId) {
                    $.ajax({
                        url: '{{ route('get-departments-by-company') }}',
                        type: 'GET',
                        data: {
                            company_id: companyId
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('#department_id').empty();
                            $('#department_id').append(
                                '<option value="" selected disabled>Select Department</option>'
                            );
                            $.each(data, function(key, value) {
                                $('#department_id').append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching departments: ", error);
                            alert(
                                "An error occurred while fetching departments. Please try again."
                            );
                        }
                    });
                } else {
                    $('#department_id').empty();
                    $('#department_id').append(
                        '<option value="" selected disabled>Select Department</option>');
                }
            });
        });
    </script> --}}
        </div>
    </div>
@endsection


