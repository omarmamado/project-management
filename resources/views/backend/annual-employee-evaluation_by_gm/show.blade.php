@extends('layouts.master')

@section('title', 'Show Annual Evaluation')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Show Annual Evaluation List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">HR</li>
    <li class="breadcrumb-item active">Show Annual Evaluation List</li>
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">

                        <!-- end timeline content-->

                        <div class="tab-pane" id="settings">
                            <form action="{{ route('annual-employee-evaluation.update', $evaluation->id) }}" method="post"
                                class="form" enctype="multipart/form-data">
                                {{ method_field('patch') }}
                                @csrf

                                <section class="mb-4">
                                    <h4 class="pb-2 border-bottom">I. Employee Information</h4>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Employee Name</label>
                                            <input type="text" class="form-control" value="{{ $evaluation->user->name }}"
                                                readonly>
                                            <input type="hidden" name="user_id" value="{{ $evaluation->user_id }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Job Title</label>
                                            <input type="text" id="job_title" class="form-control"
                                                value="{{ $evaluation->user ? $evaluation->user->job_title : '' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </section>



                                <!-- Core Values and Objectives -->
                                <section class="mb-4">
                                    <h4 class="pb-2 border-bottom">II. Core Values and Objectives</h4>

                                    <!-- Quality of Work -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Quality of Work</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="quality_of_work" id="quality1"
                                                value="Exceeds expectations"
                                                {{ $evaluation->quality_of_work == 'Exceeds expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="quality1">Exceeds
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="quality_of_work" id="quality2"
                                                value="Meets expectations"
                                                {{ $evaluation->quality_of_work == 'Meets expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="quality2">Meets expectations</label>

                                            <input type="radio" class="btn-check" name="quality_of_work" id="quality3"
                                                value="Needs improvement"
                                                {{ $evaluation->quality_of_work == 'Needs improvement' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="quality3">Needs improvement</label>

                                            <input type="radio" class="btn-check" name="quality_of_work" id="quality4"
                                                value="Unacceptable"
                                                {{ $evaluation->quality_of_work == 'Unacceptable' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger" for="quality4">Unacceptable</label>
                                        </div>
                                    </div>

                                    <div class="mt-2 row">

                                        <div class="col-md-12">
                                            <label class="form-label">Comments by G.M</label>
                                            <textarea class="form-control" rows="3" name="quality_of_work_comment_gm" readonly>{{ $evaluation->quality_of_work_comment_gm }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Discipline & Punctuality -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Discipline & Punctuality</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="discipline_punctuality"
                                                id="discipline1" value="Exceeds expectations"
                                                {{ $evaluation->discipline_punctuality == 'Exceeds expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="discipline1">Exceeds
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="discipline_punctuality"
                                                id="discipline2" value="Meets expectations"
                                                {{ $evaluation->discipline_punctuality == 'Meets expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="discipline2">Meets
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="discipline_punctuality"
                                                id="discipline3" value="Needs improvement"
                                                {{ $evaluation->discipline_punctuality == 'Needs improvement' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="discipline3">Needs
                                                improvement</label>

                                            <input type="radio" class="btn-check" name="discipline_punctuality"
                                                id="discipline4" value="Unacceptable"
                                                {{ $evaluation->discipline_punctuality == 'Unacceptable' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger" for="discipline4">Unacceptable</label>
                                        </div>


                                        <div class="col-md-12">
                                            <label class="form-label">Comments by G.M</label>
                                            <textarea class="form-control" rows="3" name="discipline_punctuality_comment_gm" readonly>{{ $evaluation->discipline_punctuality_comment_gm }}</textarea>
                                        </div>
                                    </div>
                                    {{-- </div> --}}

                                    <!-- Problem solving -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Problem Solving</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="problem_solving"
                                                id="problem1" value="Exceeds expectations"
                                                {{ $evaluation->problem_solving == 'Exceeds expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="problem1">Exceeds
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="problem_solving"
                                                id="problem2" value="Meets expectations"
                                                {{ $evaluation->problem_solving == 'Meets expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="problem2">Meets
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="problem_solving"
                                                id="problem3" value="Needs improvement"
                                                {{ $evaluation->problem_solving == 'Needs improvement' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="problem3">Needs
                                                improvement</label>

                                            <input type="radio" class="btn-check" name="problem_solving"
                                                id="problem4" value="Unacceptable"
                                                {{ $evaluation->problem_solving == 'Unacceptable' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger" for="problem4">Unacceptable</label>
                                        </div>


                                        <div class="col-md-12">
                                            <label class="form-label">Comments by G.M</label>
                                            <textarea class="form-control" rows="3"name="problem_solving_comment_gm" readonly>{{ $evaluation->problem_solving_comment_gm }}</textarea>
                                        </div>
                                    </div>
                                    {{-- </div> --}}

                                    <!-- Continue with all other evaluation criteria -->
                                    <!-- Conflict Management -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Conflict Management</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="conflict_management"
                                                id="conflict_management1" value="Exceeds expectations"
                                                {{ $evaluation->conflict_management == 'Exceeds expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="conflict_management1">Exceeds
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="conflict_management"
                                                id="conflict_management2" value="Meets expectations"
                                                {{ $evaluation->conflict_management == 'Meets expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="conflict_management2">Meets
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="conflict_management"
                                                id="conflict_management3" value="Needs improvement"
                                                {{ $evaluation->conflict_management == 'Needs improvement' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="conflict_management3">Needs
                                                improvement</label>

                                            <input type="radio" class="btn-check" name="conflict_management"
                                                id="conflict4" value="Unacceptable"
                                                {{ $evaluation->conflict_management == 'Unacceptable' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger" for="conflict4">Unacceptable</label>
                                        </div>

                                        <div class="mt-2 row">

                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                <textarea class="form-control" rows="3"name="conflict_management_comment_gm" readonly>{{ $evaluation->conflict_management_comment_gm }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Time Management -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Time Effectiveness & Responsiveness</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check"
                                                name="time_effectiveness_time_responsiveness_availability"
                                                id="time_effectiveness_time_responsiveness_availability1"value="Exceeds expectations"
                                                {{ $evaluation->time_effectiveness_time_responsiveness_availability == 'Exceeds expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success"
                                                for="time_effectiveness_time_responsiveness_availability1">Exceeds
                                                expectations</label>

                                            <input type="radio" class="btn-check"
                                                name="time_effectiveness_time_responsiveness_availability"
                                                id="time_effectiveness_time_responsiveness_availability2"
                                                value="Meets expectations"
                                                {{ $evaluation->time_effectiveness_time_responsiveness_availability == 'Meets expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary"
                                                for="time_effectiveness_time_responsiveness_availability2">Meets
                                                expectations</label>

                                            <input type="radio" class="btn-check"
                                                name="time_effectiveness_time_responsiveness_availability"
                                                id="time_effectiveness_time_responsiveness_availability3"value="Needs improvement"
                                                {{ $evaluation->time_effectiveness_time_responsiveness_availability == 'Needs improvement' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning"
                                                for="time_effectiveness_time_responsiveness_availability3">Needs
                                                improvement</label>

                                            <input type="radio" class="btn-check"
                                                name="time_effectiveness_time_responsiveness_availability"
                                                id="time_effectiveness_time_responsiveness_availability4"value="Unacceptable"
                                                {{ $evaluation->time_effectiveness_time_responsiveness_availability == 'Unacceptable' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger"
                                                for="time_effectiveness_time_responsiveness_availability4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">

                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                <textarea class="form-control" rows="3"name="time_effectiveness_time_responsiveness_availability_comment_gm"
                                                    readonly>{{ $evaluation->conflict_management_comment_gm }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Initiative & Flexibility -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Initiative & Flexibility</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="initiative_flexibility"
                                                id="initiative_flexibility1"value="Exceeds expectations"
                                                {{ $evaluation->initiative_flexibility == 'Exceeds expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="initiative_flexibility1">Exceeds
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="initiative_flexibility"
                                                id="initiative_flexibility2"value="Meets expectations"
                                                {{ $evaluation->initiative_flexibility == 'Meets expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="initiative_flexibility2">Meets
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="initiative_flexibility"
                                                id="initiative_flexibility3"value="Needs improvement"
                                                {{ $evaluation->initiative_flexibility == 'Needs improvement' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="initiative_flexibility3">Needs
                                                Improvement</label>

                                            <input type="radio" class="btn-check" name="initiative_flexibility"
                                                id="initiative_flexibility4"value="Unacceptable"
                                                {{ $evaluation->initiative_flexibility == 'Unacceptable' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger"
                                                for="initiative_flexibility4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">

                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                <textarea class="form-control" rows="3"name="initiative_flexibility_comment_gm" readonly>{{ $evaluation->conflict_management_comment_gm }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="form-label">Cooperation & Teamwork:</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="cooperation_teamwork"
                                                id="cooperation_teamwork1"value="Exceeds expectations"
                                                {{ $evaluation->cooperation_teamwork == 'Exceeds expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="cooperation_teamwork1">Exceeds
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="cooperation_teamwork"
                                                id="cooperation_teamwork2"value="Meets expectations"
                                                {{ $evaluation->cooperation_teamwork == 'Meets expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="cooperation_teamwork2">Meets
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="cooperation_teamwork"
                                                id="cooperation_teamwork3"value="Needs improvement"
                                                {{ $evaluation->cooperation_teamwork == 'Needs improvement' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="cooperation_teamwork3">Needs
                                                Improvement</label>

                                            <input type="radio" class="btn-check" name="cooperation_teamwork"
                                                id="cooperation_teamwork4"value="Unacceptable"
                                                {{ $evaluation->cooperation_teamwork == 'Unacceptable' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger"
                                                for="cooperation_teamwork4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">

                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                <textarea class="form-control" rows="3"name="cooperation_teamwork_comment_gm" readonly>{{ $evaluation->cooperation_teamwork_comment_gm }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="form-label">Knowledge of Position:</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="knowledge_of_position"
                                                id="knowledge_of_position1"value="Exceeds expectations"
                                                {{ $evaluation->knowledge_of_position == 'Exceeds expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="knowledge_of_position1">Exceeds
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="knowledge_of_position"
                                                id="knowledge_of_position2"value="Meets expectations"
                                                {{ $evaluation->knowledge_of_position == 'Meets expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="knowledge_of_position2">Meets
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="knowledge_of_position"
                                                id="knowledge_of_position3"value="Needs improvement"
                                                {{ $evaluation->knowledge_of_position == 'Needs improvement' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="knowledge_of_position3">Needs
                                                Improvement</label>

                                            <input type="radio" class="btn-check" name="knowledge_of_position"
                                                id="knowledge_of_position4"value="Unacceptable"
                                                {{ $evaluation->knowledge_of_position == 'Unacceptable' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger"
                                                for="knowledge_of_position4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">

                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                <textarea class="form-control" rows="3"name="knowledge_of_position_comment_gm" readonly>{{ $evaluation->knowledge_of_position_comment_gm }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="form-label">Creativity & Innovation</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="creativity_innovation"
                                                id="creativity_innovation1"value="Exceeds expectations"
                                                {{ $evaluation->creativity_innovation == 'Exceeds expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="creativity_innovation1">Exceeds
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="creativity_innovation"
                                                id="creativity_innovation2"value="Meets expectations"
                                                {{ $evaluation->creativity_innovation == 'Meets expectations' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="creativity_innovation2">Meets
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="creativity_innovation"
                                                id="creativity_innovation3"value="Needs improvement"
                                                {{ $evaluation->creativity_innovation == 'Needs improvement' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="creativity_innovation3">Needs
                                                Improvement</label>

                                            <input type="radio" class="btn-check" name="creativity_innovation"
                                                id="creativity_innovation4"value="Unacceptable"
                                                {{ $evaluation->creativity_innovation == 'Unacceptable' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger"
                                                for="creativity_innovation4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">

                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                <textarea class="form-control" rows="3"name="creativity_innovation_comment_gm" readonly>{{ $evaluation->creativity_innovation_comment_gm }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- Performance Goals -->
                                <section class="mb-4">
                                    <h4 class="pb-2 border-bottom">III. Performance Goals</h4>
                                    <div class="mb-3">
                                        <label class="form-label">Set objectives and outline steps to improve in problem
                                            areas or further employee development</label>
                                        <textarea class="form-control" rows="4" name="performance_goals"readonly>{{ $evaluation->performance_goals }}</textarea>
                                    </div>
                                </section>

                                <!-- Overall Rating -->
                                <section class="mb-4">
                                    <h4 class="pb-2 border-bottom">IV. Overall Rating</h4>
                                    <div class="mb-3 btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="over_all_rating"
                                            id="over_all_rating1" value="Exceeds expectations"
                                            {{ $evaluation->over_all_rating == 'Exceeds expectations' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success" for="over_all_rating1">Exceeds
                                            Expectations</label>

                                        <input type="radio" class="btn-check" name="over_all_rating"
                                            id="over_all_rating2" value="Meets expectations"
                                            {{ $evaluation->over_all_rating == 'Meets expectations' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="over_all_rating2">Meets
                                            Expectations</label>

                                        <input type="radio" class="btn-check" name="over_all_rating"
                                            id="over_all_rating3" value="Needs improvement"
                                            {{ $evaluation->over_all_rating == 'Needs improvement' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning" for="over_all_rating3">Needs
                                            Improvement</label>

                                        <input type="radio" class="btn-check" name="over_all_rating"
                                            id="over_all_rating4" value="Unacceptable"
                                            {{ $evaluation->over_all_rating == 'Unacceptable' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-danger" for="over_all_rating4">Unacceptable</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Overall Performance Comments</label>
                                        <textarea class="form-control" rows="3" name="over_all_comment" readonly>{{ $evaluation->over_all_comment }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">EMPLOYEE COMMENTS </label>
                                        <textarea class="form-control" rows="3" name="note" readonly>{{ $evaluation->note }}</textarea>
                                    </div>
                                </section>

                                <!-- Employee Comments -->


                                <!-- Acknowledgement -->


                            </form>
                        </div>
                        <!-- end settings content-->


                    </div>
                </div> <!-- end card-->

            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->

  


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
