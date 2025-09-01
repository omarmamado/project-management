@extends('layouts.master')

@section('title', 'Employee Evaluation List')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Employee Evaluation List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">HR</li>
    <li class="breadcrumb-item active">Employee Evaluation List</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">

                        @php
                            $currentDate = \Carbon\Carbon::now();
                            $lastWednesday = \Carbon\Carbon::now()
                                ->endOfMonth()
                                ->subDays(\Carbon\Carbon::now()->endOfMonth()->dayOfWeek !== 3 ? 7 - 3 : 0);
                            $isWithin48Hours =
                                $currentDate->greaterThanOrEqualTo($lastWednesday) &&
                                $currentDate->lessThan($lastWednesday->copy()->addHours(120));
                        @endphp

                        {{-- @if ($isWithin48Hours) --}}
                        <a href="{{ route('employee-evaluation.create') }}" type="button" class="btn btn-primary btn-sm">
                            <i class="icon-plus"></i> Add New
                        </a>
                        <div class="dt-ext table-responsive">
                            <br>
                            <table class="display" id="export-button">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>User</th>
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
                                                    (($user->is_manager && $user->role !== 'gm') || $user->role === 'hr') &&
                                                        $sameDepartment &&
                                                        (is_null($department) || $teamMembers->isNotEmpty()) &&
                                                        is_null($evaluation->knowledge_position) &&
                                                        is_null($evaluation->time_effectiveness) &&
                                                        is_null($evaluation->initiative_flexibility))
                                                    <a href="{{ route('employee-evaluation.edit', $evaluation->id) }}" >
                                                      
                                                        <i class="icon-pencil-alt" class="me-50"></i> 
                                                    </a>
                                                @endif


                                                @if (auth()->user()->role === 'gm' &&
                                                        is_null($evaluation->overall_comment) &&
                                                        \App\Models\User::find($evaluation->user_id)?->is_manager)
                                                    <a href="{{ route('employee-evaluation.edit', $evaluation->id) }}">
                                                        
                                                        <i class="icon-pencil-alt"></i>{{ __('Edit GM') }}
                                                    </a>
                                                @endif
                                                <a href="{{ route('employee-evaluation.show', $evaluation->id) }}">
                                                    <i class='icon-eye'></i> 

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
