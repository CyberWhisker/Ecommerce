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
                    <button class="btn btn-success" style="float: right;" type="button" data-bs-toggle="modal" data-bs-target="#addUserModal">Add user</button>
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
                    @foreach ($getAllUsers as $data)
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
                                    Client
                                @endif
                            </td>
                            <td>
                                <div class="dropdown" style="border-radius: 10px;">
                                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li><a class="dropdown-item" href="#" id="setRole" data-id="{{$data->id}}">Set Role</a></li>
                                    </ul>
                                </div>                                
                            </td>
                        </tr>
                    @endforeach
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
                            First Name: <input type="text" class="form-control" name="first_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Middle Name: <input type="text" class="form-control" name="middle_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Last Name: <input type="text" class="form-control" name="last_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Address: <input type="text" class="form-control" name="address">
                        </div>
                        <div class="col">
                            Contact Number: <input type="text" class="form-control" name="phone_number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Email: <input type="text" class="form-control" name="email">
                        </div>
                        <div class="col">
                            Password: <input type="text" class="form-control" name="password">
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

<!-- Modal for editing role -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editRoleModalLabel">Set Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('updateRole') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <select class="form-select" name="role_as">
                        <option selected>Select Role</option>
                        <option value="1">Admin</option>
                        <option value="0">Client</option>
                      </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
    <script>
        $(document).ready(function () {
            $('.dropdown #setRole').on('click', function(e) {
                e.preventDefault();
                $('#editRoleModal').modal('show');
                let user_id = $(this).data('id');
                $('#user_id').val(user_id);
            })
        });
        $('#addUserBtn').click(() => {
            $('#userForm').submit();
        });
    </script>
@endsection
