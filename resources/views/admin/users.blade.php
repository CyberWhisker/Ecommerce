@extends('layouts.master')

@section('title')
Users
@endsection
<style>
    #deleteBtn:hover {
        background-color: red;
        color: white;
    }
    #editBtn:hover {
        background-color: yellow;
    }
</style>

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
                    <button class="btn btn-primary" style="float: right;" type="button" data-bs-toggle="modal" data-bs-target="#addUserModal">Add user</button>
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
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="addUserModalLabel">Add User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" action="{{ route('storeUser') }}" method="POST">
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
                <button type="button" class="btn btn-primary" id="addUserBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="editUserModalLabel">Add User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" action="{{ route('editUser') }}" method="POST">
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
                    <div class="col">
                        Email: <input type="text" class="form-control" name="email" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" id="editUserBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Delete -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h1 class="modal-title fs-5 text-white" id="deleteUserModalLabel">Warning!</h1>
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
            let getAllUsers = @json($getAllUsers).data;
            $('.dropdown #deleteBtn').on('click', function(e) {
                e.preventDefault();
                $('#deleteUserModal').modal('show');
                let user_id = $(this).data('id');
                $('#deleteUserModal #user_id').val(user_id);
            });
            $('.dropdown #editBtn').on('click', function(e) {
                e.preventDefault();
                $('#editUserModal').modal('show');
                let user_id = $(this).data('id');
                $('#editUserModal #user_id').val(user_id);
                getAllUsers.forEach(element => {
                    if (element.id == user_id) {
                        $('#editUserModal [name="first_name"]').val(element.first_name);
                        $('#editUserModal [name="middle_name"]').val(element.middle_name);
                        $('#editUserModal [name="last_name"]').val(element.last_name);
                        $('#editUserModal [name="address"]').val(element.address);
                        $('#editUserModal [name="phone_number"]').val(element.phone_number);
                        $('#editUserModal [name="email"]').val(element.email);
                    }
                });
            })
        });
        $('#editUserBtn').click(() => {
            $('#editUserForm').submit();
        });
        $('#addUserBtn').click(() => {
            $('#userForm').submit();
        });
    </script>
@endsection
