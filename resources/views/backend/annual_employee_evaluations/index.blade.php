@extends('layouts.master')

@section('title', 'Annual Employee EvaluationList')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Annual Employee Evaluation List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">HR</li>
    <li class="breadcrumb-item active">Annual Employee Evaluation List</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">


                        @php
                            $currentDate = now(); // التاريخ الحالي
                            $startDate = now()->month(1)->day(15)->startOfDay(); // 15 يناير
                            $endDate = now()->month(1)->day(18)->endOfDay(); // 18 يناير
                            $isWithinPeriod = $currentDate->between($startDate, $endDate); // التحقق من أن التاريخ الحالي ضمن الفترة
                        @endphp

                        {{-- @if (auth()->user()->is_manager && auth()->user()->role !== 'gm' && $isWithinPeriod) --}}
                        <a href="{{ route('annual-employee-evaluation.create') }}" type="button"
                            class="btn btn-primary btn-sm">
                            <i class="icon-plus"></i> Add New
                        </a>
                        {{-- @endif --}}

                        <div class="dt-ext table-responsive">
                            <br>
                            <table class="display" id="export-button">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>User</th>
                                        {{-- <th>Created By</th> --}}
                                        <th>Processes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @forelse ($evaluations as $evaluation)
                                        <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>{{ $evaluation->name }}</td>
                                            <td>{{ $evaluation->created_at->format('d-m-Y') }}</td>
                                            <td>{{ $evaluation->user->name ?? 'Unknown' }}</td>
                                            {{-- <td>{{ $evaluation->user->name ?? 'Unknown' }}</td> --}}

                                            <td>

                                                @php
                                                    $user = auth()->user();
                                                    $department = $user->department;
                                                    $teamMembers = $department
                                                        ? $department->users->where('id', '!=', $user->id)
                                                        : collect();
                                                    $evaluationDepartment = $evaluation->user->department ?? null; // قسم الشخص المرتبط بالتقييم
                                                    $sameDepartment =
                                                        $evaluationDepartment &&
                                                        $evaluationDepartment->id === ($department->id ?? null); // التحقق من أن القسم نفسه
                                                @endphp

                                                @if (
                                                    !$user->is_manager &&
                                                        (is_null($evaluation->quality_of_work_comment_gm) ||
                                                            is_null($evaluation->cooperation_teamwork_comment_gm) ||
                                                            is_null($evaluation->knowledge_of_position_comment_gm) ||
                                                            is_null($evaluation->creativity_innovation_comment_gm)))
                                                    <a href="{{ route('annual-employee-evaluation.edit', $evaluation->id) }}">
                                                        <i class="icon-pencil-alt" ></i> {{ __('Edit') }}
                                                    </a>
                                                @endif

                                                @if (auth()->user()->role === 'gm' &&
                                                        (is_null($evaluation->cooperation_teamwork_comment_gm) ||
                                                            is_null($evaluation->knowledge_of_position_comment_gm) ||
                                                            is_null($evaluation->creativity_innovation_comment_gm) ||
                                                            optional(\App\Models\User::find($evaluation->user_id))->is_manager))
                                                    <a href="{{ route('annual-employee-evaluation.edit', $evaluation->id) }}">
                                                        <i class="icon-pencil-alt" ></i> {{ __('Edit GM') }}
                                                    </a>
                                                @endif
                                                {{-- <a href="{{ route('annual-employee-evaluation.show', $evaluation->id) }}">
                                                    <i class='icon-eye'></i> --}}
                                                    <a href="{{ route('annual-employee-evaluation.show', $evaluation->id) }}">
                                                        <i class="icon-eye text-warning"></i> 
                                                    </a>

                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No evaluations available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->




        </div> <!-- container -->

    </div> <!-- content -->
@endsection
