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
                    Inventory List:
                </div>
                <div class="col">
                    <button class="btn btn-primary" style="float: right;" type="button" data-bs-toggle="modal" data-bs-target="#addInventoryModal">Add inventory</button>
                </div>
            </div>
        </div>
        <div class="card-body" id="dataTable">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Survey Location</th>
                        <th>Date</th>
                        <th style="width: 5%;">
                            <i class="bi bi-gear"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_inventory as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->product_name }}</td>
                            <td>{{ $data->quantity }}</td>
                            <td>{{ $data->unit }}</td>
                            <td>{{ $data->price }}</td>
                            <td>{{ $data->survey_location }}</td>
                            <td>{{ $data->updated_at }}</td>
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
                            <td colspan="8" class="text-center">
                                <span class="text-danger" style="font-weight: bold">No record Found</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $data_inventory->links() }}
        </div>
    </div>
@endsection
<!-- Modal for Adding Inventory -->
<div class="modal fade" id="addInventoryMOdal" tabindex="-1" aria-labelledby="addInventoryMOdalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="addInventoryMOdalLabel">Add Inventory</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" action="{{ route('storeInventory') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            Product Name: <input type="text" class="form-control" name="product_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Quantity: <input type="text" class="form-control" name="quantity" required>
                        </div>
                        <div class="col">
                            Unit: <input type="text" class="form-control" name="unit" required>
                        </div>
                        <div class="col">
                            Price: <input type="text" class="form-control" name="price" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Survey Location <input type="text" class="form-control" name="survey_location" required>
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
                <form id="editUserForm" action="{{ route('updateInventory') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col">
                            Product Name: <input type="text" class="form-control" name="product_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Quantity: <input type="text" class="form-control" name="quantity" required>
                        </div>
                        <div class="col">
                            Unit: <input type="text" class="form-control" name="unit" required>
                        </div>
                        <div class="col">
                            Price: <input type="text" class="form-control" name="price" required>
                        </div>
                    </div>
                    <div class="row">
                        Survey Location <input type="text" class="form-control" name="survey_location" required>
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
            <form action="{{ route('deleteInventory') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
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
            let getAllUsers = @json($data_inventory).data;
            $('.dropdown #deleteBtn').on('click', function(e) {
                e.preventDefault();
                $('#deleteUserModal').modal('show');
                let id = $(this).data('id');
                $('#deleteUserModal #id').val(id);
            });
            $('.dropdown #editBtn').on('click', function(e) {
                e.preventDefault();
                $('#editUserModal').modal('show');
                let id = $(this).data('id');
                $('#editUserModal #id').val(id);
                getAllUsers.forEach(element => {
                    if (element.id == id) {
                        $('#editUserModal [name="product_name"]').val(element.product_name);
                        $('#editUserModal [name="quantity"]').val(element.quantity);
                        $('#editUserModal [name="unit"]').val(element.unit);
                        $('#editUserModal [name="price"]').val(element.price);
                        $('#editUserModal [name="survey_location"]').val(element.survey_location);
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
