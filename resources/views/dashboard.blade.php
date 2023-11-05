@extends('layouts.apprintice')
<style>
    .content #items {
        max-width: 230px;
        min-width: 230px;
        max-height: 230px;
        min-height: 230px;
        margin-left: 20px; 
        margin-bottom: 20px; 
    }
    .container .card {
        border-radius: 10px;
    }
</style>
@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>
        
        <div class="container" style="padding: 20px;">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">
                            <span>Search</span>
                        </div>
                        <div class="card-body text-center">
                            <form action="{{ route('searchProduct') }}" method="POST">
                                @csrf
                                <input type="text" class="form-control" name="searchInput" style="border-radius: 10px;" placeholder="Product Name">
                                <button type="submit" class="btn btn-outline-primary" style="width: 100%; margin-top: 10px;">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col" style="flex: 65%;">
                    <div class="content">
                        <div class="row">
                            @forelse ($data_inventory as $data)
                                <div class="col" id="items" style="margin-bottom: 90px;">
                                    <div class="card">
                                        <div class="card-body" style="height: 200px;">
                                            @if ($data->image != null)
                                                <img src="{{ asset('storage/'.$data->image)}}" alt="Image" style="width: 100%; height: 100%;">
                                            @else 
                                                <img src="{{ asset('images/no-image.png')}}" alt="No Image">
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col">
                                                    {{$data->product_name}}
                                                </div>
                                                <div class="col">
                                                    <span class="text-danger" style="float: right; font-weight:bold">₱ {{$data->price}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    Available:
                                                    <span class="{{$data->quantity <= 0 ? 'text-danger' : ''}}"> {{$data->quantity <= 0 ? 'Out of stock' : $data->quantity}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn {{$data->quantity <= 0 ? 'btn-outline-secondary' : 'btn-outline-success'}}" id="addOrderBtn" data-id="{{$data->id}}" data-quantity="{{$data->quantity}}" {{$data->quantity <= 0 ? 'Disabled' : ''}}>Buy</button>
                                                    <button type="button" class="btn btn-warning" id="addCartBtn" data-id="{{$data->id}}" data-quantity="{{$data->quantity}}">Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            @empty
                                <div class="card">
                                    <div class="card-body text-center">
                                        <span>Inventory is Empty!</span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endsection

<!-- Modal for Add Cart -->
<div class="modal fade" id="addCartModal" tabindex="-1" aria-labelledby="addCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h1 class="modal-title fs-5 text-white" id="addCartModalLabel">Add to Cart</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('storeCart') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="inventory_id" id="id" value="">
                    <span>Product Name:</span>
                    <input type="text" class="form-control" style="border-radius: 10px;" id="product_name" disabled>
                    Quantity: 
                    <select class="form-select" name="quantity" id="quantity" style="border-radius: 10px;">

                    </select>
                    <span>Address:</span>
                    <input type="text" class="form-control" style="border-radius: 10px;" id="address" disabled>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for buy -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h1 class="modal-title fs-5 text-white" id="orderModalLabel">Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('storeOrder') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="inventory_id" id="inventory_id" value="">
                    <span>Product Name:</span>
                    <input type="text" class="form-control" style="border-radius: 10px;" id="product_name" disabled>
                    <span>Quantity:</span>
                    <select class="form-select" name="quantity" id="quantity" style="border-radius: 10px;">

                    </select>
                    <span>Address:</span>
                    <input type="text" class="form-control" style="border-radius: 10px;" id="address" disabled>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>


@section('script')
    <script>
        $(document).ready(function () {
            let data_inventory = @json($data_inventory).data;
            let user_data = @json($user_data);
            $('.btn-group #addCartBtn').on('click', function (e) { 
                e.preventDefault();
                $('#addCartModal #quantity').empty();
                let id = $(this).data('id');
                let quantity = $(this).data('quantity');
                let num = 0
                data_inventory.forEach(data => {
                    if (data.id == id) {
                        $('#addCartModal #product_name').val(data.product_name);
                        $('#addCartModal #address').val(user_data.address);
                    }
                });
                $('#addCartModal').modal('show');
                $('#addCartModal #id').val(id);
                while (num < quantity) {
                    num++;
                    $('#addCartModal #quantity').append(`<option value="${num}">${num}</option>`);
                }
            });
            $('.btn-group #addOrderBtn').on('click', function(e) {
                e.preventDefault();
                $('#orderModal #quantity').empty();
                let id = $(this).data('id');
                let quantity = $(this).data('quantity');
                let num = 0
                data_inventory.forEach(data => {
                    if (data.id == id) {
                        $('#orderModal #inventory_id').val(data.id);
                        $('#orderModal #product_name').val(data.product_name);
                        $('#orderModal #address').val(user_data.address);
                    }
                });
                while (num < quantity) {
                    num++;
                    $('#orderModal #quantity').append(`<option value="${num}">${num}</option>`);
                }
                $('#orderModal').modal('show');
            })
        });
        
    </script>
@endsection