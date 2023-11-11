@extends('layouts.master')

@section('title')
Inventory
@endsection
<style>
</style>

@section('navigation')

@endsection

@section('content')
    <form id="searchForm" action="{{ route('searchInventory') }}" method="POST">
        @csrf
        <input type="hidden" value="" id="searchInput" name="searchInput">
    </form>
    <div class="card" style="border-radius: 10px;">
        <div class="card-header" style="background-color: #8acbff">
            <div class="row">
                <div class="col d-flex align-items-center">
                    Inventory List:
                </div>
                <div class="col">
                    <button class="btn btn-primary" style="float: right;" type="button" data-bs-toggle="modal" data-bs-target="#addModal">Add inventory</button>
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
                            <td>{{ $data->unit->unit }}</td>
                            <td>{{ $data->price }}</td>
                            <td>{{ $data->updated_at->format('M-m-Y') }}</td>
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
            {{-- {{ $data_inventory->links() }} --}}
        </div>
    </div>

    @include('plugin.table-plug')
    <!-- Modal for Adding Inventory -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Add Inventory</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" action="{{ route('storeInventory') }}" method="POST" enctype="multipart/form-data">
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
                            <div class="col" style="flex: 20%">
                                {{-- Unit: <input type="text" class="form-control" name="unit" required> --}}
                                Unit: 
                                <select class="form-select" name="unit_id" id="unit">
                                    <option selcted>Select Measure Unit</option>
                                    @forelse ($data_unit as $data)
                                        <option value="{{$data->id}}">{{$data->unit}}</option>
                                    @empty
                                        <option selected disabled>Empty</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col">
                                Price: <input type="text" class="form-control" name="price" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                Image: <input type="file" class="form-control" name="image" id="image">
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

    <!-- Modal for Editing Inventory -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Inventory</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('updateInventory') }}" method="POST" enctype="multipart/form-data">
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
                                Unit: 
                                <select class="form-select" name="unit_id" id="unit">

                                </select>
                            </div>
                            <div class="col">
                                Price: <input type="text" class="form-control" name="price" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Image: <input type="file" class="form-control" name="image" id="image">
                            </div>
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
@endsection


@section('script')
    <script>
        $(document).ready(function () {
            let data_inventory = @json($data_inventory);
            let data_unit = @json($data_unit);
            // Select2 start here
            $('.dropdown #deleteBtn').on('click', function(e) {
                e.preventDefault();
                $('#deleteModal').modal('show');
                let id = $(this).data('id');
                $('#deleteModal #id').val(id);
            });
            $('.dropdown #editBtn').on('click', function(e) {
                e.preventDefault();
                $('#editModal').modal('show');
                let id = $(this).data('id');
                let unit_id;
                $('#editModal #id').val(id);
                data_inventory.forEach(element => {
                    if (element.id == id) {
                        $('#editModal [name="product_name"]').val(element.product_name);
                        $('#editModal [name="quantity"]').val(element.quantity);
                        $('#editModal [name="price"]').val(element.price);
                        $('#editModal [name="survey_location"]').val(element.survey_location);
                        unit_id = element.unit.id;
                    }
                });
                data_unit.forEach(element => {
                    $('#editModal [name="unit_id"]').append(`<option value="${element.id}"${element.id == unit_id ? 'selected' : ''}>${element.unit}</option>`);
                });

            });
            $('#searchBar').keyup(function (e) { 
                e.preventDefault();
                let searchInput = $(this).val();
                $('#searchInput').val(searchInput);
            });
        });
        $('#searchBtn').click(function (e) { 
            e.preventDefault();
            $('#searchForm').submit();
        });
        $('#editBtn').click(() => {
            $('#editForm').submit();
        });
        $('#addBtn').click(() => {
            $('#addForm').submit();
        });
    </script>
@endsection
