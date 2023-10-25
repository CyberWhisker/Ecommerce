@extends('layouts.master')

@section('title')
Setting
@endsection
<style>
    .card {
        position: relative;
        display: inline-block;
        border-radius: 10px !important;
        height: 100%;
    }
</style>
@section('content')
    <div class="row" style="height: ">
        <div class="col">
            <div class="card">
                <div class="card-header" style="background-color: #8acbff;height: 50px;">
                    <div style="margin-top: 5px;">Setting</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-outline-warning" style="width: 100%">UNIT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col" style="flex: 50%">
            <div class="card">
                <div class="card-header" style="background-color: #8acbff;height: 50px;">
                    <div style="margin-top: 5px;"><span id="table_title">Choose Setting:</span></div>
                </div>
                <div class="card-body">
                    @include('admin.settingFolder.unit-table')
                </div>
            </div>
        </div>
    </div>

    @include('plugin.table-plug')

@endsection

<!-- Modal for Adding Inventory -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="addModalLabel">Add Unit</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="{{ route('storeUnit') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div style="padding-bottom: 10px">
                                <span>Unit Name:</span>     
                            </div>
                            <input type="text" class="form-control" name="unit" placeholder="Kilogram">
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
            <h1 class="modal-title fs-5" id="editModalLabel">Edit Modal User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="{{ route('updateUnit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col">
                            Unit <input type="text" class="form-control" name="unit" required>
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
            <form action="{{ route('deleteUnit') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    This unit will be deleted!
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
            let data_unit = @json($data_unit);
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
                $('#editModal #id').val(id);
                data_unit.forEach(element => {
                    if (element.id == id) {
                        $('#editModal [name="unit"]').val(element.unit);
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