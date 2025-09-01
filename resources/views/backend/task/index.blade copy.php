@extends('layouts.master')

@section('title', 'Tasks List')

@section('css')
{{-- <style>
    /* استخدام flexbox لعرض المشاريع بشكل أفقي */
    .projects-row {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        /* تفعيل التمرير الأفقي */
        padding: 10px 0;
    }

    /* تحديد العناصر داخل الصف بحيث تكون بجانب بعضها */
    .project-item {
        flex: 0 0 auto;
        /* منعه من التمدد أو الانكماش */
        margin-right: 15px;
        /* مساحة بين المشاريع */
    }

    /* إخفاء شريط التمرير في المتصفحات الحديثة */
    .projects-row::-webkit-scrollbar {
        display: none;
    }

    /* لإخفاء شريط التمرير في فايرفوكس */
    .projects-row {
        scrollbar-width: none;
    }

    /* لإخفاء شريط التمرير في Internet Explorer */
    .projects-row {
        -ms-overflow-style: none;
    }
</style> --}}
<style>
    .section.dashboard {
        padding: 20px 0;
    }
    
    .projects-row {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        align-items: start;
    }
    
    .project-item {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .project-item .card-body {
        padding: 20px;
    }
    
    .header-title {
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }
    
    .sub-header {
        color: #3498db;
        font-size: 1.1rem;
        margin: 15px 0;
    }
    
    .sortable-list.tasklist {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .sortable-list li {
        background: #f8f9fa;
        padding: 12px;
        margin: 8px 0;
        border-radius: 6px;
        transition: transform 0.2s;
    }
    
    .sortable-list li:hover {
        transform: translateX(5px);
    }
    
    .btn-add-task {
        width: 100%;
        padding: 10px;
        border: 2px dashed #3498db;
        background: rgba(52, 152, 219, 0.1);
        color: #3498db;
        transition: all 0.3s;
    }
    
    .btn-add-task:hover {
        background: #3498db;
        color: white;
    }
    
    .task-meta {
        font-size: 0.9em;
        color: #666;
        margin-top: 10px;
    }
    
    .badge.priority {
        font-weight: 500;
        padding: 5px 10px;
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

 

    
    <section class="section dashboard">
        <div class="container">
            <div class="projects-row">
                @foreach ($projectInquiries as $projectInquiry)
                <div class="project-item">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">{{ $projectInquiry->name }}</h4>
                            
                            @foreach ($projectInquiry->phases as $phase)
                                @if ($phase->status === 'approved' && $phase->users->isNotEmpty())
                                <div class="phase-section">
                                    <h4 class="sub-header">{{ $phase->name }}</h4>
                                    
                                    <ul class="sortable-list tasklist" id="tasks-{{ $phase->id }}">
                                        @foreach ($phase->tasks as $task)
                                        <!-- Task Item Code Here -->
                                        @endforeach
                                    </ul>
                                    
                                    <button type="button" class="btn btn-add-task" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#addTaskModal-{{ $phase->id }}">
                                        <i class="mdi mdi-plus-circle"></i> Add New Task
                                    </button>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection