@extends('layouts.master')

@section('title', 'Employee Evaluation List')

@section('css')

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

@endsection

@section('breadcrumb-title')
    <h3>Projects List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Project</li>
    <li class="breadcrumb-item active">Projects List</li>
@endsection

<!-- content -->
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addNewCard">
                            <i class="icon-plus"></i> Add New
                        </button>

                           
                        </h5>

                        <div class="dt-ext table-responsive">
                            <br>
                            <table class="display" id="export-button">
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
                                                    <i class="icon-pencil-alt" class="me-50"></i> Edit
                                                </button>

                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#delete{{ $project->id }}"
                                                    class="btn btn-success btn-sm">
                                                    <i class="icon-plus" class="me-50"></i> Add Assign
                                                </button>
                                               
                                            </td>

                                        </tr>
                                   
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
                                                        <h4 class="mb-1 text-center" id="addNewCardTitle">Edit
                                                            Project</h4>

                                                        <!-- form -->
                                                        <form id="addNewCardValidation"
                                                            action="{{ route('projects.update', $project->id) }}"
                                                            class="row gy-1 gx-2 mt-75" method="POST"
                                                            onsubmit="return true">
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
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="request_name"> Note</label>
                                                                <textarea name="note" id=""class="form-control" cols="15" rows="3">{{ $project->note }}</textarea>
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
                                        {{-- Add Assign Users --}}
                                        <div class="d-inline-block">
                                            <!-- Modal -->
                                            <div class="modal fade modal-danger text-start" id="delete{{ $project->id }}"
                                                tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                                <form action="{{ route('projects.addUsers', $project->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel120">
                                                                    Add Assign Users
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group col-12">
                                                                    <label for="users">Select Users</label>
                                                                    <select name="user_ids[]"
                                                                        class="form-control select2-multiple"
                                                                        data-toggle="select2" data-width="100%"
                                                                        multiple="multiple">
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
                                                                                <option value="" disabled>No users
                                                                                    available for selection</option>
                                                                            @endif
                                                                        @else
                                                                            <!-- لا يوجد مدير محدد للمشروع -->
                                                                            <option value="" disabled>No manager
                                                                                assigned to the project</option>
                                                                        @endif
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary btn-sm"><i class="icon-plus"></i>
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
                                    <h4 class="mb-1 text-center" id="addNewCardTitle">Add New Project</h4>

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
                                               
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="request_name"> Note</label>
                                            <textarea name="note" id=""class="form-control" cols="15" rows="3"placeholder="Note"
                                                required></textarea>
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
                    <!--/ add new card modal  -->
                </div>
            </div>
        </div>
    </div>
                </section>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            @endsection
