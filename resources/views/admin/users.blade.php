@extends('layouts.master')

@section('title')
Users
@endsection

@section('navigation')

@endsection

@section('content')
    <div class="card" style="border-radius: 10px;">
        <div class="card-header" style="background-color: #8acbff">
            <div class="row">
                <div class="col d-flex align-items-center">
                    User List:
                </div>
                <div class="col">
                    <button class="btn btn-primary" style="float: right;" type="button" data-bs-toggle="modal" data-bs-target="#addModal">Add user</button>
                </div>
            </div>
        </div>
        <div class="card-body" id="dataTable">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 5%;">
                            <i class="bi bi-gear"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($getAllUsers as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->first_name }}</td>
                            <td>{{ $data->middle_name }}</td>
                            <td>{{ $data->last_name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>
                                @if ($data->role_as == '1')
                                    Admin
                                @else 
                                    Customer
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" id="editBtn" data-id="{{$data->id}}">Edit</a></li>
                                        <li><a class="dropdown-item" href="#" id="deleteBtn" data-id="{{$data->id}}">Delete</a></li>
                                    </ul>
                                </div>                                
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <span class="text-danger" style="font-weight: bold">No record Found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $getAllUsers->links() }}
        </div>
    </div>
@endsection
<!-- Modal for Adding User -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="addModalLabel">Add User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="{{ route('storeUser') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            First Name: <input type="text" class="form-control" name="first_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Middle Name: <input type="text" class="form-control" name="middle_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Last Name: <input type="text" class="form-control" name="last_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Address: <input type="text" class="form-control" name="address" required>
                        </div>
                        <div class="col">
                            Contact Number: <input type="text" class="form-control" name="phone_number" required>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Email: <input type="text" class="form-control" name="email" required>
                        </div>
                        <div class="col">
                            Password: <input type="text" class="form-control" name="password" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing User -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Edit User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="{{ route('editUser') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <div class="row">
                        <div class="col">
                            First Name: <input type="text" class="form-control" name="first_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Middle Name: <input type="text" class="form-control" name="middle_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Last Name: <input type="text" class="form-control" name="last_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Address: <input type="text" class="form-control" name="address" required>
                        </div>
                        <div class="col">
                            Contact Number: <input type="text" class="form-control" name="phone_number" required>
                        </div>
                    </div>
                    <div class="col" style="margin-top: 10px;">
                        Set Role: 
                        <select class="form-select select2" name="role_as" id="role_as" style="width: 30%;">
                            <option selected disabled>-Select Role-</option>
                            <option value="0">Customer</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" id="editBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h1 class="modal-title fs-5 text-white" id="deleteModalLabel">Warning!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('deleteUser') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id" value="">
                    This user will be deleted!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
    <script>
        $(document).ready(function () {
            // Select2 start here
            let getAllUsers = @json($getAllUsers).data;
            $('.dropdown #deleteBtn').on('click', function(e) {
                e.preventDefault();
                $('#deleteModal').modal('show');
                let user_id = $(this).data('id');
                $('#deleteModal #user_id').val(user_id);
            });
            $('.dropdown #editBtn').on('click', function(e) {
                e.preventDefault();
                $('#editModal').modal('show');
                let user_id = $(this).data('id');
                $('#editModal #user_id').val(user_id);
                getAllUsers.forEach(element => {
                    if (element.id == user_id) {
                        $('#editModal [name="first_name"]').val(element.first_name);
                        $('#editModal [name="middle_name"]').val(element.middle_name);
                        $('#editModal [name="last_name"]').val(element.last_name);
                        $('#editModal [name="address"]').val(element.address);
                        $('#editModal [name="phone_number"]').val(element.phone_number);
                        $('#editModal [name="email"]').val(element.email);
                    }
                });
            })
        });
        $('#editBtn').click(() => {
            $('#editForm').submit();
        });
        $('#addBtn').click(() => {
            $('#addForm').submit();
        });
    </script>
@endsection
