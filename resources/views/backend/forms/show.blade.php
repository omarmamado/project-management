@extends('layouts.master')

@section('title', 'Employee Evaluation List')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Show Forms</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Project inquiry</li>
    <li class="breadcrumb-item active">Forms List</li>
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        <!-- modal trigger button -->
                        <div id="fields-container">
                            @foreach ($fields as $field)
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label>{{ $field['name'] }}:</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if ($field['type'] == 'text')
                                            <input type="text" name="fields[{{ $field['name'] }}]" class="form-control">
                                        @elseif ($field['type'] == 'date')
                                            <input type="date" name="fields[{{ $field['name'] }}]" class="form-control">
                                        @elseif ($field['type'] == 'number')
                                            <input type="number" name="fields[{{ $field['name'] }}]" class="form-control">
                                        @elseif ($field['type'] == 'textarea')
                                            <textarea name="fields[{{ $field['name'] }}]" class="form-control"></textarea>
                                        @elseif ($field['type'] == 'checkbox')
                                            <input type="checkbox" name="fields[{{ $field['name'] }}]" value="1">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>     
    </div>  
           


        @endsection
