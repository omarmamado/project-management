@extends('layouts.master')

@section('title')
    Edit Employee Profile
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
                    <form action="{{ route('employee-profile.update', $employee->id) }}" method="POST" class="form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                                <div class="form-group">
                                                    <label for="user_id">Company user</label>
                                                    <select name="user_id" id="user_id" class="form-select select2" required>
                                                        @foreach ($users as $userOption)
                                                            <option value="{{ $userOption->id }}" {{ isset($employee) && $userOption->id == $employee->id ? 'selected' : '' }}>
                                                                {{ $userOption->name }}
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
                                        @if($employee->employmentDocuments->birth_certificate)
                                        <a href="{{ asset($employee->employmentDocuments->birth_certificate) }}" target="_blank">View Current Birth Certificate</a>
                                    @endif
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="graduation_certificate">Graduation Certificate</label>
                                        <input type="file" name="graduation_certificate" class="form-control">
                                        @if($employee->employmentDocuments->graduation_certificate)
                                        <a href="{{ asset($employee->employmentDocuments->graduation_certificate) }}" target="_blank">View Current Graduation Certificate</a>
                                    @endif
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="id_card">ID Card</label>
                                        <input type="file" name="id_card" class="form-control">
                                        @if($employee->employmentDocuments->id_card)
                                            <a href="{{ asset($employee->employmentDocuments->id_card) }}" target="_blank">View Current ID Card</a>
                                        @endif
                                    </div>
                                </div>
                                <br>
                               <div class="row">

                               
                                <div class="form-group col-6">
                                    <label for="military_certificate">Military Certificate</label>
                                    <input type="file" name="military_certificate" class="form-control">
                                    @if($employee->employmentDocuments->military_certificate)
                                    <a href="{{ asset($employee->employmentDocuments->military_certificate) }}" target="_blank">View Current Military Certificate</a>
                                @endif
                                </div>
                                <div class="form-group col-6">
                                    <label for="military_certificate">Criminal Record</label>
                                    <input type="file" name="criminal_record" class="form-control">
                                    @if($employee->employmentDocuments->military_certificate)
                                    <a href="{{ asset($employee->employmentDocuments->criminal_record) }}" target="_blank">View Current Criminal Record</a>
                                @endif
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
                                    <div class="form-group col-6">
                                        <label for="training_start_date">Training Start Date</label>
                                        <input type="text" name="training_start_date" 
                                               value="{{ $employee->EmployeeTraining->training_start_date ? : '' }}" 
                                               class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="training_end_date">Training End Date</label>
                                        <input type="text" name="training_end_date" 
                                               value="{{ $employee->EmployeeTraining->training_end_date ?  : '' }}" 
                                               class="form-control">
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
                                        <label for="contract_file">Contract File</label>
                                        <input type="file" name="contract_file" class="form-control">
                                        @if($employee->employmentcontracts->first() && $employee->employmentcontracts->first()->contract_file)
                                            <a href="{{ asset($employee->employmentcontracts->first()->contract_file) }}" target="_blank">View Current File</a>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group col-3">
                                        <label for="contract_start_date">Contract Start Date</label>
                                        <input type="date" name="contract_start_date" class="form-control" 
                                               value="{{ $employee->employmentcontracts->first()->start_date ?: '' }}">
                                    </div>
                                    
                                    <div class="form-group col-3">
                                        <label for="contract_end_date">Contract End Date</label>
                                        <input type="date" name="contract_end_date" class="form-control" 
                                               value="{{ $employee->employmentcontracts->first()->end_date ? : '' }}">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="contract_end_date">Salary</label>
                                        <input type="text" name="salary" class="form-control" 
                                               value="{{ $employee->employmentcontracts->first()->salary ? : '' }}">
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
                        
                                        @foreach ($employee->employmentcontracts as $contractIndex => $contract)
                                            <div class="mb-4">
                                                <h5>Contract #{{ $contractIndex + 1 }}</h5>
                                                <div id="allowance-container-{{ $contractIndex }}">
                                                    @foreach ($contract->allowances as $index => $allowance)
                                                        <div class="allowance-row d-flex mb-2">
                                                            <select name="allowances[{{ $contractIndex }}][{{ $index }}][type]" class="form-control">
                                                                <option value="">Select Allowance</option>
                                                                <option value="accommodation" {{ $allowance->allowance_type == 'accommodation' ? 'selected' : '' }}>Accommodation</option>
                                                                <option value="transportation" {{ $allowance->allowance_type == 'transportation' ? 'selected' : '' }}>Transportation</option>
                                                                <option value="communications" {{ $allowance->allowance_type == 'communications' ? 'selected' : '' }}>Communications</option>
                                                            </select>
                                                            <input type="number" name="allowances[{{ $contractIndex }}][{{ $index }}][amount]" class="form-control ml-2" placeholder="Amount" value="{{ $allowance->amount }}" required>
                                                            <button type="button" class="btn btn-danger ml-2 remove-allowance">-</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-success add-allowance" data-contract="{{ $contractIndex }}">+</button>
                                            </div>
                                        @endforeach
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
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-allowance')) {
                const contractIndex = e.target.getAttribute('data-contract');
                const container = document.getElementById(`allowance-container-${contractIndex}`);
                const allowanceIndex = container.children.length;
    
                const newAllowanceRow = document.createElement('div');
                newAllowanceRow.classList.add('allowance-row', 'd-flex', 'mb-2');
                newAllowanceRow.innerHTML = `
                    <select name="allowances[${contractIndex}][${allowanceIndex}][type]" class="form-control" required>
                        <option value="">Select Allowance</option>
                        <option value="accommodation">Accommodation</option>
                        <option value="transportation">Transportation</option>
                        <option value="communications">Communications</option>
                    </select>
                    <input type="number" name="allowances[${contractIndex}][${allowanceIndex}][amount]" class="form-control ml-2" placeholder="Amount" required>
                    <button type="button" class="btn btn-danger ml-2 remove-allowance">-</button>
                `;
                container.appendChild(newAllowanceRow);
            }
    
            if (e.target.classList.contains('remove-allowance')) {
                e.target.parentElement.remove();
            }
        });
    
        document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    // طباعة البيانات للتحقق من أن جميع الحقول تم إضافتها
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    // تابع الإرسال إذا كانت البيانات كاملة
    this.submit();
});
    });
    </script>


@endsection
