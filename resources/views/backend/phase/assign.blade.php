@extends('admin_dashboard')
@section('admin')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.min.css" rel="stylesheet">

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title"> Project Inquiry Phase Assign</h4>
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

                                <form action="{{ route('project_inquiry_phase.store') }}" method="POST">

                                    @csrf
                                    <input id="project_inquiry_id" type="hidden" name="project_inquiry_id"
                                        class="form-control" value="{{ $phase->project_inquiry_id }}">
                                    <div class="row">

                                        <div class="col-6">
                                            <label class="form-label" for="modalAddCardNumber">Name</label>
                                            <div class="input-group input-group-merge">
                                                <input id="modalAddCardNumber" name="name"
                                                    class="form-control add-credit-card-mask" type="text"
                                                    value="{{ $phase->name }}" aria-describedby="modalAddCard2"
                                                    data-msg="Please enter your credit card number" readonly />
                                                <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                    <span class="add-card-type"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="modalAddCardNumber">Forms</label>
                                            <div class="input-group input-group-merge">
                                                <input id="modalAddCardNumber" name=""
                                                    class="form-control add-credit-card-mask" type="text"
                                                    value="{{ $phase->form->form_name }}" aria-describedby="modalAddCard2"
                                                    data-msg="Please enter your credit card number" disabled />
                                                <input type="hidden" name="form_id" value="{{ $phase->form_id }}">


                                                <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                    <span class="add-card-type"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-manager_id" for="modalAddCardNumber"> Manger</label>
                                            <div class="input-group input-group-merge">
    
                                                <input type="text" id="manager_id" name="" class="form-control"
                                                    value="{{ $phase->manager->name ?? '' }}" readonly />
                                                <input type="hidden" name="manager_id" value="{{ $phase->manager_id }}">
    
    
    
    
                                                <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                    <span class="add-card-type"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-manager_id" for="modalAddCardNumber"> Add Assign Users </label>
                                            <div class="input-group input-group-merge">
    
                                                <select name="user_ids[]" class="form-control select2-multiple" data-toggle="select2" data-width="100%" multiple="multiple">
                                                    @if ($phase->manager)
                                                        @if ($phase->manager->team && $phase->manager->team->users->count() > 0)
                                                            @foreach ($phase->manager->team->users as $user)
                                                                <option value="{{ $user->id }}" 
                                                                    {{ in_array($user->id, old('user_ids', $phase->users->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        @elseif ($phase->manager->department && $phase->manager->department->users->count() > 0)
                                                            @foreach ($phase->manager->department->users as $user)
                                                                <option value="{{ $user->id }}" 
                                                                    {{ in_array($user->id, old('user_ids', $phase->users->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="" disabled>No users available for selection</option>
                                                        @endif
                                                    @else
                                                        <option value="" disabled>No manager assigned to the phase</option>
                                                    @endif
                                                </select>
                                                
    
    
    
    
                                                <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                    <span class="add-card-type"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                  
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label" for="modalAddCardNumber">Start Date</label>
                                            <div class="input-group input-group-merge">
                                                <input id="modalAddCardNumber" name="start_date"
                                                    value="{{ $phase->start_date }}"
                                                    class="form-control add-credit-card-mask" type="date"
                                                    placeholder="Name" aria-describedby="modalAddCard2"
                                                    data-msg="Please enter your credit card number" readonly />
                                                <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                    <span class="add-card-type"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="modalAddCardNumber">End Date</label>
                                            <div class="input-group input-group-merge">
                                                <input id="modalAddCardNumber" name="end_date"
                                                    class="form-control add-credit-card-mask" type="date"
                                                    placeholder="Name" aria-describedby="modalAddCard2"
                                                    value="{{ $phase->end_date }}"
                                                    data-msg="Please enter your credit card number" readonly />
                                                <span class="cursor-pointer input-group-text p-25" id="modalAddCard2">
                                                    <span class="add-card-type"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- مكان عرض الحقول الديناميكية -->

                                    <div class="row">
                                        @foreach ($formFields as $index => $field)
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label" for="{{ $field['name'] ?? 'unknown_field' }}">
                                                    {{ $field['label'] ?? ($field['name'] ?? 'Unknown Field') }}
                                                </label>
                                                <div class="input-group input-group-merge">
                                                    @php $value = $dynamicData[$field['name'] ?? 'unknown_field'] ?? ''; @endphp

                                                    @if (($field['type'] ?? 'text') === 'text' || ($field['type'] ?? 'text') === 'number')
                                                        <input type="{{ $field['type'] ?? 'text' }}"
                                                            id="{{ $field['name'] ?? 'unknown_field' }}"
                                                            name="dynamic_data[{{ $field['name'] ?? 'unknown_field' }}]"
                                                            class="form-control" value="{{ $value }}" readonly />
                                                    @elseif (($field['type'] ?? '') === 'textarea')
                                                        <textarea id="{{ $field['name'] ?? 'unknown_field' }}" name="dynamic_data[{{ $field['name'] ?? 'unknown_field' }}]"
                                                            class="form-control" readonly>{{ $value }}</textarea>
                                                    @elseif (($field['type'] ?? '') === 'select')
                                                        <select id="{{ $field['name'] ?? 'unknown_field' }}"
                                                            name="dynamic_data[{{ $field['name'] ?? 'unknown_field' }}]"
                                                            class="form-control" disabled>
                                                            @foreach (explode(',', $field['options'] ?? '') as $option)
                                                                <option value="{{ trim($option) }}"
                                                                    {{ trim($option) == $value ? 'selected' : '' }}>
                                                                    {{ trim($option) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @elseif (($field['type'] ?? '') === 'date')
                                                        <input type="date"
                                                            id="{{ $field['name'] ?? 'unknown_field' }}"
                                                            name="dynamic_data[{{ $field['name'] ?? 'unknown_field' }}]"
                                                            class="form-control" value="{{ $value }}" readonly />
                                                    @elseif (($field['type'] ?? '') === 'checkbox')
                                                        <input type="checkbox"
                                                            id="{{ $field['name'] ?? 'unknown_field' }}"
                                                            name="dynamic_data[{{ $field['name'] ?? 'unknown_field' }}]"
                                                            value="1" {{ $value ? 'checked' : '' }} disabled />
                                                        <label for="{{ $field['name'] ?? 'unknown_field' }}">
                                                            {{ $field['label'] ?? ($field['name'] ?? 'Checkbox') }}
                                                        </label>
                                                    @endif
                                                </div>
                                            </div>

                                            @if (($index + 1) % 2 == 0)
                                    </div>
                                    <div class="row">
                                        @endif
                                        @endforeach
                                    </div>




                                    <div class="text-center col-12">
                                        <button type="submit" class="mt-1 btn btn-warning me-1">
                                            <i data-feather='save'></i> Submit
                                        </button>

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





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- إضافة مكتبة Tagify -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.css">
@endsection
