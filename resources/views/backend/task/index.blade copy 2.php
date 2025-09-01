@extends('layouts.master')

@section('title', 'Tasks List')

@section('css')
    <style>
        .projects-container {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 20px;
            padding: 15px 0;
        }

        .project-card {
            flex: 0 0 350px;
            min-width: 350px;
            max-width: 350px;
        }

        .projects-container::-webkit-scrollbar {
            display: none;
        }

        .projects-container {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
    </style>
@endsection

@section('breadcrumb-title')
    <h3>Tasks List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item active">Tasks List</li>
@endsection

@section('content')
<section class="py-5 section dashboard">
    <div class="container-fluid">
        <div class="row g-4">
            @foreach ($projectInquiries as $projectInquiry)
                <div class="col-xxl-4 col-lg-6">
                    <div class="border-0 shadow-lg card rounded-3">
                        <div class="py-4 text-white card-header bg-gradient-primary rounded-top-3">
                            <h3 class="mb-0 fw-bold">
                                <i class="mdi mdi-folder-multiple-outline me-2"></i>
                                {{ $projectInquiry->name }}
                            </h3>
                        </div>
                        
                        <div class="p-4 card-body">
                            <div class="accordion custom-accordion" id="phasesAccordion-{{ $projectInquiry->id }}">
                                @foreach ($projectInquiry->phases as $phase)
                                    <div class="mb-3 border-0 accordion-item">
                                        <h5 class="accordion-header bg-light rounded-2">
                                            <button class="bg-transparent shadow-none accordion-button collapsed" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#phase-{{ $phase->id }}">
                                                <div class="d-flex w-100 align-items-center">
                                                    <span class="badge bg-info me-3">
                                                        <i class="mdi mdi-clock-outline me-1"></i>
                                                        {{ $phase->duration }} Days
                                                    </span>
                                                    <h5 class="mb-0 text-dark">{{ $phase->name }}</h5>
                                                </div>
                                            </button>
                                        </h5>
                                        
                                        <div id="phase-{{ $phase->id }}" 
                                             class="accordion-collapse collapse" 
                                             data-bs-parent="#phasesAccordion-{{ $projectInquiry->id }}">
                                            <div class="pt-3 accordion-body">
                                                <!-- Task Management Section -->
                                                <div class="tasks-wrapper">
                                                    <button type="button" 
                                                            class="mb-4 btn btn-primary btn-sm w-100 animate-hover"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#addTaskModal-{{ $phase->id }}">
                                                        <i class="mdi mdi-plus-circle-outline me-2"></i>
                                                        Add New Task
                                                    </button>
                                                    
                                                    <div class="task-list">
                                                        @foreach ($phase->tasks as $task)
                                                            <div class="mb-3 border-0 shadow-sm task-item card">
                                                                <div class="p-3 card-body">
                                                                    <div class="d-flex align-items-start">
                                                                        <div class="flex-grow-1">
                                                                            <div class="mb-2 d-flex align-items-center">
                                                                                <span class="badge me-2 
                                                                                      {{ $task->priority === 'high' ? 'bg-danger' : 
                                                                                         ($task->priority === 'medium' ? 'bg-warning' : 'bg-success') }}">
                                                                                    {{ ucfirst($task->priority) }}
                                                                                </span>
                                                                                <h6 class="mb-0">
                                                                                    <a href="#" class="text-decoration-none text-dark fw-bold"
                                                                                       data-bs-toggle="modal" 
                                                                                       data-bs-target="#editTaskModal{{ $task->id }}">
                                                                                        {{ $task->name }}
                                                                                    </a>
                                                                                </h6>
                                                                            </div>
                                                                            
                                                                            <p class="mb-2 text-muted small">
                                                                                <i class="mdi mdi-text-long me-1"></i>
                                                                                {{ \Illuminate\Support\Str::words($task->note, 8, '...') }}
                                                                            </p>
                                                                            
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <div class="timeline-info">
                                                                                    <small class="text-muted me-3">
                                                                                        <i class="mdi mdi-calendar-start me-1"></i>
                                                                                        {{ \Carbon\Carbon::parse($task->start_date)->format('d M') }}
                                                                                    </small>
                                                                                    <small class="text-muted">
                                                                                        <i class="mdi mdi-calendar-end me-1"></i>
                                                                                        {{ \Carbon\Carbon::parse($task->end_date)->format('d M') }}
                                                                                    </small>
                                                                                </div>
                                                                                
                                                                                <div class="user-avatar">
                                                                                    <span class="badge bg-light text-dark">
                                                                                        <i class="mdi mdi-account-circle-outline me-1"></i>
                                                                                        {{ $task->creator->name }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Add Task Modal -->
@foreach ($projectInquiries as $projectInquiry)
    @foreach ($projectInquiry->phases as $phase)
        <div class="modal fade" id="addTaskModal-{{ $phase->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="border-0 shadow modal-content">
                    <div class="text-white modal-header bg-primary">
                        <h5 class="modal-title">
                            <i class="mdi mdi-plus-circle-outline me-2"></i>
                            Create New Task
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="p-4 modal-body">
                        <form action="{{ route('task.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="phase_id" value="{{ $phase->id }}">
                            <input type="hidden" name="project_inquiries_id" value="{{ $phase->project_inquiry_id }}">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Task Title</label>
                                    <input type="text" name="name" class="form-control form-control-lg" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Priority Level</label>
                                    <select name="priority" class="form-select form-select-lg">
                                        <option value="high">🚨 High Priority</option>
                                        <option value="medium">⚠️ Medium Priority</option>
                                        <option value="low">✅ Low Priority</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Start Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-calendar"></i>
                                        </span>
                                        <input type="date" name="start_date" class="form-control form-control-lg">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Due Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-calendar"></i>
                                        </span>
                                        <input type="date" name="end_date" class="form-control form-control-lg">
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">Task Details</label>
                                    <textarea name="note" class="form-control form-control-lg" rows="4" 
                                              placeholder="Describe the task..."></textarea>
                                </div>
                            </div>
                            
                            <div class="border-0 modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="px-5 btn btn-primary">
                                    <i class="mdi mdi-content-save-check me-2"></i>
                                    Create Task
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach

<!-- Edit Task Modal -->
@foreach ($projectInquiries as $projectInquiry)
    @foreach ($projectInquiry->phases as $phase)
        @foreach ($phase->tasks as $task)
            <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="border-0 shadow modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title">
                                <i class="mdi mdi-pencil-circle-outline me-2"></i>
                                Edit Task: {{ $task->name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="p-4 modal-body">
                            <form action="{{ route('task.update', $task->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="phase_id" value="{{ $phase->id }}">
                                <input type="hidden" name="project_inquiries_id" value="{{ $phase->project_inquiry_id }}">
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Task Title</label>
                                        <input type="text" name="name" 
                                               class="form-control form-control-lg" 
                                               value="{{ $task->name }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Priority Level</label>
                                        <select name="priority" class="form-select form-select-lg">
                                            <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>🚨 High Priority</option>
                                            <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>⚠️ Medium Priority</option>
                                            <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>✅ Low Priority</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Start Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-calendar"></i>
                                            </span>
                                            <input type="date" name="start_date" 
                                                   class="form-control form-control-lg"
                                                   value="{{ $task->start_date }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Due Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-calendar"></i>
                                            </span>
                                            <input type="date" name="end_date" 
                                                   class="form-control form-control-lg"
                                                   value="{{ $task->end_date }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Task Details</label>
                                        <textarea name="note" class="form-control form-control-lg" 
                                                  rows="4" required>{{ $task->note }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="border-0 modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="px-5 btn btn-warning">
                                        <i class="mdi mdi-content-save-edit me-2"></i>
                                        Update Task
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
@endforeach

<style>
    .custom-accordion .accordion-button:not(.collapsed) {
        background: linear-gradient(45deg, #f8f9fa, #ffffff);
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }
    
    .task-item:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .animate-hover:hover {
        transform: scale(1.02);
        transition: all 0.3s ease;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6, #6366f1);
    }
    
    .form-control-lg {
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1rem;
        transition: border-color 0.3s ease;
    }
    
    .form-control-lg:focus {
        border-color: #3b82f6;
        box-shadow: none;
    }
    
    .modal-header {
        border-bottom: none;
        padding: 1.5rem 2rem;
    }
</style>
{{-- <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet"> --}}
@endsection