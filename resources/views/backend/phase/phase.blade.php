@extends('layouts.master')

@section('title', 'Annual Employee EvaluationList')

@section('css')





@endsection
@section('style')
{{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">


<!-- JavaScript -->
<style>
    .select2-container {
        z-index: 9999 !important;
        /* تأكد من أن القائمة تظهر فوق المودال */
    }

    .select2-container {
        width: 100% !important;
        /* تأكد من أن العرض مناسب */
    }

    .select2-selection {
        border: 1px solid #ccc !important;
        /* تأكد من أن الحدود ظاهرة */
    }
</style>
@endsection



@section('breadcrumb-title')
    <h3>Project Inquiry Show </h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Project Inquiry</li>
    <li class="breadcrumb-item active">Project Inquiry Show</li>
@endsection
@section('content')
 
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">


            <div class="card">
                <div class="card-body">
                    <div class="dt-ext table-responsive">
                        <table class="display" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Phase Name</th>
                                            <th>Manager</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Assign</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($project->phases as $index => $phase)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $phase->name }}</td>
                                                <td>{{ $phase->manager->name ?? 'N/A' }}</td>
                                                <td>{{ $phase->start_date }}</td>
                                                <td>{{ $phase->end_date }}</td>
                                                <td>
                                                    <!-- عرض المستخدمين المضافين إلى المرحلة -->
                                                    @if ($phase->users->count() > 0)
                                                        {{-- <span> --}}
                                                            @foreach ($phase->users as $user)
                                                            <span class="badge bg-primary">{{ $user->name }} </span>
                                                            @endforeach
                                                        {{-- </span> --}}
                                                    @else
                                                        No users assigned.
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Button to Trigger Modal -->
                                                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#multiSelectModal{{ $phase->id }}">
                                                        Add Assign
                                                    </button> --}}

                                                    <!-- زر عرض تفاصيل المرحلة -->
                                                    {{-- <a href="{{ route('project_inquiry_phase.edit', ['project_inquiry_phase' => $phase->id]) }}" class="btn btn-primary btn-sm">
                                                                <i data-feather="edit"></i> Add Data
                                                            </a> --}}
                                                    @if ($phase->status == 'pending')
                                                        <a href="{{ route('project_inquiry_phase.approveOrRejectdetail', ['phase' => $phase->id]) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i data-feather=""></i> Approve Or Reject
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('project_inquiry_phase.edit', ['project_inquiry_phase' => $phase->id]) }}"
                                                        class="btn btn-primary btn-sm"
                                                        @if ($phase->dynamic_data && !empty($phase->dynamic_data)) style="display:none" @endif>
                                                        <i data-feather="edit"></i> Add Data
                                                    </a>


                                                    <a href="{{ route('project_inquiry_phase.detail', ['phase' => $phase->id]) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i data-feather="eye"></i> View Phase Details
                                                    </a>
                                                    <!-- Button to Trigger Modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#multiSelectModal{{ $phase->id }}">
                                                        Add Assign
                                                    </button>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No phases found for this project.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row-->
        </div> <!-- container -->
    </div> <!-- content -->

    <!-- Modals for Each Phase -->
    @foreach ($project->phases as $phase)
        <div class="modal fade" id="multiSelectModal{{ $phase->id }}" tabindex="-1"
            aria-labelledby="multiSelectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('phase.assignUsers', $phase->id) }}">
                    @csrf
                    @method('PUT') <!-- أو POST حسب الحاجة -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="multiSelectModalLabel">Select Users</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body">
                            <!-- Multi-Select Dropdown -->
                            <select name="user_id[]" id="user_id{{ $phase->id }}"class="js-example-placeholder-multiple col-sm-12" multiple="multiple"
                                required>
                                <option disabled>Select user</option>
                                @foreach ($users[$phase->id] as $user)
                                    <option value="{{ $user->id }}" data-job-title="{{ $user->job_title }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                        </div>
                       
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

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
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    @section('script')
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
@endsection

    {{-- 
    <script>
        $(document).ready(function() {
    $('.select2').select2();
});
    </script> --}}
@endsection
