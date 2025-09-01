@extends('admin_dashboard')
@section('admin')
    <style>
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
    </style>

    <!-- content -->
    <div class="pagetitle">
        <h1>Tasks List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Tasks List</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="container">
            <div class="row projects-row">
                @foreach ($projects as $project)
                    <div class="col-lg-4 col-md-6 project-item">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">{{ $project->name }}</h4>
                                <p class="sub-header">{{ $project->note }}</p>

                                <ul class="sortable-list tasklist list-unstyled" id="tasks-{{ $project->id }}">
                                    <!-- المهام المرتبطة بالمشروع ستظهر هنا -->
                                    @foreach ($project->tasks as $task)
                                        <li id="task2" class="border-0">
                                            <span
                                                class="badge float-end 
                                        {{ $task->priority === 'high' ? 'bg-danger text-white' : ($task->priority === 'medium' ? 'bg-warning text-dark' : 'bg-success text-white') }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            <h5 class="mt-0">
                                                <a href="javascript:void(0);" class="text-dark" data-bs-toggle="modal"
                                                    data-bs-target="#editTaskModal{{ $task->id }}">
                                                    {{ $task->name }}
                                                </a>
                                            </h5>
                                            <div class="form-check float-end ps-0">
                                                <input class="form-check-input" type="checkbox" value="">
                                            </div>
                                            <p>{{ \Illuminate\Support\Str::words($task->note, 15, '...') }}
                                            </p>
                                            <div class="clearfix"></div>
                                            <div class="row">
                                                <div class="col">
                                                    <label for=" Start Date">Start Date</label>
                                                    <p class="mt-2 mb-0 font-13"><i class="mdi mdi-calendar"></i>
                                                        {{ \Carbon\Carbon::parse($task->start_date)->format('M d, Y') }}
                                                    </p>
                                                </div>
                                                <div class="col">
                                                    <label for=" Start Date">End Date</label>
                                                    <p class="mt-2 mb-0 font-13"><i class="mdi mdi-calendar"></i>
                                                        {{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}
                                                    </p>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-end">
                                                        <label for=" Start Date"></label>

                                                        <span
                                                            class="badge bg-primary me-1">{{ $task->creator->name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1"
                                            aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editTaskModalLabel{{ $task->id }}">
                                                            Edit Task: {{ $task->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form تعديل المهمة -->
                                                        <form action="{{ route('task.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                            <div class="row">
                                                                <div class="mb-3 col-6">
                                                                    <label for="taskTitle-{{ $project->id }}" class="form-label">Task Title</label>
                                                                    <input type="text" name="name" class="form-control" id="taskTitle-{{ $project->id }}" value="{{ $task->name }}">
                                                                </div>
                                                                <div class="mb-3 col-6">
                                                                    <label for="priority-{{ $project->id }}">Priority</label>
                                                                    <select class="form-control" id="priority-{{ $project->id }}" name="priority">
                                                                        <option value="high">High</option>
                                                                        <option value="medium">Medium</option>
                                                                        <option value="low">Low</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-6">
                                                                    <label for="start_date-{{ $project->id }}" class="form-label">Start Date</label>
                                                                    <input type="date" name="start_date" class="form-control" id="start_date-{{ $project->id }}" value="{{ $task->start_date}} ">
                                                                </div>
                                                                <div class="mb-3 col-6">
                                                                    <label for="end_date-{{ $project->id }}" class="form-label">Due Date</label>
                                                                    <input type="date" name="end_date" class="form-control" id="end_date-{{ $project->id }}" value="{{ $task->end_date}}">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="taskDescription-{{ $project->id }}" class="form-label">Task Description</label>
                                                                <textarea class="form-control" name="note" id="taskDescription-{{ $project->id }}" rows="4" >{{ $task->note }}</textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Save Task</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </ul>

                                <!-- زر فتح النموذج -->
                                <button type="button" class="mt-3 btn btn-primary w-100 waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#addTaskModal-{{ $project->id }}">
                                    <i class="mdi mdi-plus-circle"></i> Add New Task
                                </button>

                            </div>
                        </div>
                    </div>

                    <!-- Add Task Modal لكل مشروع -->
                    <div class="modal fade" id="addTaskModal-{{ $project->id }}" tabindex="-1"
                        aria-labelledby="addTaskModalLabel-{{ $project->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addTaskModalLabel-{{ $project->id }}">Add New Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('task.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label for="taskTitle-{{ $project->id }}" class="form-label">Task
                                                    Title</label>
                                                <input type="text" name="name" class="form-control"
                                                    id="taskTitle-{{ $project->id }}" placeholder="Enter task title"
                                                    required>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label for="priority-{{ $project->id }}">Priority</label>
                                                <select class="form-control" id="priority-{{ $project->id }}"
                                                    name="priority">
                                                    <option value="high">High</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="low">Low</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label for="start_date-{{ $project->id }}" class="form-label">Start
                                                    Date</label>
                                                <input type="date" name="start_date" class="form-control"
                                                    id="start_date-{{ $project->id }}" required>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label for="end_date-{{ $project->id }}" class="form-label">Due
                                                    Date</label>
                                                <input type="date" name="end_date" class="form-control"
                                                    id="end_date-{{ $project->id }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="taskDescription-{{ $project->id }}" class="form-label">Task
                                                Description</label>
                                            <textarea class="form-control" name="note" id="taskDescription-{{ $project->id }}" rows="4"
                                                placeholder="Enter task description" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Task</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    {{-- 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addTaskBtns = document.querySelectorAll('.add-task-btn');
            let currentTaskList = null;
    
            // عند النقر على زر إضافة مهمة
            addTaskBtns.forEach(button => {
                button.addEventListener('click', function() {
                    const projectId = this.dataset.projectId; // الحصول على ID المشروع
                    currentTaskList = document.getElementById(`tasks-${projectId}`); // تحديد قائمة المهام الخاصة بالمشروع
                    document.getElementById('project_id').value = projectId; // تعيين المشروع بالنموذج
                    const modal = new bootstrap.Modal(document.getElementById('addTaskModal')); // فتح الـ Modal
                    modal.show();
                });
            });
    
            // عند إرسال النموذج
            document.getElementById('addTaskForm').addEventListener('submit', function(e) {
                e.preventDefault(); // منع الإرسال التقليدي للنموذج
                const formData = new FormData(this); // جمع البيانات من النموذج
                const projectId = document.getElementById('project_id').value; // الحصول على معرف المشروع
    
                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // إضافة CSRF token
                        }
                    })
                    .then(response => response.json()) // التعامل مع الاستجابة بصيغة JSON
                    .then(data => {
                        if (data.success) {
                            // إعادة تحميل قائمة المهام من قاعدة البيانات
                            fetch(`/projects/${projectId}/task`)
                                .then(response => response.json())
                                .then(tasks => {
                                    currentTaskList.innerHTML = ''; // مسح القائمة الحالية
                                    tasks.forEach(task => {
                                        const newTask = `
                                            <li class="border-0">
                                                <span class="badge bg-soft-${task.priority === 'high' ? 'danger' : task.priority === 'medium' ? 'warning' : 'success'} text-${task.priority === 'high' ? 'danger' : task.priority === 'medium' ? 'warning' : 'success'} float-end">
                                                    ${task.priority}
                                                </span>
                                                <h5 class="mt-0"><a href="javascript:void(0);" class="text-dark">${task.name}</a></h5>
                                                <p>${task.note || 'No description provided'}</p>
                                                <div class="clearfix"></div>
                                                <div class="row">
                                                    <div class="col">
                                                        <p class="mt-2 mb-0 font-13"><i class="mdi mdi-calendar"></i> ${task.start_date} - ${task.end_date}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        `;
                                        currentTaskList.insertAdjacentHTML('beforeend', newTask); // إضافة المهمة
                                    });
                                });
                            document.getElementById('addTaskForm').reset(); // إعادة تعيين النموذج
                            const modal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
                            modal.hide(); // إغلاق الـ Modal
                        } else {
                            alert(data.message || 'Failed to save task. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while saving the task.');
                    });
            });
        });
    </script> --}}






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
