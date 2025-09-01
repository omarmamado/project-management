@extends('layouts.master')

@section('title', 'Idea Roadmap')

@section('css')

@endsection
{{--
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection --}}

@section('breadcrumb-title')
    <h3>Idea Roadmap</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Idea Roadmap</li>
    <li class="breadcrumb-item active">Idea Roadmap</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewCard">
                            <i class="icon-plus"></i>


                            Add New
                        </button>
                        <div class="dt-ext table-responsive">
                            {{-- <br> --}}
                            <table class="display" id="export-button">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Project</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($roadmaps as $roadmap)
                                        <tr>
                                            <?php $i++; ?>
                                            <th>{{ $i }}</th>
                                            <td>
                                                <a href="{{ route('ideas.index', $roadmap->id) }}">
                                                    {{ $roadmap->name }}
                                                </a>
                                            </td>

                                            <td>{{ $roadmap->project->name }}</td>

                                            <td>

                                                <ul class="action">
                                                    <li class="edit">
                                                        <a href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#edit{{ $roadmap->id }}">
                                                            <i class="icon-pencil-alt"></i>
                                                        </a>
                                                    </li>
                                                    {{-- <li class="delete">
                                                        <a href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#delete{{ $roadmap->id }}">
                                                            <i class="icon-trash"></i>
                                                        </a>
                                                    </li> --}}
                                                </ul>

                                            </td>

                                        </tr>
                                        <div class="modal fade" id="edit{{ $roadmap->id }}" tabindex="-1"
                                            aria-labelledby="editIdeaRoadmapTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="bg-transparent modal-header">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="pb-5 modal-body px-sm-5 mx-50">
                                                        <h4 class="mb-3 text-center" id="editIdeaRoadmapTitle">Edit Idea
                                                            Roadmap</h4>

                                                        <!-- form -->
                                                        <form action="{{ route('idea-roadmaps.update', $roadmap->id) }}"
                                                            method="POST" enctype="multipart/form-data"
                                                            class="row gy-1 gx-2 mt-75">
                                                            @csrf
                                                            @method('PATCH')

                                                            <div class="mb-3 col-12">
                                                                <label class="form-label"
                                                                    for="name{{ $roadmap->id }}">Name</label>
                                                                <input type="text" id="name{{ $roadmap->id }}"
                                                                    name="name" class="form-control"
                                                                    placeholder="Idea Name" value="{{ $roadmap->name }}"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3 col-12">
                                                                <label class="form-label"
                                                                    for="description{{ $roadmap->id }}">Description</label>
                                                                <textarea id="description{{ $roadmap->id }}" name="description" class="form-control" rows="3"
                                                                    placeholder="Enter description">{{ $roadmap->description }}</textarea>
                                                            </div>

                                                            <div class="mb-3 col-12">
                                                                <label class="form-label"
                                                                    for="file{{ $roadmap->id }}">Replace File
                                                                    (optional)</label>
                                                                <input type="file" id="file{{ $roadmap->id }}"
                                                                    name="file" class="form-control">

                                                                @if ($roadmap->file)
                                                                    <div class="mt-2">
                                                                        <small class="text-muted">Current File:
                                                                            <a href="{{ asset('idea_roadmaps/' . $roadmap->file) }}"
                                                                                target="_blank">
                                                                                View File
                                                                            </a>
                                                                        </small>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="mt-2 text-center col-12">
                                                                <button type="submit" class="btn btn-success me-1">
                                                                    <i class="icon-save"></i> Save Changes
                                                                </button>
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="icon-cancel"></i> Cancel
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
                                            <div class="modal fade modal-danger text-start" id="delete{{ $roadmap->id }}"
                                                tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                                <form action="{{ route('company.destroy', $roadmap->id) }}" method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    <input id="id" type="hidden" name="id" class="form-control"
                                                        value="{{ $roadmap->id }}">
                                                    <br>

                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel120">
                                                                    Are Sure Of The Deleting Process ?
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                You cannot undo this action.
                                                            </div>
                                                            <div class="modal-footer">
                                                                {{-- <button type="submit" class="btn btn-danger"
                                                                    data-bs-dismiss="modal"><i class="icon-trash"></i>
                                                                    Delete
                                                                </button> --}}
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="icon-trash"></i> Delete
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
                </div>
            </div>


        </div>
        {{-- add model --}}
        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="bg-transparent modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="pb-5 modal-body px-sm-5 mx-50">
                        <h4 class="mb-1 text-center" id="addNewCardTitle">Add New Company</h4>

                        <!-- form -->
                        <form action="{{ route('idea-roadmaps.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label>Project</label>
                                {{-- <select name="project_id" class="form-control" required>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select> --}}
                                <select name="project_id" class="form-control" required>
                                    <option value="" disabled selected>Select Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Idea Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label>File (optional)</label>
                                <input type="file" name="file" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Save Idea</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script> --}}
@endsection
