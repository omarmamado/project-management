@extends('layouts.master')

@section('title', 'Create Evaluation')

@section('css')
<style>
    /* تجاوز الستايل الأساسي باستخدام محددات أكثر تحديداً */
    .page-wrapper .card .card-header {
        background-color: #7c6bdd !important;
        border-bottom: 1px solid rgba(0,0,0,.125);
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
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important;
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
    <h3>Create Evaluation</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">HR</li>
    <li class="breadcrumb-item">Employee Evaluation</li>

    <li class="breadcrumb-item active">Create Evaluation</li>
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
    
        <form action="{{ route('employee-evaluation.store') }}" method="post" class="form" enctype="multipart/form-data">
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
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle" width="25%">Performance Category</th>
                                    <th class="align-middle" width="20%">Rating</th>
                                    <th class="align-middle" width="27.5%">Manager Comments</th>
                                    <th class="align-middle" width="27.5%">Employee Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Initiative & Flexibility -->
                                <tr>
                                    <td class="align-middle fw-bold">Initiative & Flexibility</td>
                                    <td>
                                        @if ($isManager)
                                            <select name="initiative_flexibility" class="form-select">
                                                <option value="Exceeds expectations">Exceeds expectations</option>
                                                <option value="Meets expectations">Meets expectations</option>
                                                <option value="Needs improvement">Needs improvement</option>
                                                <option value="Unacceptable">Unacceptable</option>
                                            </select>
                                        @else
                                            <span class="text-muted">Not authorized to add</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($isManager)
                                            <textarea name="initiative_comment_manager" class="form-control" rows="3" placeholder="Add your comment here..."></textarea>
                                        @else
                                            <span class="text-muted">Not authorized to add</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$isManager)
                                            <textarea name="initiative_comment_employee" class="form-control" rows="3" placeholder="Add your comment here..."></textarea>
                                        @else
                                            <span class="text-muted">Not authorized to add</span>
                                        @endif
                                    </td>
                                </tr>
    
                                <!-- Knowledge of Position -->
                                <tr>
                                    <td class="align-middle fw-bold">Knowledge of Position</td>
                                    <td>
                                        @if ($isManager)
                                            <select name="knowledge_position" class="form-select">
                                                <option value="Exceeds expectations">Exceeds expectations</option>
                                                <option value="Meets expectations">Meets expectations</option>
                                                <option value="Needs improvement">Needs improvement</option>
                                                <option value="Unacceptable">Unacceptable</option>
                                            </select>
                                        @else
                                            <span class="text-muted">Not authorized to add</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($isManager)
                                            <textarea name="knowledge_comment_manager" class="form-control" rows="3" placeholder="Add your comment here..."></textarea>
                                        @else
                                            <span class="text-muted">Not authorized to add</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$isManager)
                                            <textarea name="knowledge_comment_employee" class="form-control" rows="3" placeholder="Add your comment here..."></textarea>
                                        @else
                                            <span class="text-muted">Not authorized to add</span>
                                        @endif
                                    </td>
                                </tr>
    
                                <!-- Time Effectiveness -->
                                <tr>
                                    <td class="align-middle fw-bold">Time Effectiveness, Time Responsiveness & Availability</td>
                                    <td>
                                        @if ($isGmOrHr)
                                            <select name="time_effectiveness" class="form-select">
                                                <option value="Exceeds expectations">Exceeds expectations</option>
                                                <option value="Meets expectations">Meets expectations</option>
                                                <option value="Needs improvement">Needs improvement</option>
                                                <option value="Unacceptable">Unacceptable</option>
                                            </select>
                                        @else
                                            <span class="text-muted">Not authorized to add</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($isGmOrHr)
                                            <textarea name="time_comment_manager" class="form-control" rows="3" placeholder="Add your comment here..."></textarea>
                                        @else
                                            <span class="text-muted">Not authorized to add</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($isGmOrHr)
                                            <textarea name="time_comment_employee" class="form-control" rows="3" placeholder="Add your comment here..."></textarea>
                                        @else
                                            <span class="text-muted">Not authorized to add</span>
                                        @endif
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
                                <select name="overall_rating" class="form-select">
                                    <option value="Exceeds expectations">Exceeds expectations</option>
                                    <option value="Meets expectations">Meets expectations</option>
                                    <option value="Needs improvement">Needs improvement</option>
                                    <option value="Unacceptable">Unacceptable</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Final Comment</label>
                                <textarea name="overall_comment" class="form-control" rows="3" placeholder="Add your final comment here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
    
            <!-- Save Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i> Save Evaluation
                </button>
            </div>
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
