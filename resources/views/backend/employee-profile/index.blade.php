@extends('layouts.master')

@section('title')
    Employee Profile
@endsection

@section('css')
    <link href="{{ URL::asset('/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <!-- BEGIN: Vendor CSS-->
@endsection

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        @if ($errors->any())
            <div class="error">{{ $errors->first('Name') }}</div>
        @endif

        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Employee Profile</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a>
                                    </li>

                                    <li class="breadcrumb-item active">Employee Profile
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header row">
            </div>
            <!-- users list start -->
            <div class="content-body">
                <section class="app-user-list">

                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body">

                            <!-- modal trigger button -->
                            @can('create users')
                                <a href="{{ route('employee-evaluation.create') }}" type="button" class="btn btn-primary btn-sm">
                                    <i data-feather='file-plus'></i> Add New
                                </a>
                            @endcan
                            <br>
                            <table id="example2" class="table table-striped text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Training Start Date</th>
                                        <th>Training End Date</th>
                                        <th>Contract Start Date</th>
                                        <th>Contract End Date</th>
                                        {{-- <th>Contract Renewed</th> --}}
                                        <th>Documents</th>
                                        <th>Processes</th>                                
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{ $employee->name }}</td>
                                            <td>{{ $employee->EmployeeTraining?->training_start_date ?? 'Not Available' }}
                                            </td>
                                            <td>{{ $employee->EmployeeTraining?->training_end_date ?? 'Not Available' }}
                                            </td>
                                            <td>{{ $employee->employmentcontracts->last()?->start_date ?? 'Not Available' }}
                                            </td>
                                            <td>{{ $employee->employmentcontracts->last()?->end_date ?? 'Not Available' }}
                                            </td>
                                            {{-- <td>{{ $employee->employmentcontracts->last()?->is_renewed ? 'Yes' : 'No' }}</td> --}}
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="collapse"
                                                    data-bs-target="#documents-{{ $employee->id }}">
                                                    <i class="bi bi-chevron-down"></i> View Documents
                                                </button>
                                            </td>
                                            <td>
                                                <a href="{{route('employee-profile.edit', $employee->id)}}" type="button"
                                                    class="btn btn-info btn-sm" title="Edit">
                                                     <i data-feather="edit"></i>
                                                 </a>
                                               
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="p-0">
                                                <div class="collapse" id="documents-{{ $employee->id }}">
                                                    <div class="card card-body">
                                                        <table id="example2" class="table table-striped text-center" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Id Card</th>
                                                                    <th>Birth Certificate</th>
                                                                    <th>Graduation Certificate</th>
                                                                    <th>Military Certificate</th>
                                                                    <th>Criminal Record</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        @if ($employee->employmentDocuments && $employee->employmentDocuments->id_card)
                                                                        <a href="{{ asset($employee->employmentDocuments->id_card) }}" target="_blank">
                                                                            <img width="50px" src="{{ asset($employee->employmentDocuments->id_card) }}" alt="ID Card">
                                                                        </a>
                                                                        @else
                                                                            Not Available
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($employee->employmentDocuments && $employee->employmentDocuments->birth_certificate)
                                                                            <a href="{{ asset($employee->employmentDocuments->birth_certificate) }}" target="_blank">
                                                                                <img width="50px" src="{{ asset($employee->employmentDocuments->birth_certificate) }}" alt="Birth Certificate">
                                                                            </a>
                                                                        @else
                                                                            Not Available
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($employee->employmentDocuments && $employee->employmentDocuments->graduation_certificate)
                                                                            <a href="{{ asset($employee->employmentDocuments->graduation_certificate) }}" target="_blank">
                                                                                <img width="50px" src="{{ asset($employee->employmentDocuments->graduation_certificate) }}" alt="Graduation Certificate">
                                                                            </a>
                                                                        @else
                                                                            Not Available
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($employee->employmentDocuments && $employee->employmentDocuments->criminal_record)
                                                                            <a href="{{ asset($employee->employmentDocuments->criminal_record) }}" target="_blank">
                                                                                <img width="50px" src="{{ asset($employee->employmentDocuments->criminal_record) }}" alt="Criminal Record">
                                                                            </a>
                                                                        @else
                                                                            Not Available
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($employee->employmentDocuments && $employee->employmentDocuments->military_certificate)
                                                                            <a href="{{ asset($employee->employmentDocuments->military_certificate) }}" target="_blank">
                                                                                <img width="50px" src="{{ asset($employee->employmentDocuments->military_certificate) }}" alt="Military Certificate">
                                                                            </a>
                                                                        @else
                                                                            Not Available
                                                                        @endif
                                                                    </td>
                                                                    
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- users list ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@section('script')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
