@extends('admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title"> Project Inquiry Show</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">


                <div class="col-lg-8 col-xl-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- end timeline content-->

                            <div class="tab-pane" id="settings">
                                <form id="addNewCardValidation" action="{{ route('project_inquiry.update', $project->id) }}"
                                    class="row gy-1 gx-2 mt-75" method="POST" onsubmit="return true">
                                    {{ method_field('patch') }}
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label" for="modalAddCardNumber">Name</label>
                                            <div class="input-group input-group-merge">
                                                <input id="modalAddCardNumber" name="name" value="{{ $project->name }}"
                                                    class="form-control add-credit-card-mask" type="text"
                                                    placeholder="New Categories" aria-describedby="modalAddCard2"
                                                    data-msg="Please enter your credit card number"
                                                    value="{{ $project->name }}" readonly />
                                               
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="modalAddCardNumber">Forms</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" id="form_name" class="form-control"
                                                    value="{{ $project->form->form_name ?? '' }}" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-manager_id" for="modalAddCardNumber">Manger</label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" id="form_name" class="form-control"
                                                value="{{ $project->manager->name ?? '' }}" readonly />
                                           
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-manager_id" for="modalAddCardNumber">Status</label>
                                        <div class="input-group input-group-merge">
                                            @if ($project->status == 'approved')
                                                <button class="btn btn-success w-100" disabled>Approved</button>
                                            @elseif($project->status == 'rejected')
                                                <button class="btn btn-danger w-100"disabled>Rejected</button>
                                            @else
                                                <button class="btn btn-primary w-100"disabled>Pending</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="start_date">Start Date</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ $project->start_date }}" readonly>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="end_date">End Date</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ $project->end_date }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="start_date">Manger Start  Date</label>
                                            <input type="date" name="start_date_manager" class="form-control"
                                                " >
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="end_date">Manger  End Date</label>
                                            <input type="date" name="end_date" class="form-control"
                                                " >
                                        </div>
                                    </div>
                                    <div id="dynamic-form-fields1">
                                        @if (!empty($dynamicFields))
                                            <div class="row">
                                                @foreach ($dynamicFields as $index => $field)
                                                    @if (is_array($field) && isset($field['name'], $field['type']))
                                                        <div class="form-group col-6">
                                                            <label for="{{ $field['name'] }}">{{ $field['label'] ?? ucfirst(str_replace('_', ' ', $field['name'])) }}</label>
                                                            @php
                                                                $value = $dynamicData[$field['name']] ?? ''; // القيمة المخزنة في dynamic_data
                                                            @endphp
                                                            @if ($field['type'] == 'text')
                                                                <input type="text" name="fields[{{ $field['name'] }}]" class="form-control" value="{{ $value }}"readonly>
                                                            @elseif ($field['type'] == 'date')
                                                                <input type="date" name="fields[{{ $field['name'] }}]" class="form-control" value="{{ $value }}"readonly>
                                                            @elseif ($field['type'] == 'number')
                                                                <input type="number" name="fields[{{ $field['name'] }}]" class="form-control" value="{{ $value }}"readonly>
                                                            @elseif ($field['type'] == 'textarea')
                                                                <textarea name="fields[{{ $field['name'] }}]" class="form-control"readonly>{{ $value }}</textarea>
                                                            @elseif ($field['type'] == 'checkbox')
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="fields[{{ $field['name'] }}]" class="form-check-input" value="1" id="{{ $field['name'] }}" {{ $value == 1 ? 'checked' : '' }}readonly>
                                                                    <label class="form-check-label" for="{{ $field['name'] }}">{{ $field['label'] ?? ucfirst(str_replace('_', ' ', $field['name'])) }}</label>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @if (($index + 1) % 2 == 0 && !$loop->last)
                                                            </div><div class="row">
                                                        @endif
                                                    @else
                                                        <p>تنسيق الحقل غير صحيح.</p>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <p>لا توجد حقول ديناميكية مرتبطة بهذا الفورم</p>
                                        @endif
                                    </div>
                                    
                                    





                                    <input id="id" type="hidden" name="id" class="form-control"
                                        value="{{ $project->id }}">
                                    <div class="text-center col-12">
                                     
                                       
                                        
                                    </div>
                                </form>


                            </div>
                            <!-- end settings content-->


                        </div>
                    </div> <!-- end card-->

                </div> <!-- end col -->
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div> <!-- content -->



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
