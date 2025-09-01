@extends('layouts.master')

@section('title', 'Annual Employee Evaluation By GM')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Annual Employee Evaluation By GM List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">HR</li>
    <li class="breadcrumb-item active">Annual Employee Evaluation By GM List</li>
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
                        @if (auth()->user()->role === 'gm')
                        <a href="{{ route('annual-employee-evaluation_by_gm.create') }}" type="button"
                            class="btn btn-primary btn-sm">
                            <i class="icon-plus"></i> Add New By GM
                        </a>
                    @endif
                        {{-- @endif  --}}

                        
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
                                                    $teamMembers = $department ? $department->users->where('id', '!=', $user->id) : collect();
                                                    $evaluationDepartment = $evaluation->user->department ?? null;
                                                    $sameDepartment = $evaluationDepartment && $evaluationDepartment->id === ($department->id ?? null);
                                                @endphp
                                            
                                                @if ($user->is_manager && is_null($evaluation->note))
                                                    <a href="{{ route('annual-employee-evaluation_by_gm.edit', $evaluation->id) }}">
                                                        <i data-feather="edit" class="text-primary"></i>
                                                    </a>
                                                @endif
                                            
                                                @if (auth()->user()->role === 'gm' &&
                                                    is_null($evaluation->cooperation_teamwork_comment_gm) &&
                                                    is_null($evaluation->knowledge_of_position_comment_gm) &&
                                                    is_null($evaluation->creativity_innovation_comment_gm) &&
                                                    \App\Models\User::find($evaluation->user_id)?->is_manager)
                                                    <a href="{{ route('annual-employee-evaluation_by_gm.edit', $evaluation->id) }}">
                                                        <i data-feather="edit" class="text-primary"></i>
                                                    </a>
                                                @endif
                                            
                                                <a href="{{ route('annual-employee-evaluation_by_gm.show', $evaluation->id) }}">
                                                    <i data-feather="eye" class="text-warning"></i>
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
