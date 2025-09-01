@extends('layouts.master')

@section('title', 'Edit Evaluation')

@section('css')
    <style>
        /* تجاوز الستايل الأساسي باستخدام محددات أكثر تحديداً */
        .page-wrapper .card .card-header {
            background-color: #7c6bdd !important;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            padding: 1rem;
        }

        .page-wrapper .card .card-header h4,
        .page-wrapper .card .card-header .card-title {
            color: #ffffff !important;
            margin-bottom: 0;
        }

        /* تأكيد على الستايلات الأخرى */
        .page-wrapper .card {
            border: none !important;
            transition: transform 0.2s;
            margin-bottom: 1.5rem;
        }

        .page-wrapper .card:hover {
            transform: translateY(-2px);
        }

        .page-wrapper .table th {
            /* background-color: #f8f9fa !important; */
            font-weight: 600;
        }

        .page-wrapper .form-control:focus,
        .page-wrapper .form-select:focus {
            border-color: #80bdff !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25) !important;
        }

        .page-wrapper .btn-primary {
            padding: 0.5rem 2rem !important;
            font-weight: 500;
            background-color: #7c6bdd !important;
            border-color: #7c6bdd !important;
        }

        .page-wrapper .text-muted {
            font-style: italic !important;
        }
    </style>

@endsection



@section('breadcrumb-title')
    <h3>Show Employee Evaluation</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">HR</li>
    <li class="breadcrumb-item">Employee Evaluation</li>

    <li class="breadcrumb-item active">Show Employee Evaluation</li>
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <div class="container-fluid py-4">
        @php
            // Define variables at the beginning of the file
            $isManager = auth()->user()->is_manager ?? false;
            $isGmOrHr = auth()->user()->role === 'gm' ?? false;
            $user = auth()->user();
        @endphp
        <form action="{{ route('employee-evaluation.update', $evaluation->id) }}" method="post" class="form"
            enctype="multipart/form-data">
            {{ method_field('patch') }}
            @csrf
            <!-- Employee Information Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h4 class="card-title mb-0">Employee Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <p class="form-control-static">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Job Title</label>
                                <p class="form-control-static">{{ $users->job_title ?? 'Not Specified' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Core Values and Objectives Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h4 class="card-title text-center mb-0">Core Values and Objectives</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tech-companies-1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th> PERFORMANCE CATEGORY</th>

                                    <th> RATING</th>
                                    <th> COMMENTS BY HEADS</th>
                                    <th> COMMENTS BY EMPLOYEE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> Initiative & Flexibility:</td>
                                    <td>
                                        <input type="text" id="initiative_flexibility" class=" form-control" readonly
                                            value="{{ $evaluation->initiative_flexibility ?? 'Data not added' }}">
                                    </td>

                                    <td>
                                        <textarea id="modalAddCardNumber" name="initiative_comment_manager" class="form-control add-credit-card-mask"
                                            rows="4"disabled placeholder="COMMENTS BY HEADS">{{ $evaluation->initiative_comment_manager }}</textarea>
                                    </td>
                                    <td>
                                        <textarea id="modalAddCardNumber" name="initiative_comment_employee" class="form-control add-credit-card-mask"
                                            rows="4" value=""disabled>{{ $evaluation->initiative_comment_employee }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Knowledge of Position:</td>
                                    <td>
                                        <input type="text" id="initiative_flexibility" class=" form-control" readonly
                                            value="{{ $evaluation->knowledge_position ?? 'Data not added' }}">

                                    </td>

                                    <td>
                                        <textarea id="modalAddCardNumber" name="knowledge_comment_manager" class="form-control add-credit-card-mask"
                                            rows="4"disabled placeholder="COMMENTS BY HEADS">{{ $evaluation->knowledge_comment_manager }}</textarea>
                                    </td>
                                    <td>
                                        <textarea id="modalAddCardNumber" name="knowledge_comment_employee" class="form-control add-credit-card-mask"
                                            rows="4" disabled placeholder="COMMENTS BY EMPLOYEE">{{ $evaluation->knowledge_comment_employee }}</textarea>
                                    </td>
                                </tr>
                                <td> Time Effectiveness, Time Responsiveness & Availability:</td>
                                <td>
                                    <input type="text" id="initiative_flexibility" class=" form-control" readonly
                                        value="{{ $evaluation->time_effectiveness ?? 'Data not added' }}">

                                </td>

                                <td>
                                    <textarea id="modalAddCardNumber" name="time_comment_manager" class="form-control add-credit-card-mask"disabled
                                        rows="4" placeholder="COMMENTS BY HEADS">{{ $evaluation->time_comment_manager }}</textarea>

                                <td>
                                    <textarea id="modalAddCardNumber" name="time_comment_employee" class="form-control add-credit-card-mask" rows="4"
                                        placeholder="COMMENTS BY EMPLOYEE" disabled>{{ $evaluation->time_comment_employee }}</textarea>

                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Overall Rating Card -->
            @if ($isGmOrHr)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h4 class="card-title text-center mb-0">Overall Rating</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Overall Rating</label>
                                    <input type="text" id="overall_rating" class=" form-control" readonly
                                        value="{{ $evaluation->overall_rating ?? 'Data not added' }}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Final Comment</label>
                                    <textarea id="modalAddCardNumber" name="overall_comment" class="form-control add-credit-card-mask" rows="4"
                                        placeholder=""disabled>{{ $evaluation->overall_comment }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    </form>
</div>


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
@endsection
