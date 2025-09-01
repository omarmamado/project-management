@extends('admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.min.css" rel="stylesheet">


    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title"> Project Inquiry Edit</h4>
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


                                <form action="{{ route('project_inquiry.update', $project->id) }}" method="post"
                                    class="form" enctype="multipart/form-data">
                                    {{ method_field('patch') }}
                                    @csrf
                                    <!-- بيانات المشروع -->
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="name">Project Name:</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $project->name }}">
                                        </div>

                                        <div class="col-6">
                                            <label for="manager_id">Project Manager:</label>
                                            <select name="manager_id" class="form-control">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $project->manager_id == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}</option>

                                                    {{-- <option value="{{ $user->id }}">{{ $user->name }}</option> --}}
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br>

                                    <table class="table table-bordered" id="phases-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Manager</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Form</th>
                                                <th>Tags</th>

                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="phases-body">
                                            <!-- سيتم إضافة الصفوف هنا -->
                                            @foreach ($project->phases as $index => $phase)
                                            <tr>
                                                <td>
                                                    <input type="text" name="phases[{{ $index }}][name]" class="form-control" value="{{ $phase->name }}">
                                                </td>
                                                <td>
                                                    <select name="phases[{{ $index }}][manager_id]" class="form-control" required>
                                                        <option value="" disabled selected>Select Manager</option>
                                                        @foreach ($users as $user)
                                                            @if ($user->is_manager)
                                                                <option value="{{ $user->id }}" {{ $user->id == $phase->manager_id ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="date" name="phases[{{ $index }}][start_date]" class="form-control" value="{{ $phase->start_date }}">
                                                </td>
                                                <td>
                                                    <input type="date" name="phases[{{ $index }}][end_date]" class="form-control" value="{{ $phase->end_date }}">
                                                </td>
                                                <td>
                                                    <select name="phases[{{ $index }}][form_id]" class="form-control" required>
                                                        <option value="" disabled selected>Select Form</option>
                                                        @foreach ($forms as $form)
                                                            <option value="{{ $form->id }}" {{ $form->id == $phase->form_id ? 'selected' : '' }}>
                                                                {{ $form->form_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="phases[{{ $index }}][tags][]" class="form-control tags-input" 
                                                           value="{{ implode(',', $phase->tags->pluck('tag')->toArray()) }}">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                        </tbody>
                                    </table>

                                    <!-- زر إضافة مرحلة جديدة -->
                                    <button type="button" class="mb-3 btn btn-success" onclick="addPhaseRow()">Add
                                        Phase</button>

                                    <br>

                                    <!-- زر الحفظ -->
                                    <button type="submit" class="btn btn-primary">Save</button>
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
    {{-- <script>
        let phaseIndex = 0; // تغيير البداية إلى 0
        function addPhaseRow() {
            phaseIndex++; // زيادة المؤشر أولاً
            const row = `
        <tr>
            <td><input type="text" name="phases[${phaseIndex}][name]" class="form-control" required></td>
            <td>
                <select name="phases[${phaseIndex}][manager_id]" class="form-control" required>
                    <option value="" disabled selected>Select Manager</option>
                    @foreach ($users as $user)
                    @if ($user->is_manager)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                    @endforeach
                </select>
            </td>
            <td><input type="date" name="phases[${phaseIndex}][start_date]" class="form-control"></td>
            <td><input type="date" name="phases[${phaseIndex}][end_date]" class="form-control"></td>
            <td>
                <select name="phases[${phaseIndex}][form_id]" class="form-control" required>
                    <option value="" disabled selected>Select Form</option>
                    @foreach ($forms as $form)
                        <option value="{{ $form->id }}">{{ $form->form_name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="phases[${phaseIndex}][tags][]" class="form-control tags-input" placeholder=" Add Tags">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button>
            </td>
        </tr>
        `;
            const tbody = document.getElementById('phases-body');
            tbody.insertAdjacentHTML('beforeend', row);
            // تهيئة Selectize للحقل الجديد
            initializeLastTagsInput();
        }

        function initializeLastTagsInput() {
            // تهيئة آخر حقل تاغات تم إضافته
            $('.tags-input:last').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    };
                }
            });
        }

        function removeRow(button) {
            button.closest('tr').remove();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // جلب الوسوم المخزنة مسبقًا
            const existingTags = @json($existingTags); // الوسوم المحفوظة مسبقًا من الخادم

            // تهيئة جميع الحقول التي تحتوي على class 'tags-input'
            document.querySelectorAll('.tags-input').forEach(function(input) {
                new Tagify(input, {
                    whitelist: existingTags, // قائمة الوسوم الموجودة
                    enforceWhitelist: false, // السماح بإضافة وسوم جديدة
                    dropdown: {
                        enabled: 1, // عرض الاقتراحات عند الكتابة
                        position: 'input',
                        closeOnSelect: false
                    }
                });
            });
        });
    </script> --}}

    <script>
      let phaseIndex = {{ $project->phases->count() }}; // عدد المراحل الحالية

function addPhaseRow() {
    const row = `
    <tr>
        <td><input type="text" name="phases[${phaseIndex}][name]" class="form-control" required></td>
        <td>
            <select name="phases[${phaseIndex}][manager_id]" class="form-control" required>
                <option value="" disabled selected>Select Manager</option>
                @foreach ($users as $user)
                    @if ($user->is_manager)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
        </td>
        <td><input type="date" name="phases[${phaseIndex}][start_date]" class="form-control"></td>
        <td><input type="date" name="phases[${phaseIndex}][end_date]" class="form-control"></td>
        <td>
            <select name="phases[${phaseIndex}][form_id]" class="form-control" required>
                <option value="" disabled selected>Select Form</option>
                @foreach ($forms as $form)
                    <option value="{{ $form->id }}">{{ $form->form_name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="phases[${phaseIndex}][tags][]" class="form-control tags-input" placeholder=" Add Tags">
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button>
        </td>
    </tr>
    `;
    document.getElementById('phases-body').insertAdjacentHTML('beforeend', row);
    phaseIndex++; // زيادة المؤشر بعد الإضافة
    initializeLastTagsInput();
}
         
    
        function initializeLastTagsInput() {
            // تهيئة آخر حقل تاغات تم إضافته
            $('.tags-input:last').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    };
                }
            });
        }
    
        function removeRow(button) {
            button.closest('tr').remove();
        }
        // التهيئة الأولية للصف الأول
        $(document).ready(function() {
            $('.tags-input').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    };
                }
            });
        });
    </script>
    
    <script>
        // جلب الوسوم المخزنة مسبقًا
        const existingTags = @json($existingTags); // متغير يحتوي على الوسوم المخزنة مسبقًا من الخادم
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('#tags');
            const tagify = new Tagify(input, {
                whitelist: existingTags, // قائمة الوسوم الموجودة
                enforceWhitelist: false, // السماح بكتابة وسوم جديدة
                dropdown: {
                    enabled: 1, // إظهار الاقتراحات أثناء الكتابة
                    position: 'input',
                    closeOnSelect: false
                },
                placeholder: ""
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- إضافة مكتبة Tagify -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.css">
@endsection
