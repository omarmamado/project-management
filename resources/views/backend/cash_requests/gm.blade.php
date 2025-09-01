@extends('layouts.master')

@section('title', 'Cash Requests ')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Cash Requests List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Cash Requests</li>
    <li class="breadcrumb-item active">Cash Requests List</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCashRequest">
                            <i class="icon-plus"></i>


                            Add New
                        </button> --}}
                        <div class="dt-ext table-responsive">
                            {{-- <br> --}}

                            <table class="display" id="export-button">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>

                                        <th>Request Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Request Note</th>
                                        <th>Status</th>
                                        <th>Requester</th>
                                        <th>Company</th>

                                        <th>Action</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($requests as $request)
                                        <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>{{ $request->request_name }}</td>
                                            <td>{{ $request->request_date }}</td>
                                            <td>{{ $request->due_date }}</td>
                                            <td>{{ $request->amount }}</td>
                                            <td>{{ $request->reason }}</td>

                                            <td>
                                                @if ($request->status == 'approved_by_manager')
                                                    <span class="badge badge-glow bg-success">Approved by Manager</span>
                                                @elseif($request->status == 'approved_by_accounts')
                                                    <span class="badge badge-glow bg-success">Approved by Accounts</span>
                                                @elseif($request->status == 'approved_by_gm')
                                                    <span class="badge badge-glow bg-success">Approved by GM</span>
                                                @elseif($request->status == 'rejected')
                                                    <span class="badge badge-glow bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge badge-glow bg-primary">Pending</span>
                                                @endif
                                            </td>

                                            </td>
                                            <td>{{ $request->user->name }}</td>
                                            <td>{{ $request->user->company->name ?? 'N/A' }}</td>

                                            <td>
                                                @if (auth()->user()->role === 'gm' && auth()->user()->is_manager)
                                                    @if ($request->status === 'approved_by_accounts' || $request->status === 'approved_by_manager')
                                                        <form method="POST"
                                                            action="{{ route('cash_requests.update_status', $request->id) }}"
                                                            style="display: inline;">
                                                            {{ csrf_field() }}
                                                            {{ method_field('put') }}
                                                            <input type="hidden" name="action" value="approve">
                                                            <button type="submit" class="btn btn-link p-0">
                                                                <i data-feather="check" class="text-success"></i>
                                                            </button>
                                                        </form>
                                            
                                                        <form method="POST"
                                                            action="{{ route('cash_requests.update_status', $request->id) }}"
                                                            style="display: inline;">
                                                            {{ csrf_field() }}
                                                            {{ method_field('put') }}
                                                            <input type="hidden" name="action" value="reject">
                                                            <button type="submit" class="btn btn-link p-0">
                                                                <i data-feather="x" class="text-danger"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-link p-0" disabled>
                                                            <i data-feather="check" class="text-muted"></i>
                                                        </button>
                                                        <button class="btn btn-link p-0" disabled>
                                                            <i data-feather="x" class="text-muted"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                            </td>

                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit{{ $request->id }}" tabindex="-1"
                                            aria-labelledby="editCashRequest" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Edit Cash Request</h5>
                                                        <form action="{{ route('cash_requests.update', $request->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('patch')
                                                            <!-- Form fields for editing the request -->
                                                            <!-- Add fields for amount, request name, due date, etc. -->
                                                            <div class="form-group">
                                                                <label for="amount">Amount</label>
                                                                <input type="number" name="amount" class="form-control"
                                                                    value="{{ $request->amount }}" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="request_name">Request Name</label>
                                                                <input type="text" name="request_name"
                                                                    class="form-control"
                                                                    value="{{ $request->request_name }}" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="due_date">Due Date</label>
                                                                <input type="date" name="due_date" class="form-control"
                                                                    value="{{ $request->due_date }}" required>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Save
                                                                    changes</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Edit Modal -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Add Cash Request Modal -->
                    <div class="modal fade" id="addCashRequest" tabindex="-1" aria-labelledby="addCashRequestTitle"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>Add New Cash Request</h5>
                                    <form action="{{ route('cash_requests.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="requester_name">Requester Name</label>
                                            <input type="text" name="request_name" class="form-control"
                                                placeholder="request_name " required>
                                        </div>

                                        <div class="form-group">
                                            <label for="request_date">Request Date</label>
                                            <input type="date" name="request_date" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="due_date">Due Date</label>
                                            <input type="date" name="due_date" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="number" name="amount" class="form-control"
                                                placeholder="Amount" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="request_name">Request Reason</label>
                                            <input type="text" name="reason" class="form-control"
                                                placeholder="Request reason" required>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Add Cash Request Modal -->
                </div>
            </div>
        </div>

    </div>

            </section>

        @endsection
