@extends('layouts.master')

@section('title', 'Cash Category ')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Cash Category List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Cash Category</li>
    <li class="breadcrumb-item active">Cash Category List</li>
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
                                            <th scope=" col">ID</th>
                                            <th scope=" col">Name</th>

                                            <th scope=" col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach ($cash_categories as $cash_category)
                                            <tr>
                                                <?php $i++; ?>
                                                <th scope=" row">{{ $i }}</th>
                                                <td>{{ $cash_category->name }}</td>

                                                <td>

                                                    <ul class="action">
                                                        <li class="edit">
                                                            <a href="#!" data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $cash_category->id }}">
                                                                <i class="icon-pencil-alt"></i>
                                                            </a>
                                                        </li>
                                                        <li class="delete">
                                                            <a href="#!" data-bs-toggle="modal"
                                                                data-bs-target="#delete{{ $cash_category->id }}">
                                                                <i class="icon-trash"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>

                                            </tr>
                                            <div class="modal fade" id="edit{{ $cash_category->id }}" tabindex="-1"
                                                aria-labelledby="addNewCardTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="bg-transparent modal-header">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="pb-5 modal-body px-sm-5 mx-50">
                                                            <h4 class="mb-1 text-center" id="addNewCardTitle">Edit
                                                                Cash Category</h4>

                                                            <!-- form -->
                                                            <form id="addNewCardValidation"
                                                                action="{{ route('cash-category.update', $cash_category->id) }}"
                                                                class="row gy-1 gx-2 mt-75" method="POST"
                                                                onsubmit="return true">
                                                                {{ method_field('patch') }}
                                                                @csrf

                                                                <div class="col-12">
                                                                    <label class="form-label"
                                                                        for="modalAddCardNumber">Name</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <input id="modalAddCardNumber" name="name"
                                                                            class="form-control add-credit-card-mask"
                                                                            type="text" placeholder="New Categories"
                                                                            aria-describedby="modalAddCard2"
                                                                            data-msg="Please enter your credit card number"
                                                                            value="{{ $cash_category->name }}" />

                                                                    </div>

                                                                </div>
                                                                <input id="id" type="hidden" name="id"
                                                                    class="form-control" value="{{ $cash_category->id }}">
                                                                <div class="text-center col-12">
                                                                    <button type="submit"
                                                                        class="mt-1 btn btn-success me-1">
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
                                            <div class="d-inline-block">
                                                <!-- Modal -->
                                                <div class="modal fade modal-danger text-start"
                                                    id="delete{{ $cash_category->id }}" tabindex="-1"
                                                    aria-labelledby="myModalLabel120" aria-hidden="true">
                                                    <form action="{{ route('cash-category.destroy', $cash_category->id) }}"
                                                        method="post">
                                                        {{ method_field('Delete') }}
                                                        @csrf
                                                        <input id="id" type="hidden" name="id"
                                                            class="form-control" value="{{ $cash_category->id }}">
                                                        <br>

                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="myModalLabel120">
                                                                        Are Sure Of The Deleting Process ?
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    You cannot undo this action.
                                                                </div>
                                                                <div class="modal-footer">
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
                {{-- add model --}}
                <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="bg-transparent modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="pb-5 modal-body px-sm-5 mx-50">
                                <h4 class="mb-1 text-center" id="addNewCardTitle">Add New Cash Category</h4>

                                <!-- form -->
                                <form id="addNewCardValidation" action="{{ route('cash-category.store') }}"
                                    class="row gy-1 gx-2 mt-75" method="POST" onsubmit="return true">
                                    @csrf
                                    <div class="col-12">
                                        <label class="form-label" for="modalAddCardNumber">Name</label>
                                        <div class="input-group input-group-merge">
                                            <input id="modalAddCardNumber" name="name"
                                                class="form-control add-credit-card-mask" type="text"
                                                placeholder="New Categories" aria-describedby="modalAddCard2"
                                                data-msg="Please enter your credit card number" required />

                                        </div>
                                    </div>

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
            </div>

        </div>

    </div>
@endsection


