@extends('layouts.master')

@section('title', 'Cash Requests ')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Cash Requests List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Cash Requests</li>
    <li class="breadcrumb-item active">Cash Requests List</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCashRequest">
                            <i class="icon-plus"></i>


                            Add New
                        </button>
                        <div class="dt-ext table-responsive">
                            <br>
                            <table class="display" id="export-button">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Request Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Request Note</th>
                                        <th>Status</th>
                                        <th>Requester</th>
                                        @if (auth()->user()->is_manager)
                                            <th>Approvals</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($requests as $request)
                                        <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>{{ $request->request_name }}</td>
                                            <td>{{ $request->request_date }}</td>
                                            <td>{{ $request->due_date }}</td>
                                            <td>{{ $request->amount }}</td>
                                            <td>{{ $request->reason }}</td>
                                            <td>
                                                @if ($request->status == 'approved_by_manager')
                                                    <span class="badge badge-glow bg-success">Approved by Manager</span>
                                                @elseif($request->status == 'approved_by_accounts')
                                                    <span class="badge badge-glow bg-success">Approved by Accounts</span>
                                                @elseif($request->status == 'approved_by_gm')
                                                    <span class="badge badge-glow bg-success">Approved by GM</span>
                                                @elseif($request->status == 'rejected')
                                                    <span class="badge badge-glow bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge badge-glow bg-primary">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ $request->user->name }}</td>
                                            @if (auth()->user()->is_manager)
                                                <td>
                                                    {{-- التحقق من حالة الطلب --}}
                                                    @if ($request->status === 'pending')
                                                        {{-- تحقق إذا كان المستخدم مديراً --}}
                                                        @if (auth()->user()->is_manager)
                                                            {{-- عرض الأزرار فقط إذا كان المستخدم مديراً --}}
                                                            <form
                                                                action="{{ route('cash_requests.update_status', $request->id) }}"
                                                                method="POST" enctype="multipart/form-data"
                                                                style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="action" value="approve">
                                                                <button type="submit" class="btn btn-link p-0">
                                                                    <i data-feather="check" class="text-success"></i>
                                                                    <!-- أيقونة الموافقة -->
                                                                </button>
                                                            </form>

                                                            <form method="POST"
                                                                action="{{ route('cash_requests.update_status', $request->id) }}"
                                                                style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="action" value="reject">
                                                                <button type="submit" class="btn btn-link p-0">
                                                                    <i data-feather="x" class="text-danger"></i>
                                                                    <!-- أيقونة الرفض -->
                                                                </button>
                                                            </form>
                                                        @else
                                                            {{-- إذا لم يكن المستخدم مديراً --}}
                                                            <button class="btn btn-link p-0" disabled>
                                                                <i data-feather="check" class="text-muted"></i>
                                                                <!-- أيقونة الموافقة مع تعطيل -->
                                                            </button>
                                                            <button class="btn btn-link p-0" disabled>
                                                                <i data-feather="x" class="text-muted"></i>
                                                                <!-- أيقونة الرفض مع تعطيل -->
                                                            </button>
                                                        @endif
                                                    @else
                                                        {{-- إذا كانت الحالة ليست pending (أي تمت الموافقة أو الرفض) --}}
                                                        <button class="btn btn-link p-0" disabled>
                                                            <i data-feather="check" class="text-muted"></i>
                                                            <!-- أيقونة الموافقة مع تعطيل -->
                                                        </button>
                                                        <button class="btn btn-link p-0" disabled>
                                                            <i data-feather="x" class="text-muted"></i>
                                                            <!-- أيقونة الرفض مع تعطيل -->
                                                        </button>
                                                    @endif
                                                </td>
                                            @endif


                                            {{-- <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $request->id }}">
                                                <i data-feather='edit'></i> Edit
                                            </button>
                                        </td> --}}
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit{{ $request->id }}" tabindex="-1"
                                            aria-labelledby="editCashRequest" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Edit Cash Request</h5>
                                                        <form action="{{ route('cash_requests.update', $request->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('patch')

                                                            <div class="row">
                                                                <div class="form-group col-6">
                                                                    <label for="requester_name">Title</label>
                                                                    <input type="text" name="request_name"
                                                                        class="form-control"
                                                                        value="{{ $request->request_name }}" required>
                                                                </div>
                                                                <div class="form-group col-6">
                                                                    <label for="amount">Amount</label>
                                                                    <input type="number" name="amount"
                                                                        class="form-control" value="{{ $request->amount }}"
                                                                        required>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group col-6">
                                                                    <label for="request_date">Request Date</label>
                                                                    <input type="date" name="request_date"
                                                                        value="{{ $request->request_date }}"
                                                                        class="form-control" readonly required>
                                                                </div>

                                                                <div class="form-group col-6">
                                                                    <label for="due_date">Due Date</label>
                                                                    <input type="date" name="due_date"
                                                                        class="form-control"
                                                                        value="{{ $request->due_date }}" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="example-fileinput">File</label>
                                                                <input type="file" name="attachment" class="form-control"
                                                                    placeholder="attachment">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="request_name">Request Note</label>
                                                                <textarea name="reason" class="form-control" cols="15" rows="3" placeholder="Request reason" required>{{ $request->reason }}</textarea>
                                                            </div>
                                                            <br>

                                                            <div id="fields-container-edit">
                                                                @foreach ($request->CashRequestItem as $index => $item)
                                                                    <div class="row">
                                                                        <div class="form-group col-5">
                                                                            <label for="item_name"></label>
                                                                            <input type="text" name="item_name[]"
                                                                                value="{{ $item->item_name }}"
                                                                                class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-5">
                                                                            <div class="form-group col-5">
                                                                                <label for="price"></label>
                                                                                <input type="number" name="price[]"
                                                                                    value="{{ $item->price }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-2">
                                                                                <label for="price"></label>
                                                                                <button type="button"
                                                                                    class="btn btn-danger remove-field">Remove</button>
                                                                            </div>
                                                                        </div>
                                                                @endforeach
                                                            </div>

                                                            {{-- <br>
                                                        <!-- زر لإضافة المزيد من الحقول -->
                                                        <button type="button" class="btn btn-primary" id="add-field1">Add More Fields</button>
                                                        
                                                        <br> --}}

                                                            <!-- زر لإضافة المزيد من الحقول -->


                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Save
                                                                    changes</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- End Edit Modal -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="addCashRequest" tabindex="-1" aria-labelledby="addCashRequestTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user" {{-- class="modal-dialog modal-dialog-centered" --}}>
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5>Add New Cash Request</h5>
    
                            <form action="{{ route('cash_requests.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="requester_name">Title</label>
                                        <input type="text" name="request_name" class="form-control" placeholder="Title"
                                            required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="form-label" for="modalAddCardNumber">Category</label>
                                        <select id="cash_category_id" name="cash_category_id"
                                            class="form-control add-credit-card-mask" id="modalAddCardNumber"
                                            class="my-1 custom-select mr-sm-2" required>
                                            <option value="" disabled selected>
                                                Category</option>
                                            @foreach ($cash_categories as $Category)
                                                <option value="{{ $Category->id }}">{{ $Category->name }}</option>
                                            @endforeach
                                        </select>
    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="request_date">Request Date</label>
                                        <input type="date" name="request_date" value="{{ date('Y-m-d') }}"
                                            class="form-control" readonly required>
                                    </div>
    
                                    <div class="form-group col-6">
                                        <label for="due_date">Due Date</label>
                                        <input type="date" name="due_date" class="form-control" required>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="example-fileinput">File</label>
                                        <input type="file" name="attachment" class="form-control"
                                            placeholder="attachment">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="amount">Amount</label>
                                        <input type="number" name="amount" class="form-control" placeholder="Amount"
                                            required>
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
                                    <div class="row mb-2">
                                        <div class="form-group col-5">
                                            <input type="text" name="item_name[]" class="form-control"
                                                placeholder="Item">
                                        </div>
                                        <div class="form-group col-5">
                                            <input type="number" name="price[]" class="form-control" placeholder="Price">
                                        </div>
                                        <!-- زر حذف الحقل -->
                                        <div class="form-group col-2">
                                            <button type="button" class="btn btn-danger remove-field">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
    
                                <!-- زر لإضافة المزيد من الحقول -->
                                <button type="button" class="btn btn-primary" id="add-field">Add More Fields</button>
    
    
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
          
    </div>
</div>

    <script>
        // دالة لإضافة حقول العناصر والسعر
        function addField(containerId) {
            var newFields = `
            <div class="row mb-2">
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
@endsection
