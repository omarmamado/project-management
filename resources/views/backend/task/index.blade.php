@extends('layouts.master')

@section('title', 'Tasks List')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">

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

        .card .card-header {
            padding: 15px;

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
    <section class="section dashboard">
        <div class="container-fluid">
            <div class="projects-container">
                @foreach ($projectInquiries as $projectInquiry)
                    <div class="project-card">
                        <div class="card">
                            <div class="text-white card-header bg-primary">
                                <h6>{{ $projectInquiry->name }}</h6>
                            </div>
                            <div class="card-body">
                                @foreach ($projectInquiry->phases as $phase)
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="text-secondary">{{ $phase->name }}</h6>
                                            <button type="button" title=" Add Cash Request"
                                                class=" btn-outline-success rounded-pill" data-bs-toggle="modal"
                                                data-bs-target="#cashRequestModal-{{ $phase->id }}">
                                                <i class="fa fa-plus-circle"></i>
                                            </button>
                                        </div>
                                        <span>{{ $phase->manager->name }}</span>

                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <button type="button"
                                                    class="mb-3 btn btn-outline-primary rounded-pill w-100"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addTaskModal-{{ $phase->id }}">
                                                    <i class="fa fa-plus-circle"></i> Add New Task
                                                </button>
                                            </li>

                                            @foreach ($phase->tasks as $task)
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span
                                                            class="badge
                                                        {{ $task->priority === 'high' ? 'bg-danger' : ($task->priority === 'medium' ? 'bg-warning' : 'bg-success') }}">
                                                            {{ ucfirst($task->priority) }}
                                                        </span>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#editTaskModal{{ $task->id }}">
                                                            {{ $task->name }}
                                                        </a>
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ \Illuminate\Support\Str::words($task->note, 10, '...') }}
                                                    </small>
                                                    <div class="mt-2 d-flex justify-content-between">
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

                                                        <div class="d-flex align-items-center">
                                                            @php
                                                                $assignedUsers = $task->users->take(1);
                                                                $hiddenUsers = $task->users->slice(1);
                                                            @endphp
                                                            @foreach ($assignedUsers as $user)
                                                                <span class="badge bg-info me-1">{{ $user->name }}</span>
                                                            @endforeach
                                                            @if ($hiddenUsers->count() > 0)
                                                                <span class="badge bg-secondary" data-bs-toggle="tooltip"
                                                                    title="{{ $hiddenUsers->pluck('name')->join(', ') }}">
                                                                    +{{ $hiddenUsers->count() }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                <!-- 👇 نموذج إضافة تعليق وملفات -->
                                                <form action="{{ route('task-comments.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                    <textarea name="comment" class="mt-2 form-control" placeholder="اكتب تعليقًا..."></textarea>
                                                    <input type="file" name="files[]" class="my-1 form-control" multiple>
                                                    <button type="submit" class="btn btn-sm btn-primary">نشر
                                                        التعليق</button>
                                                </form>

                                                <!-- 👇 عرض التعليقات الأساسية -->
                                                @foreach ($task->comments()->whereNull('parent_id')->latest()->get() as $comment)
                                                    <div class="p-2 mt-3 border rounded">
                                                        <strong>{{ $comment->user->name }}</strong>:
                                                        {{ $comment->comment }}

                                                        <!-- عرض الملفات إن وجدت -->
                                                        @foreach ($comment->files as $file)
                                                            <div><a href="{{ asset($file->file_path) }}"
                                                                    target="_blank">{{ basename($file->file_path) }}</a>
                                                            </div>
                                                        @endforeach

                                                        <!-- زر عرض الردود -->
                                                        <button class="btn btn-sm btn-link show-replies-btn"
                                                            data-comment-id="{{ $comment->id }}">
                                                            عرض الردود
                                                        </button>
                                                        <div class="replies-container" id="replies-{{ $comment->id }}">
                                                        </div>

                                                        <!-- نموذج الرد -->
                                                        <form action="{{ route('task-comments.store') }}" method="POST"
                                                            enctype="multipart/form-data" class="mt-2">
                                                            @csrf
                                                            <input type="hidden" name="task_id"
                                                                value="{{ $task->id }}">
                                                            <input type="hidden" name="parent_id"
                                                                value="{{ $comment->id }}">
                                                            <textarea name="comment" class="mb-1 form-control" placeholder="ردك..."></textarea>
                                                            <input type="file" name="files[]" class="mb-1 form-control"
                                                                multiple>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success">رد</button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </div>

                                    <!-- Cash Request Modal -->
                                    <div class="modal fade" id="cashRequestModal-{{ $phase->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Cash Request for {{ $phase->name }}</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('task.cashRequest', ['id' => $task->id]) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="phase_id"
                                                            value="{{ $phase->id }}">
                                                        <input type="hidden" name="project_inquiries_id"
                                                            value="{{ $phase->project_inquiry_id }}">

                                                        <div class="row">
                                                            <div class="form-group col-6">
                                                                <label for="requester_name">Title</label>
                                                                <input type="text" name="request_name"
                                                                    class="form-control" placeholder="Title" required>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <label class="form-label"
                                                                    for="modalAddCardNumber">Category</label>
                                                                <select id="cash_category_id" name="cash_category_id"
                                                                    class="form-control add-credit-card-mask"
                                                                    id="modalAddCardNumber"
                                                                    class="my-1 custom-select mr-sm-2" required>
                                                                    <option value="" disabled selected>
                                                                        Category</option>
                                                                    @foreach ($cash_categories as $Category)
                                                                        <option value="{{ $Category->id }}">
                                                                            {{ $Category->name }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-6">
                                                                <label for="request_date">Request Date</label>
                                                                <input type="date" name="request_date"
                                                                    value="{{ date('Y-m-d') }}" class="form-control"
                                                                    readonly required>
                                                            </div>

                                                            <div class="form-group col-6">
                                                                <label for="due_date">Due Date</label>
                                                                <input type="date" name="due_date"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group col-6">
                                                                <label for="example-fileinput">File</label>
                                                                <input type="file" name="attachment"
                                                                    class="form-control" placeholder="attachment">
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <label for="amount">Amount</label>
                                                                <input type="number" name="amount" class="form-control"
                                                                    placeholder="Amount" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="request_name">Request Note</label>
                                                            <textarea name="reason" id=""class="form-control" cols="15"
                                                                rows="3"placeholder="Request reason" required></textarea>
                                                            {{-- <input type="text" name="reason" class="form-control" placeholder="Request reason" required> --}}
                                                        </div>
                                                        <br>
                                                        <div id="fields-container">
                                                            <!-- الحقل الأول -->
                                                            <div class="mb-2 row">
                                                                <div class="form-group col-5">
                                                                    <input type="text" name="item_name[]"
                                                                        class="form-control" placeholder="Item">
                                                                </div>
                                                                <div class="form-group col-5">
                                                                    <input type="number" name="price[]"
                                                                        class="form-control" placeholder="Price">
                                                                </div>
                                                                <!-- زر حذف الحقل -->
                                                                <div class="form-group col-2">
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-field">Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <!-- زر لإضافة المزيد من الحقول -->
                                                        <button type="button" class="btn btn-primary" id="add-field">Add
                                                            More Fields</button>


                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add Task Modal -->
                                    <div class="modal fade" id="addTaskModal-{{ $phase->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add New Task</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('task.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="phase_id"
                                                            value="{{ $phase->id }}">
                                                        <input type="hidden" name="project_inquiries_id"
                                                            value="{{ $phase->project_inquiry_id }}">

                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Task Title</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Priority</label>
                                                                <select name="priority" class="form-control">
                                                                    <option value="high">High</option>
                                                                    <option value="medium">Medium</option>
                                                                    <option value="low">Low</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Start Date</label>
                                                                <input type="date" name="start_date"
                                                                    class="form-control" required>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">End Date</label>
                                                                <input type="date" name="end_date"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Select user</label>
                                                            <select name="user_ids[]"
                                                                id="user_ids{{ $phase->id }}"class="js-example-placeholder-multiple col-sm-12"
                                                                multiple="multiple" required>
                                                                <option disabled>Select user</option>
                                                                @foreach ($phase->users as $user)
                                                                    <option value="{{ $user->id }}">
                                                                        {{ $user->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Task Description</label>
                                                            <textarea name="note" class="form-control" rows="4"></textarea>
                                                        </div>



                                                        <button type="submit" class="btn btn-primary">Save Task</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Task Modals -->
                                    @foreach ($phase->tasks as $task)
                                        <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Task: {{ $task->name }}</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('task.update', $task->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="phase_id"
                                                                value="{{ $phase->id }}">
                                                            <input type="hidden" name="project_inquiries_id"
                                                                value="{{ $phase->project_inquiry_id }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $task->id }}">


                                                            <div class="row">
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Task Title</label>
                                                                    <input type="text" name="name"
                                                                        class="form-control" value="{{ $task->name }}"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Priority</label>
                                                                    <select name="priority" class="form-control">
                                                                        <option value="high"
                                                                            {{ $task->priority == 'high' ? 'selected' : '' }}>
                                                                            High</option>
                                                                        <option value="medium"
                                                                            {{ $task->priority == 'medium' ? 'selected' : '' }}>
                                                                            Medium</option>
                                                                        <option value="low"
                                                                            {{ $task->priority == 'low' ? 'selected' : '' }}>
                                                                            Low</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Start Date</label>
                                                                    <input type="date" name="start_date"
                                                                        class="form-control"
                                                                        value="{{ $task->start_date }}" required>
                                                                </div>
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">End Date</label>
                                                                    <input type="date" name="end_date"
                                                                        class="form-control"
                                                                        value="{{ $task->end_date }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Edit Users</label>
                                                                <select name="user_ids[]"
                                                                    id="user_ids{{ $phase->id }}"
                                                                    class="js-example-placeholder-multiple col-sm-12"
                                                                    multiple="multiple" required>
                                                                    <option disabled>Select user</option>
                                                                    @foreach ($phase->users as $user)
                                                                        <option value="{{ $user->id }}"
                                                                            {{ in_array($user->id, $task->users->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                                            {{ $user->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Task Description</label>
                                                                <textarea name="note" class="form-control" rows="4">{{ $task->note }}</textarea>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary">Update
                                                                Task</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



@section('script')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // دالة لإضافة حقول العناصر والسعر
        function addField(containerId) {
            var newFields = `
            <div class="mb-2 row">
                <div class="form-group col-5">
                    <input type="text" name="item_name[]" class="form-control" placeholder="Item" required>
                </div>
                <div class="form-group col-5">
                    <input type="number" name="price[]" class="form-control" placeholder="Price" required>
                </div>
                <div class="form-group col-2">
                    <button type="button" class="btn btn-danger remove-field">Remove</button>
                </div>
            </div>
        `;
            document.getElementById(containerId).insertAdjacentHTML('beforeend', newFields);
        }

        // إضافة حقل جديد عند الضغط على زر إضافة حقل
        document.getElementById('add-field').addEventListener('click', function() {
            addField('fields-container'); // إضافة الحقول إلى الحاوية
        });

        // استخدام تفويض الأحداث لحذف الحقل عند الضغط على زر الحذف
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-field')) {
                e.preventDefault(); // منع السلوك الافتراضي للزر (إذا كان من نوع submit)
                e.target.closest('.row').remove(); // حذف الحقل
            }
        });

        // إضافة حقل تلقائيًا إذا كانت الحاوية فارغة عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            var addContainer = document.getElementById('fields-container');

            // تحقق من وجود العناصر المبدئية في الحاوية
            if (addContainer && addContainer.children.length === 0) {
                addField('fields-container'); // إضافة حقل واحد على الأقل إذا كانت الحاوية فارغة
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.show-replies-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const container = document.getElementById('replies-' + commentId);

                    if (container.innerHTML.trim() === '') {
                        fetch(`/task-comment/replies/${commentId}`)
                            .then(response => response.json())
                            .then(data => {
                                container.innerHTML = data.replies;
                            })
                            .catch(error => console.error('Error:', error));
                    } else {
                        container.innerHTML = ''; // toggle off
                    }
                });
            });
        });
    </script>


@endsection

@endsection
