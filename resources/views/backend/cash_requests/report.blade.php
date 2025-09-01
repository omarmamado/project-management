@extends('layouts.master')

@section('title', 'Cash Request Report ')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Cash Request Report</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Cash Request </li>
    <li class="breadcrumb-item active">Cash Request Report</li>
@endsection

@section('content')
 
    <!-- Search and Report Section -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <!-- Search Form -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Filter by Date or Category</h5>
                        <form action="{{ route('cash_requests.report') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="cash_category_id" class="form-label">Expense Category</label>
                                    <select id="cash_category_id" name="cash_category_id" class="form-control">
                                        <option value="">All Categories</option>
                                        @foreach($cash_categories as $category)
                                            <option value="{{ $category->id }}" {{ request('cash_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Report Results -->
                @if(isset($requests))
                    <div class="mt-4 card">
                        <div class="card-body">
                            <h5 class="card-title">Report Results</h5>
                            <div class="dt-ext table-responsive">
                                <table class="display" id="export-button">
                                 <thead>
                                    <tr>
                                        <th>Request Name</th>
                                        <th>Reason</th>
                                        <th>Request Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($requests as $request)
                                        <tr>
                                            <td>{{ $request->request_name }}</td>
                                            <td>{{ $request->reason }}</td>
                                            <td>{{ $request->request_date }}</td>
                                            <td>{{ $request->due_date }}</td>
                                            <td>{{ $request->amount }}</td>
                                            <td>{{ $request->cashCategory->name  ?? 'N/A'}}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $request->status)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No data found for the selected criteria.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <strong>Total Expenses:</strong>  £{{ $total_amount }}
                            </div>
                          
                    </div>
                @endif
            </div>
        </div>
    </section>
    @endsection

  

    