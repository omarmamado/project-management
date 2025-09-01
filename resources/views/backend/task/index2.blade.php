@extends('admin_dashboard')
@section('admin')
    <style>
        .columns-container {
            display: flex;
            gap: 15px;
            align-items: flex-start;
            overflow-x: auto;
            padding-bottom: 20px;
            min-height: calc(100vh - 40px);
        }

        .list {
            background: white;
            border-radius: 4px;
            min-width: 300px;
            max-width: 300px;
            padding: 15px;
        }

        .list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
        }

        .list-item {
            background: white;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .add-button {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
            background: none;
            border: none;
            width: 100%;
            text-align: right;
            padding: 8px 0;
            cursor: pointer;
        }

        .add-button:hover {
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }

        .add-list {
            min-width: 300px;
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .options-button {
            background: none;
            border: none;
            color: #666;
            padding: 4px 8px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
    <!-- content -->
    <div class="pagetitle">
        <h1>Projects List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Projects List</li>
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
                        </h5>

                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Project owner</th>
                                    <th>Name</th>
                                    <th>Note</th>
                                    <th> Assign Manager</th>
                                    <th>Assign</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($projects as $project)
                                    <tr>
                                        <?php $i++; ?>
                                        <th scope=" row">{{ $i }}</th>
                                        <td>
                                            {{ $project->creator->name }}
                                        </td>
                                        <td>{{ $project->name }}</td>
                                        <td>
                                            {{ implode(' ', array_slice(explode(' ', $project->note), 0, 10)) }}
                                        </td>
                                        <td>
                                            {{ $project->manager->name }}
                                        </td>
                                        <td>
                                            <h4>
                                            @foreach ($project->users as $user)
                                            <span class="badge bg-primary me-1">{{ $user->name }}</span>
                                        @endforeach
                                    </h4>
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $project->id }}">
                                                <i data-feather="edit" class="me-50"></i> Edit
                                            </button>

                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $project->id }}" class="btn btn-success btn-sm">
                                                <i data-feather="file-plus" class="me-50"></i> Add Assign
                                            </button>
                                            {{-- <a href=" {{ route('projects.create', ['project_id' => $project->id]) }}"
                                                type="button" class="btn btn-primary btn-sm">
                                                <i data-feather='file-plus'></i> Add New 
                                            </a>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="collapse"
                                                data-bs-target="#documents-{{ $project->id }}">
                                                <i class="bi bi-chevron-down"></i> View Tasks
                                            </button> --}}
                                        </td>

                                    </tr>
                                    {{-- <tr>
                                        <td colspan="7" class="p-0">
                                            <div class="collapse" id="documents-{{ $project->id }}">
                                                <div class="card card-body">
                                                    <table id="example2" class="table text-center table-striped" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Task Name</th>
                                                                <th>Priority</th>
                                                                <th>Status</th>
                                                                <th>Assigned By</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($project->tasks as $task)
                                                                <tr>
                                                                    <td>{{ $task->name }}</td>
                                                                    <td>{{ ucfirst($task->priority) }}</td>
                                                                    <td>{{ ucfirst($task->status) }}</td>
                                                                    <td>{{ $task->createdBy->name }}</td> 
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr> --}}
                                    {{-- edit modal --}}
                                    <div class="modal fade" id="edit{{ $project->id }}" tabindex="-1"
                                        aria-labelledby="addNewCardTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="bg-transparent modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="pb-5 modal-body px-sm-5 mx-50">
                                                    <h1 class="mb-1 text-center" id="addNewCardTitle">Edit
                                                        Project</h1>

                                                    <!-- form -->
                                                    <form id="addNewCardValidation"
                                                        action="{{ route('projects.update', $project->id) }}"
                                                        class="row gy-1 gx-2 mt-75" method="POST" onsubmit="return true">
                                                        {{ method_field('patch') }}
                                                        @csrf
                                                        <input id="id" type="hidden" name="id"
                                                            class="form-control" value="{{ $project->id }}">

                                                        <div class="row">


                                                            <div class="col-6">
                                                                <label class="form-label"
                                                                    for="modalAddCardNumber">Name</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input id="modalAddCardNumber" name="name"
                                                                        value="{{ $project->name }}""
                                                                        class="form-control add-credit-card-mask"
                                                                        type="text" aria-describedby="modalAddCard2"
                                                                        data-msg="Please enter your credit card number" />
                                                                    <span class="cursor-pointer input-group-text p-25"
                                                                        id="modalAddCard2">
                                                                        <span class="add-card-type"></span>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                         
                                                            <div class="col-6">
                                                                <label class="form-manager_id"
                                                                    for="modalAddCardNumber">Manger</label>
                                                                <div class="input-group input-group-merge">
                                                                    <select id="manager_id" name="manager_id"
                                                                        class="form-control add-credit-card-mask"
                                                                        id="modalAddCardNumber"
                                                                        class="my-1 custom-select mr-sm-2" required>
                                                                        <option value="" disabled selected>
                                                                            Select Manger</option>

                                                                       

                                                                            @foreach ($managers as $manager)
                                                                            <option value="{{ $manager->id }}"
                                                                                {{ isset($project) && $project->manager_id == $manager->id ? 'selected' : '' }}>
                                                                                {{ $manager->name }}
                                                                            </option>
                                                                        @endforeach
                                                                        
                                                                    </select>
                                                                    <span class="cursor-pointer input-group-text p-25"
                                                                        id="modalAddCard2">
                                                                        <span class="add-card-type"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="request_name"> Note</label>
                                                            <textarea name="note" id=""class="form-control" cols="15" rows="3" >{{ $project->note }}</textarea>
                                                        </div>

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
                                    {{-- delete model --}}
                                    <div class="d-inline-block">
                                        <!-- Modal -->
                                        <div class="modal fade modal-danger text-start" id="delete{{ $project->id }}"
                                            tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                            <form action="{{ route('projects.addUsers', $project->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel120">
                                                                Add Users
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group col-12">
                                                                <label for="users">Select Users</label>
                                                                <select name="user_ids[]" class="form-control select2-multiple" data-toggle="select2" data-width="100%" multiple="multiple">
                                                                    @if ($project->manager)
                                                                        @if ($project->manager->team && $project->manager->team->users->count() > 0)
                                                                            <!-- إذا كان لمدير المشروع فريق -->
                                                                            @foreach ($project->manager->team->users as $user)
                                                                                <option value="{{ $user->id }}" 
                                                                                    {{ in_array($user->id, old('user_ids', $project->users ? $project->users->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                                                                    {{ $user->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        @elseif ($project->manager->department && $project->manager->department->users->count() > 0)
                                                                            <!-- إذا لم يكن لمدير المشروع فريق ولكن لديه قسم -->
                                                                            @foreach ($project->manager->department->users as $user)
                                                                                <option value="{{ $user->id }}" 
                                                                                    {{ in_array($user->id, old('user_ids', $project->users ? $project->users->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                                                                    {{ $user->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        @else
                                                                            <!-- لا يوجد فريق أو قسم لمدير المشروع -->
                                                                            <option value="" disabled>No users available for selection</option>
                                                                        @endif
                                                                    @else
                                                                        <!-- لا يوجد مدير محدد للمشروع -->
                                                                        <option value="" disabled>No manager assigned to the project</option>
                                                                    @endif
                                                                </select>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary btn-sm"><i
                                                                    data-feather="file-plus" class="me-50"></i>
                                                                Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
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
                                <h1 class="mb-1 text-center" id="addNewCardTitle">Add New Project</h1>

                                <!-- form -->
                                <form id="addNewCardValidation" action="{{ route('projects.store') }}"
                                    class="row gy-1 gx-2 mt-75" method="POST" onsubmit="return true">
                                    @csrf
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
                                        <label class="form-manager_id" for="modalAddCardNumber">Manger</label>
                                        <div class="input-group input-group-merge">
                                            <select id="manager_id" name="manager_id"
                                                class="form-control add-credit-card-mask" id="modalAddCardNumber"
                                                class="my-1 custom-select mr-sm-2" required>
                                                <option value="" disabled selected>
                                                    Select Manger</option>

                                                @foreach ($managers as $manager)
                                                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                <span class="add-card-type"></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="request_name"> Note</label>
                                        <textarea name="note" id=""class="form-control" cols="15" rows="3"placeholder="Note"
                                            required></textarea>
                                    </div>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- <script>
        $(document).ready(function() {
            // عند تغيير القسم (Department)
            $('#department_id').on('change', function() {
                var departmentId = $(this).val();

                // إرسال طلب AJAX لجلب الفرق أو المستخدمين
                $.ajax({
                    url: '/get-teams-or-managers/' + departmentId,
                    method: 'GET',
                    success: function(response) {
                        var teamHtml = '';
                        var managerHtml = '';

                        // إذا كان هناك فرق (teams)، عرض الفرق في select
                        if (response.teams && response.teams.length > 0) {
                            teamHtml = '<label for="team_id">Select Team</label>';
                            teamHtml +=
                                '<select id="team_id" name="team_id" class="form-control">';
                            teamHtml +=
                                '<option value="" disabled selected>Select Team</option>';
                            $.each(response.teams, function(index, team) {
                                teamHtml += '<option value="' + team.id + '">' + team
                                    .name + '</option>';
                            });
                            teamHtml += '</select>';
                        } else {
                            // إذا لم يكن هناك فرق، عرض المستخدمين الذين لديهم صلاحية is_manager
                            managerHtml =
                                '<label for="department_manager_id">Select Manager</label>';
                            managerHtml +=
                                '<select name="department_manager_id" class="form-control">';
                            managerHtml +=
                                '<option value="" disabled selected>Select Manager</option>';
                            if (response.managers && response.managers.length > 0) {
                                $.each(response.managers, function(index, manager) {
                                    managerHtml += '<option value="' + manager.id +
                                        '">' + manager.name + '</option>';
                                });
                            } else {
                                managerHtml +=
                                    '<option value="" disabled>No Managers Available</option>';
                            }
                            managerHtml += '</select>';
                        }

                        // إضافة محتوى الفرق والمستخدمين
                        $('#team_or_manager').html(teamHtml + managerHtml);
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error); // عرض الخطأ في الكونسول
                        alert('حدث خطأ أثناء جلب البيانات.');
                    }
                });
            });

            // عند تغيير الفريق (Team)
            $(document).on('change', '#team_id', function() {
                var teamId = $(this).val();

                // إرسال طلب AJAX لجلب المستخدمين is_manager في الفريق
                $.ajax({
                    url: '/get-team-managers/' + teamId,
                    method: 'GET',
                    success: function(response) {
                        var managerHtml =
                            '<label for="department_manager_id">Select Manager</label>';
                        managerHtml +=
                            '<select name="department_manager_id" class="form-control">';
                        managerHtml +=
                            '<option value="" disabled selected>Select Manager</option>';
                        if (response.managers && response.managers.length > 0) {
                            $.each(response.managers, function(index, manager) {
                                managerHtml += '<option value="' + manager.id + '">' +
                                    manager.name + '</option>';
                            });
                        } else {
                            managerHtml +=
                                '<option value="" disabled>No Managers Available</option>';
                        }
                        managerHtml += '</select>';

                        // إضافة قائمة المديرين بجانب قائمة الفرق
                        $('#team_or_manager').append(managerHtml);
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error);
                        alert('حدث خطأ أثناء جلب البيانات.');
                    }
                });
            });
        });
    </script> --}}

    {{-- <script>
    function addNewList() {
        const columnsContainer = document.querySelector('.columns-container');
        const addListButton = document.querySelector('.add-list');

        const newList = document.createElement('div');
        newList.className = 'list';
        newList.innerHTML = `
            <div class="list-header">
                <h6 class="mb-0">قائمة جديدة</h6>
                <button class="options-button">⋮</button>
            </div>
            <button class="add-button">
                + إضافة بطاقة
            </button>
        `;

        columnsContainer.insertBefore(newList, addListButton);

        // إضافة وظيفة إضافة البطاقات
        const addButton = newList.querySelector('.add-button');
        addButton.addEventListener('click', () => addNewCard(newList));
    }

    function addNewCard(list) {
        const addButton = list.querySelector('.add-button');

        const newCard = document.createElement('div');
        newCard.className = 'list-item';
        newCard.textContent = 'مهمة جديدة';

        list.insertBefore(newCard, addButton);
    }

    // إضافة مستمعي الأحداث للأزرار الموجودة
    document.querySelectorAll('.add-button').forEach(button => {
        button.addEventListener('click', () => addNewCard(button.closest('.list')));
    });
</script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
