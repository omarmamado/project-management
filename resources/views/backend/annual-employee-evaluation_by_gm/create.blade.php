@extends('layouts.master')

@section('title', 'Create Annual Employee Evaluation ')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Create Annual Employee Evaluation </h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">HR</li>
    <li class="breadcrumb-item active">Create Annual Employee Evaluation </li>
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">


                <div class="card">
                    <div class="card-body">
                            <form action="{{ route('annual-employee-evaluation_by_gm.store') }}" method="post" class="form"
                                enctype="multipart/form-data">
                                @csrf

                                <section class="mb-4">
                                    <h4 class="pb-2 border-bottom">I. Employee Information</h4>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Employee Name</label>
                                            <select name="user_id" id="user_id" class="form-select select2" required>
                                                <option disabled selected>Select user</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" data-job-title="{{ $user->job_title }}">
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('company_id')
                                                <span class="help-block text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Job Title</label>
                                            <input type="text" id="job_title" class="form-control" readonly>
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
                                            <input type="radio" class="btn-check" name="quality_of_work" id="quality1" value="Exceeds expectations" required>
                                            <label class="btn btn-outline-success" for="quality1">Exceeds expectations</label>
                                    
                                            <input type="radio" class="btn-check" name="quality_of_work" id="quality2" value="Meets expectations">
                                            <label class="btn btn-outline-primary" for="quality2">Meets expectations</label>
                                    
                                            <input type="radio" class="btn-check" name="quality_of_work" id="quality3" value="Needs improvement">
                                            <label class="btn btn-outline-warning" for="quality3">Needs improvement</label>
                                    
                                            <input type="radio" class="btn-check" name="quality_of_work" id="quality4" value="Unacceptable">
                                            <label class="btn btn-outline-danger" for="quality4">Unacceptable</label>
                                        </div>
                                    </div>
                                        <div class="mt-2 row">
                                            
                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                @if(auth()->user()->role == 'gm') <!-- Replace 'gm' with the actual role identifier for General Manager -->
                                                    <textarea class="form-control" rows="3" name="quality_of_work_comment_gm"></textarea>
                                                @else
                                                    <div role="alert">
                                                        You do not have permission to write comments for the GM.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    <!-- Discipline & Punctuality -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Discipline & Punctuality</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="discipline_punctuality" id="discipline1" value="Exceeds expectations">
                                            <label class="btn btn-outline-success" for="discipline1">Exceeds
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="discipline_punctuality" id="discipline2"  value="Meets expectations">
                                            <label class="btn btn-outline-primary" for="discipline2">Meets
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="discipline_punctuality" id="discipline3" value="Needs improvement">
                                            <label class="btn btn-outline-warning" for="discipline3">Needs
                                                improvement</label>

                                            <input type="radio" class="btn-check" name="discipline_punctuality" id="discipline4" value="Unacceptable">
                                            <label class="btn btn-outline-danger" for="discipline4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">
                                           
                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                @if(auth()->user()->role == 'gm') <!-- Replace 'gm' with the actual role identifier for General Manager -->
                                                    <textarea class="form-control" rows="3" name="discipline_punctuality_comment_gm"></textarea>
                                                @else
                                                    <div role="alert">
                                                        You do not have permission to write comments for the GM.
                                                    </div>
                                                @endif
                                            </div>
                                          
                                    </div>

                                    <!-- Problem solving -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Problem Solving</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="problem_solving"
                                                id="problem1" value="Exceeds expectations">
                                            <label class="btn btn-outline-success" for="problem1">Exceeds expectations</label>

                                            <input type="radio" class="btn-check" name="problem_solving"
                                                id="problem2" value="Meets expectations">
                                            <label class="btn btn-outline-primary" for="problem2">Meets expectations</label>

                                            <input type="radio" class="btn-check" name="problem_solving"
                                                id="problem3" value="Needs improvement">
                                            <label class="btn btn-outline-warning" for="problem3">Needs improvement</label>

                                            <input type="radio" class="btn-check" name="problem_solving"
                                                id="problem4" value="Unacceptable">
                                            <label class="btn btn-outline-danger" for="problem4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">
                                            
                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                @if(auth()->user()->role == 'gm') <!-- Replace 'gm' with the actual role identifier for General Manager -->
                                                    <textarea class="form-control" rows="3" name="problem_solving_comment_gm"></textarea>
                                                @else
                                                    <div role="alert">
                                                        You do not have permission to write comments for the GM.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Continue with all other evaluation criteria -->
                                    <!-- Conflict Management -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Conflict Management</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="conflict_management" id="conflict_management1" value="Exceeds expectations" >
                                            <label class="btn btn-outline-success" for="conflict_management1">Exceeds
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="conflict_management" id="conflict_management2" value="Meets expectations" >
                                            <label class="btn btn-outline-primary" for="conflict_management2">Meets
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="conflict_management" id="conflict_management3" value="Needs improvement" >
                                            <label class="btn btn-outline-warning" for="conflict_management3">Needs
                                                improvement</label>

                                            <input type="radio" class="btn-check" name="conflict_management" id="conflict4" value="Unacceptable" >
                                            <label class="btn btn-outline-danger" for="conflict4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">
                                           
                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                @if(auth()->user()->role == 'gm') <!-- Replace 'gm' with the actual role identifier for General Manager -->
                                                    <textarea class="form-control" rows="3" name="quality_of_work_comment_gm"></textarea>
                                                @else
                                                    <div role="alert">
                                                        You do not have permission to write comments for the GM.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Time Management -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Time Effectiveness & Responsiveness</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="time_effectiveness_time_responsiveness_availability" id="time_effectiveness_time_responsiveness_availability1"value="Exceeds expectations"  >
                                            <label class="btn btn-outline-success" for="time_effectiveness_time_responsiveness_availability1">Exceeds
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="time_effectiveness_time_responsiveness_availability" id="time_effectiveness_time_responsiveness_availability2" value="Meets expectations">
                                            <label class="btn btn-outline-primary" for="time_effectiveness_time_responsiveness_availability2">Meets
                                                expectations</label>

                                            <input type="radio" class="btn-check" name="time_effectiveness_time_responsiveness_availability" id="time_effectiveness_time_responsiveness_availability3"value="Needs improvement"  >
                                            <label class="btn btn-outline-warning" for="time_effectiveness_time_responsiveness_availability3">Needs
                                                improvement</label>

                                            <input type="radio" class="btn-check" name="time_effectiveness_time_responsiveness_availability" id="time_effectiveness_time_responsiveness_availability4"value="Unacceptable" >
                                            <label class="btn btn-outline-danger" for="time_effectiveness_time_responsiveness_availability4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">
                                           
                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                @if(auth()->user()->role == 'gm') <!-- Replace 'gm' with the actual role identifier for General Manager -->
                                                <textarea class="form-control" rows="3"name="time_effectiveness_time_responsiveness_availability_comment_gm"></textarea>

                                            @else
                                                <div role="alert">
                                                    You do not have permission to write comments for the GM.
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Initiative & Flexibility -->
                                    <div class="mb-4">
                                        <h5 class="form-label">Initiative & Flexibility</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="initiative_flexibility" id="initiative_flexibility1"value="Exceeds expectations" >
                                            <label class="btn btn-outline-success" for="initiative_flexibility1">Exceeds
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="initiative_flexibility" id="initiative_flexibility2"value="Meets expectations">
                                            <label class="btn btn-outline-primary" for="initiative_flexibility2">Meets
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="initiative_flexibility" id="initiative_flexibility3"value="Needs improvement" >
                                            <label class="btn btn-outline-warning" for="initiative_flexibility3">Needs
                                                Improvement</label>

                                            <input type="radio" class="btn-check" name="initiative_flexibility" id="initiative_flexibility4"value="Unacceptable">
                                            <label class="btn btn-outline-danger" for="initiative_flexibility4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">
                                           
                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                @if(auth()->user()->role == 'gm') <!-- Replace 'gm' with the actual role identifier for General Manager -->
                                                <textarea class="form-control" rows="3"name="initiative_flexibility_comment_gm"></textarea>

                                            @else
                                                <div role="alert">
                                                    You do not have permission to write comments for the GM.
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="form-label">Cooperation & Teamwork:</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="cooperation_teamwork" id="cooperation_teamwork1"value="Exceeds expectations" >
                                            <label class="btn btn-outline-success" for="cooperation_teamwork1">Exceeds
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="cooperation_teamwork" id="cooperation_teamwork2"value="Meets expectations">
                                            <label class="btn btn-outline-primary" for="cooperation_teamwork2">Meets
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="cooperation_teamwork" id="cooperation_teamwork3"value="Needs improvement" >
                                            <label class="btn btn-outline-warning" for="cooperation_teamwork3">Needs
                                                Improvement</label>

                                            <input type="radio" class="btn-check" name="cooperation_teamwork" id="cooperation_teamwork4"value="Unacceptable">
                                            <label class="btn btn-outline-danger" for="cooperation_teamwork4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">
                                           
                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                @if(auth()->user()->role == 'gm') <!-- Replace 'gm' with the actual role identifier for General Manager -->
                                                <textarea class="form-control" rows="3"name="cooperation_teamwork_comment_gm"></textarea>

                                            @else
                                                <div role="alert">
                                                    You do not have permission to write comments for the GM.
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="form-label">Knowledge of Position:</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="knowledge_of_position" id="knowledge_of_position1"value="Exceeds expectations" >
                                            <label class="btn btn-outline-success" for="knowledge_of_position1">Exceeds
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="knowledge_of_position" id="knowledge_of_position2"value="Meets expectations">
                                            <label class="btn btn-outline-primary" for="knowledge_of_position2">Meets
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="knowledge_of_position" id="knowledge_of_position3"value="Needs improvement" >
                                            <label class="btn btn-outline-warning" for="knowledge_of_position3">Needs
                                                Improvement</label>

                                            <input type="radio" class="btn-check" name="knowledge_of_position" id="knowledge_of_position4"value="Unacceptable">
                                            <label class="btn btn-outline-danger" for="knowledge_of_position4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">
                                           
                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                @if(auth()->user()->role == 'gm') <!-- Replace 'gm' with the actual role identifier for General Manager -->
                                                <textarea class="form-control" rows="3"name="knowledge_of_position_comment_gm"></textarea>

                                            @else
                                                <div role="alert">
                                                    You do not have permission to write comments for the GM.
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="form-label">Creativity & Innovation</h5>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="creativity_innovation" id="creativity_innovation1"value="Exceeds expectations" >
                                            <label class="btn btn-outline-success" for="creativity_innovation1">Exceeds
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="creativity_innovation" id="creativity_innovation2"value="Meets expectations">
                                            <label class="btn btn-outline-primary" for="creativity_innovation2">Meets
                                                Expectations</label>

                                            <input type="radio" class="btn-check" name="creativity_innovation" id="creativity_innovation3"value="Needs improvement" >
                                            <label class="btn btn-outline-warning" for="creativity_innovation3">Needs
                                                Improvement</label>

                                            <input type="radio" class="btn-check" name="creativity_innovation" id="creativity_innovation4"value="Unacceptable">
                                            <label class="btn btn-outline-danger" for="creativity_innovation4">Unacceptable</label>
                                        </div>
                                        <div class="mt-2 row">
                                           
                                            <div class="col-md-12">
                                                <label class="form-label">Comments by G.M</label>
                                                @if(auth()->user()->role == 'gm') <!-- Replace 'gm' with the actual role identifier for General Manager -->
                                                <textarea class="form-control" rows="3"name="creativity_innovation_comment_gm"></textarea>

                                            @else
                                                <div role="alert">
                                                    You do not have permission to write comments for the GM.
                                                </div>
                                            @endif
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
                                        <textarea class="form-control" rows="4" name="performance_goals"></textarea>
                                    </div>
                                </section>

                                <!-- Overall Rating -->
                                <section class="mb-4">
                                    <h4 class="pb-2 border-bottom">IV. Overall Rating</h4>
                                    <div class="mb-3 btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="over_all_rating" id="over_all_rating1" value="Exceeds expectations" >
                                        <label class="btn btn-outline-success" for="over_all_rating1">Exceeds Expectations</label>

                                        <input type="radio" class="btn-check" name="over_all_rating" id="over_all_rating2" value="Meets expectations">
                                        <label class="btn btn-outline-primary" for="over_all_rating2">Meets Expectations</label>

                                        <input type="radio" class="btn-check" name="over_all_rating" id="over_all_rating3" value="Needs improvement" >
                                        <label class="btn btn-outline-warning" for="over_all_rating3">Needs Improvement</label>

                                        <input type="radio" class="btn-check" name="over_all_rating" id="over_all_rating4" value="Unacceptable">
                                        <label class="btn btn-outline-danger" for="over_all_rating4">Unacceptable</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Overall Performance Comments</label>
                                        <textarea class="form-control" rows="3" name="over_all_comment"></textarea>
                                    </div>
                                </section>

                                <!-- Employee Comments -->
                              

                                <!-- Acknowledgement -->
                                <div class="pt-3 text-right ">
                                    <div class="text-center d-flex justify-content-between"
                                        style="text-align: center">
                                        <button type="submit" name="save" id="save"
                                            class="save btn btn-primary">
                                            <i class='icon-save'></i> save
                                        </button>
                                    </div>

                            </form>
                        </div>
                        <!-- end settings content-->


                    </div>

                <!-- end col -->
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
    <script>
        document.getElementById('user_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const jobTitle = selectedOption.getAttribute('data-job-title');
    document.getElementById('job_title').value = jobTitle || '';
});

    </script>
@endsection
