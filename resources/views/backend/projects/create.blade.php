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

                        <h4 class="page-title"> Create Evaluation</h4>
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
                                <form action="{{ route('task.store') }}" method="POST">
                                    @csrf

                                    <!-- عرض الحقول الديناميكية إذا كانت هناك فورم مرتبطة -->
                                    @if ($form && $form->fields)
                                        @foreach (json_decode($form->fields, true) as $field)
                                            <div class="form-group">
                                                <label
                                                    for="{{ $field['name'] }}">{{ $field['label'] ?? ucfirst($field['name']) }}</label>
                                                <input type="{{ $field['type'] }}" name="fields_data[{{ $field['name'] }}]"
                                                    class="form-control" placeholder="{{ $field['name'] ?? '' }}">
                                            </div>
                                        @endforeach
                                        <div class="form-group">
                                            <label for="name">اسم التاسك:</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="project_id">المشروع:</label>
                                            <input type="text" value="{{ $project->name }}" class="form-control"
                                                disabled>
                                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="priority">الأولوية:</label>
                                            <select name="priority" class="form-control">
                                                <option value="high">عالية</option>
                                                <option value="medium" selected>متوسطة</option>
                                                <option value="low">منخفضة</option>
                                            </select>
                                        </div>
                                    @else
                                        <!-- عرض الحقول الافتراضية إذا لم تكن هناك فورم مرتبطة -->
                                        <div class="row">
                                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                                            <div class="form-group col-6">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="priority">priority:</label>
                                                <select name="priority" class="form-control">
                                                    <option value="high">high</option>
                                                    <option value="medium" selected>medium</option>
                                                    <option value="low">low</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" name="fields_data[start_date]" class="form-control" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="end_date">End Date</label>
                                                <input type="date" name="fields_data[end_date]" class="form-control" required>
                                            </div>  
                                        </div>
                                    @endif
                                    <br>

                                    <button type="submit" class="btn btn-primary">حفظ</button>
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
