@extends('layouts.master')

@section('title', 'Approve Or Reject Phase')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.min.css" rel="stylesheet">

@endsection

@section('breadcrumb-title')
    <h3>Approve Or Reject Phase </h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Project Inquiry </li>
    <li class="breadcrumb-item active"> Approve Or Reject Phase</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">


                <div class="card">
                    <div class="card-body">

                                <form action="{{ route('phases.approveOrReject', ['id' => $phase->id]) }}" method="POST">
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
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-manager_id" for="modalAddCardNumber"> Manger</label>
                                        <div class="input-group input-group-merge">

                                            <input type="text" id="manager_id" name="" class="form-control"
                                                value="{{ $phase->manager->name ?? '' }}" readonly />
                                            <input type="hidden" name="manager_id" value="{{ $phase->manager_id }}">
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
                                        <button type="submit" name="approve" class="mt-1 btn btn-success me-1">
                                            <i class='icon-check'></i> Approve
                                        </button>
                                        <button type="submit" name="reject" class="mt-1 btn btn-danger me-1">
                                            <i  class='icon-x'></i> Reject
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
