@extends('layouts.master')

@section('title')
    Create Employee Profile
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-wizard.min.css') }}">
@endsection

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row"></div>
            <div class="content-body">
                <section class="modern-horizontal-wizard">
                    <form action="{{ route('employee-profile.store') }}" method="post" class="form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="bs-stepper wizard-modern modern-wizard-example">
                            <div class="bs-stepper-header">
                                <div class="step" data-target="#account-details-modern" role="tab"
                                    id="account-details-modern-trigger">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-box">
                                            <i data-feather="file-text" class="font-medium-3"></i>
                                        </span>
                                        <span class="bs-stepper-label">
                                            <span class="bs-stepper-title">Employee Profile</span>
                                            <span class="bs-stepper-subtitle">Employee Profile</span>
                                        </span>
                                    </button>
                                </div>
                                <div class="line">
                                    <i data-feather="chevron-right" class="font-medium-2"></i>
                                </div>
                            </div>
                            <div class="bs-stepper-content">
                                <div id="account-details-modern" class="content" role="tabpanel"
                                    aria-labelledby="account-details-modern-trigger">
                                    <div class="content-header">
                                        <h5 class="mb-0">Employee Profile</h5>
                                    </div>
                                    <div class="row">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="user_id">Company user</label>
                                                        <select name="user_id" id="user_id" class="form-select select2"
                                                            required>
                                                            <option disabled selected>Select user</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('company_id')
                                                            <span class="help-block text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="bs-stepper wizard-modern modern-wizard-example">

                            <div class="content-header">
                                <h2 style="margin-bottom: 10px">
                                    <center>Employment Documents</center>
                                </h2>
                            </div>
                            <div class="bs-stepper-content">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="birth_certificate">Birth Certificate</label>
                                        <input type="file" name="birth_certificate" class="form-control">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="graduation_certificate">Graduation Certificate</label>
                                        <input type="file" name="graduation_certificate" class="form-control">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="criminal_record">id_card</label>
                                        <input type="file" name="id_card" class="form-control">
                                    </div>
                                </div>
                                <br>
                                <div class="row">


                                    <div class="form-group col-6">
                                        <label for="military_certificate">Military Certificate</label>
                                        <input type="file" name="military_certificate" class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="military_certificate">Criminal Record</label>
                                        <input type="file" name="criminal_record" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br>

                        <div class="bs-stepper wizard-modern modern-wizard-example">
                            <div class="content-header">
                                <h2 style="margin-bottom: 10px">
                                    <center>Training Period</center>
                                </h2>
                            </div>
                            <div class="bs-stepper-content" id="bs-stepper">
                                <div class="row">
                                    <div class="form-group col-6" id="training_period">
                                        <label for="training_start_date">Training Start Date</label>
                                        <input type="date" name="training_start_date" class="form-control">
                                    </div>
                                    <div class="form-group col-6" id="training_period">
                                        <label for="training_end_date">Training End Date</label>
                                        <input type="date" name="training_end_date" class="form-control">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="bs-stepper wizard-modern modern-wizard-example">
                            <div class="content-header">
                                <h2 style="margin-bottom: 10px">
                                    <center>Contract</center>
                                </h2>
                            </div>
                            <div class="bs-stepper-content" id="bs-stepper">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="contract_file">Upload Contract File</label>
                                        <input type="file" name="contract_file" class="form-control">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="contract_start_date">Contract Start Date</label>
                                        <input type="date" name="contract_start_date" class="form-control">
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="contract_end_date">Contract End Date</label>
                                        <input type="date" name="contract_end_date" class="form-control">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="contract_end_date">Salary</label>
                                        <input type="text" name="salary" class="form-control">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="bs-stepper wizard-modern modern-wizard-example">
                            <div class="content-header">
                                <h2 style="margin-bottom: 10px">
                                    <center>Allowance</center>
                                </h2>
                            </div>
                            <div class="bs-stepper-content" id="bs-stepper">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="allowances">Allowances</label>
                                        <div id="allowance-container">
                                            <div class="allowance-row d-flex mb-2">
                                                <select name="allowance_type[]" class="form-control">
                                                    <option value="">Select Allowance</option>
                                                    <option value="accommodation">Accommodation</option>
                                                    <option value="transportation">Transportation</option>
                                                    <option value="communications">Communications</option>
                                                </select>
                                                <input type="number" name="amount[]" class="form-control ml-2" placeholder="Amount">
                                                <button type="button" class="btn btn-success ml-2 add-allowance">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="text-right pt-3 ">
                            <div class="d-flex justify-content-between text-center" style="text-align: center">
                                <button type="submit" name="save" id="save" class="save btn btn-primary">
                                    <i data-feather='save'></i> save
                                </button>
                            </div>
                        </div>
               </div>
             </form>
            </section>
        </div>
    </div>
    </div>
    <!-- END: Content-->
@endsection
@section('script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ URL::asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
    <script src="{{ URL::asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('app-assets/js/scripts/forms/form-wizard.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // تكوين Select2 لكل العناصر التي تحمل الفئة ".select2"
            $(".select2").select2({
                placeholder: "Select Option",
                allowClear: true
            });

            // التعامل مع زر الإضافة
            $(".btn_add").click(function() {
                // انتظر لحظة ثم قم بتكوين Select2 للعناصر الجديدة
                setTimeout(function() {
                    $(".select2").select2({
                        placeholder: "Select Option",
                        allowClear: true
                    });
                }, 100);
            });
        });
    </script>


    <script>
      document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-allowance')) {
        const container = document.getElementById('allowance-container');
        const newAllowanceRow = document.createElement('div');
        newAllowanceRow.classList.add('allowance-row', 'd-flex', 'mb-2');
        newAllowanceRow.innerHTML = `
            <select name="allowance_type[]" class="form-control">
                <option value="">Select Allowance</option>
                <option value="accommodation">Accommodation</option>
                <option value="transportation">Transportation</option>
                <option value="communications">Communications</option>
            </select>
            <input type="number" name="amount[]" class="form-control ml-2" placeholder="Amount" required>
            <button type="button" class="btn btn-danger ml-2 remove-allowance">-</button>
        `;
        container.appendChild(newAllowanceRow);
    }

    if (e.target.classList.contains('remove-allowance')) {
        e.target.parentElement.remove();
    }
});

document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault(); // منع الإرسال الفوري للتحقق من البيانات
    const formData = new FormData(this);

    // طباعة كل الحقول للتحقق من إرسالها كالمطلوب
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    // تابع الإرسال بعد التأكد
    this.submit();
});

    </script>
@endsection
