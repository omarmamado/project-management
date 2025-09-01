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
            <div class="content-header">
                <h2 style="margin-bottom: 10px">
                    <center>Training Period</center>
                </h2>
            </div>
            <div class="content-body">
                <section class="app-user-list">

                    <!-- list and filter start -->
                    <div class="card">
                       
                        <div class="card-body">
                           
                            <table id="example1" class="table table-striped text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Training Start Date</th>
                                        <th>Training End Date</th>
                                        <th>Processes</th>                                
                                </thead>
                                <tbody>
                                    @foreach ($expiringTrainings as $training)
                                        <tr>
                                            <td>{{ $training->user->name }}</td>
                                            <td>{{ $training->training_start_date }}</td>
                                            <td>{{ $training->training_end_date }}</td>
                                            <td> 
                                             
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#addNewCard1{{ $training->id }}">
                                                <i data-feather='file-plus'></i> Add New
                                            </button>
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
            <div class="content-header">
                <h2 style="margin-bottom: 10px">
                    <center>Contract</center>
                </h2>
            </div>

            <div class="content-body">
                <section class="app-user-list">

                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body">

                            <!-- modal trigger button -->
                          
                            <table id="example2" class="table table-striped text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Contract Start Date</th>
                                        <th>Contract End Date</th>
                                        <th>Salary</th>
                                        <th>Renewed</th>
                                        <th>Processes</th>                                
                                </thead>
                                <tbody>
                                    @foreach ($expiringContracts as $contract)
                                        <tr>
                                            <td>{{ $contract->user->name }}</td>
                                            <td>{{ $contract->start_date }}</td>
                                            <td>{{ $contract->end_date }}</td>
                                            <td>{{ $contract->salary }}</td>
                                            <td>{{ $contract->is_renewed ? 'Yes' : 'No' }}</td>
                                            <td>

                                               

                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addNewCard{{ $contract->id }}">
                            <i data-feather='file-plus'></i> Add New contract
                        </button>
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

            <!-- Modal -->
            @if(isset($training))
            <div class="modal fade" id="addNewCard1{{ $training->id }}" tabindex="-1" aria-labelledby="addNewCard1{{ $training->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="bg-transparent modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="pb-5 modal-body px-sm-5 mx-50">
                                <h1 class="mb-1 text-center" id="addNewUserTitle">Add New Contract </h1>

                                <!-- form -->
                                <form id="addNewUserForm"action="{{ route('addEmploymentContrac',$training->id) }}"
                                    class="row gy-1 gx-2 mt-75" method="POST" enctype="multipart/form-data"
                                    onsubmit="return true">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $training->user_id }}">
                                    <!-- Name Field -->
                                    <div class="col-12">
                                        <label for="contract_file">Upload Contract File</label>
                                        <input type="file" name="contract_file" class="form-control">
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-12">
                                        <label for="contract_start_date">Contract Start Date</label>
                                        <input type="date" name="contract_start_date" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="contract_end_date">Contract End Date</label>
                                        <input type="date" name="contract_end_date" class="form-control">
                                    </div>

                                    <div class="col-12">
                                        <label for="contract_end_date">Salary</label>
                                        <input type="text" name="salary" class="form-control">                                      
                                    </div>



                                    <div class="text-center col-12">
                                        <button type="submit" class="mt-1 btn btn-warning me-1">
                                            <i data-feather='save'></i> Submit
                                        </button>
                                        <button type="reset" class="mt-1 btn btn-outline-secondary"
                                            data-bs-dismiss="modal">
                                            <i data-feather='x-circle'></i> Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

        </div>

        @endif
        @if(isset($contract))
        <div class="modal fade" id="addNewCard{{ $contract->id }}" tabindex="-1" aria-labelledby="addNewCard{{ $contract->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="bg-transparent modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="pb-5 modal-body px-sm-5 mx-50">
                                <h1 class="mb-1 text-center" id="addNewUserTitle">Add New Contract</h1>

                                <!-- form -->
                                <form id="addNewUserForm" action="{{ route('addEmploymentContrac',$contract->id ) }}"
                                    class="row gy-1 gx-2 mt-75" method="POST" enctype="multipart/form-data"
                                    onsubmit="return true">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $contract->user_id }}">

                                    <!-- Name Field -->
                                    <div class="col-12">
                                        <label for="contract_file">Upload Contract File</label>
                                        <input type="file" name="contract_file" class="form-control">
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-12">
                                        <label for="contract_start_date">Contract Start Date</label>
                                        <input type="date" name="contract_start_date" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="contract_end_date">Contract End Date</label>
                                        <input type="date" name="contract_end_date" class="form-control">
                                    </div>

                                    <div class="col-12">
                                        <label for="contract_end_date">Salary</label>
                                        <input type="text" name="salary" class="form-control">                                      
                                    </div>



                                    <div class="text-center col-12">
                                        <button type="submit" class="mt-1 btn btn-warning me-1">
                                            <i data-feather='save'></i> Submit
                                        </button>
                                        <button type="reset" class="mt-1 btn btn-outline-secondary"
                                            data-bs-dismiss="modal">
                                            <i data-feather='x-circle'></i> Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
        @endif
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
    <script>
        $(document).ready(function() {
            var table = $('#example1').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>

    
@endsection
