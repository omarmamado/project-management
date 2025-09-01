@extends('layouts.master')

@section('title', 'Pass Key List ')

@section('css')

@endsection



@section('breadcrumb-title')
    <h3>Pass Key List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">HR</li>
    <li class="breadcrumb-item active">Pass Key List</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewCard">
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($usersWithAccounts as $account)
                                        <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>{{ $account->name }}</td>
                                            <td>
                                                <ul class="action">
                                                    <li class="edit">

                                                        <a href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#edit{{ $account->id }}">
                                                            <i class="icon-pencil-alt"></i>
                                                        </a>
                                                    </li>
                                                    <li class="delete">
                                                        <a href="#!" data-bs-toggle="modal"
                                                            data-bs-target="#show{{ $account->id }}">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- //  show --}}

                            @foreach ($usersWithAccounts as $account)
                                <div class="modal fade" id="show{{ $account->id }}" tabindex="-1"
                                    aria-labelledby="show{{ $account->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="show{{ $account->id }}Label">Details of
                                                    {{ $account->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table" id="editAccountsTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Website Name</th>
                                                            <th>Account Email</th>
                                                            <th>Account Password</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($account->accounts as $user)
                                                            <tr>
                                                                <td>
                                                                    <input type="text"
                                                                        name="accounts[{{ $user->id }}][website_name]"
                                                                        class="form-control"
                                                                        value="{{ $user->website_name }}" disabled>
                                                                </td>
                                                                <td>
                                                                    <input type="email"
                                                                        name="accounts[{{ $user->id }}][account_email]"
                                                                        class="form-control"
                                                                        value="{{ $user->account_email }}" disabled>
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="accounts[{{ $user->id }}][account_password]"
                                                                        class="form-control"
                                                                        value="{{ $user->account_password }}" disabled>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden"
                                                                        name="accounts[{{ $user->id }}][id]"
                                                                        value="{{ $user->id }}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            <!-- مودالات التعديل خارج الجدول -->
                            @foreach ($usersWithAccounts as $account)
                                <div class="modal fade" id="edit{{ $account->id }}" tabindex="-1"
                                    aria-labelledby="edit{{ $account->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="bg-transparent modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="pb-5 modal-body px-sm-5 mx-50">
                                                <h1 class="mb-1 text-center" id="editCardTitle">Edit Pass Key for
                                                    {{ $account->name }}</h1>
                                                <!-- Form -->
                                                <form id="editCardValidation"
                                                    action="{{ route('pass-key.update', $account->id) }}"
                                                    class="row gy-1 gx-2 mt-75" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <table class="table" id="editAccountsTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Website Name</th>
                                                                <th>Account Email</th>
                                                                <th>Account Password</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($account->accounts as $user)
                                                                <tr>
                                                                    <td>
                                                                        <input type="text"
                                                                            name="accounts[{{ $user->id }}][website_name]"
                                                                            class="form-control"
                                                                            value="{{ $user->website_name }}" required>
                                                                    </td>
                                                                    <td>
                                                                        <input type="email"
                                                                            name="accounts[{{ $user->id }}][account_email]"
                                                                            class="form-control"
                                                                            value="{{ $user->account_email }}" required>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text"
                                                                            name="accounts[{{ $user->id }}][account_password]"
                                                                            class="form-control"
                                                                            value="{{ $user->account_password }}" required>
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden"
                                                                            name="accounts[{{ $user->id }}][id]"
                                                                            value="{{ $user->id }}">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="addRowEdit()">Add Another Account</button>
                                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                    {{-- add model --}}
            <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="bg-transparent modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="pb-5 modal-body px-sm-5 mx-50">
                        <h4 class="mb-1 text-center" id="addNewCardTitle">Add New Pass Key</h4>

                        <!-- form -->
                        <form id="addNewCardValidation" action="{{ route('pass-key.store') }}"
                            class="row gy-1 gx-2 mt-75" method="POST">
                            @csrf
                            <table class="table" id="addAccountsTable">
                                <thead>
                                    <tr>
                                        <th>Website Name</th>
                                        <th>Account Email</th>
                                        <th>Account Password</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="accounts[0][website_name]"
                                                class="form-control" required></td>
                                        <td><input type="email" name="accounts[0][account_email]"
                                                class="form-control" required></td>
                                        <td><input type="text" name="accounts[0][account_password]"
                                                class="form-control" required></td>
                                        <td><button type="button" class="btn btn-danger"
                                                onclick="removeRowAdd(this)">Remove</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary" onclick="addRowAdd()">Add Another
                                Account</button>
                            <button type="submit" class="btn btn-success">Save Accounts</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--/ add new card modal  -->

                </div>

            </div>
            
        </div>
    </div>
    </section>
    <script>
        // دوال لإضافة وحذف الصفوف في `modal` الإضافة
        let addAccountIndex = 1;

        function addRowAdd() {
            const tableBody = document.getElementById('addAccountsTable').getElementsByTagName('tbody')[0];
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
        <td><input type="text" name="accounts[${addAccountIndex}][website_name]" class="form-control" required></td>
        <td><input type="email" name="accounts[${addAccountIndex}][account_email]" class="form-control" required></td>
        <td><input type="text" name="accounts[${addAccountIndex}][account_password]" class="form-control" required></td>
        <td><button type="button" class="btn btn-danger" onclick="removeRowAdd(this)">Remove</button></td>
    `;

            tableBody.appendChild(newRow);
            addAccountIndex++;
        }

        function removeRowAdd(button) {
            button.closest('tr').remove();
        }
    </script>
    <script>
        // دالة لإضافة صف جديد في modal التعديل
        // دالة لإضافة صف جديد في modal التعديل
        function addRowEdit() {
            const tableBody = document.getElementById("editAccountsTable").getElementsByTagName("tbody")[0];

            if (!tableBody) {
                console.error("Cannot find table body with ID editAccountsTable");
                return;
            }

            const newRow = document.createElement("tr");
            let rowIndex = tableBody.getElementsByTagName("tr").length; // للحصول على عدد الصفوف الحالية

            newRow.innerHTML = `
        <td><input type="text" name="accounts[new_${rowIndex}][website_name]" class="form-control" required></td>
        <td><input type="email" name="accounts[new_${rowIndex}][account_email]" class="form-control" required></td>
        <td><input type="text" name="accounts[new_${rowIndex}][account_password]" class="form-control" required></td>
       <td><button type="button" class="btn btn-danger" onclick="removeRowEdit(this)">Remove</button></td>
    `;

            tableBody.appendChild(newRow);
        }

        // دالة لحذف صف معين من modal التعديل
        function removeRowEdit(button) {
            const row = button.closest("tr");
            if (row) {
                row.remove();
            }
        }
    </script>
@endsection
