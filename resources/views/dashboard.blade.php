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
        overflow: hidden;
    }

    #visa:hover {
        border: 1px solid rgb(126, 184, 126)
    }

    .card-link:hover {
        display: block;
        text-decoration: none; /* Optional: Remove default underline */
        color: black;
    }

</style>
@section('title')
Kadiwa
@endsection
@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>
        
        <div class="container" style="padding: 20px;">
            @include('customer/alert')
            <div class="row">
                <div class="col mb-3">
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
                        {{-- <div class="row">
                            <div class="col">
                                <a href="/" class="card-link">
                                    <div class="card">
                                        <div class="card-body bg-green-400">
                                            <div class="row">
                                                <div class="col d-flex align-items-center">
                                                    <span class="fs-2 fw-bold">All Products</span>
                                                </div>
                                                <div class="col">
                                                    <img class="float-right opacity-30" src="{{asset('images/AllProductIcon.png')}}" alt="All" style="height: 150px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col d-flex align-items-center">
                                                <span class="fs-2 fw-bold">Local Products</span>
                                            </div>
                                            <div class="col">
                                                <img class="float-right opacity-30" src="{{asset('images/LocalProductIcon.png')}}" alt="All" style="height: 150px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            @forelse ($data_inventory as $data)
                                @php
                                    $rating_collection = collect();
                                    foreach ($data->order as $data_rating) {
                                        $rating_collection->push($data_rating->rating);
                                    }
                                    $rating = $rating_collection->avg();
                                @endphp
                                {{-- Small Screen --}}
                                <div class="col" id="items" style="margin-bottom: 130px;">
                                    <div class="card">
                                        <div class="card-header">
                                            @if ($data->image != null)
                                                <img src="{{ asset('storage/'.$data->image)}}" alt="Image" style="width: 100%; height: 176px">
                                            @else 
                                                <img src="{{ asset('images/no-image.png')}}" alt="No Image">
                                            @endif
                                            <div class="d-flex">
                                                <span>
                                                    Rating:
                                                    @php
                                                        $star = '';
                                                        for ($i=0; $i < floor($rating); $i++) { 
                                                            $star .= '<i class="bi bi-star-fill" style="color:gold;margin-left:2px"></i>';
                                                        }
                                                        echo $star;
                                                    @endphp
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body p-2">
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
                                                    <span class="{{$data->quantity <= 0 ? 'text-danger' : ''}}"> {{$data->quantity <= 0 ? 'Out of stock' : $data->quantity}} 
                                                    @if ($data->quantity > 0)
                                                         {{optional($data->unit)->unit}}
                                                    @endif
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                @if (Auth::user())
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn {{$data->quantity <= 0 ? 'btn-outline-secondary d-none' : 'btn-outline-success'}}" id="addOrderBtn" data-id="{{$data->id}}" data-quantity="{{$data->quantity}}" {{$data->quantity <= 0 ? 'Disabled' : ''}}>Buy</button>
                                                        <button type="button" class="btn btn-warning {{$data->quantity <= 0 ? 'd-none' : ''}}" id="addCartBtn" data-id="{{$data->id}}" data-quantity="{{$data->quantity}}">Cart</button>
                                                    </div>
                                                @else 
                                                    <form action="{{ route('dashboardAlert')}}" method="POST" id="alert">
                                                        @csrf
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <button class="btn btn-outline-success" type="submit">Buy</button>
                                                            <button class="btn btn-outline-warning" type="submit">Cart</button>
                                                        </div>
                                                    </form>
                                                @endif 
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
                <form action="{{ route('pay') }}" method="POST" id="orderForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="inventory_id" id="inventory_id" value="">
                        <span>Product Name:</span>
                        <input type="text" class="form-control" style="border-radius: 10px;" id="product_name" disabled>
                        <span>Quantity:</span>
                        <select class="form-select" name="quantity" id="quantity" style="border-radius: 10px;">

                        </select>
                        <span>Address:</span>
                        <input type="text" class="form-control" style="border-radius: 10px; margin-bottom: 10px" id="address" disabled>
                        <span style="margin-bottom: 10px">Select Payment:</span>
                        <div class="row container">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <span>Cash on Delivery</span>
                                    </div>
                                    <div class="card-body">
                                        <button class="btn btn-outline-warning" style="width: 100%" id="cod"><i class="bi bi-cash-coin"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <span>Credit Card</span>
                                    </div>
                                    <div class="card-body">
                                        <button class="btn btn-outline-success" style="width: 100%" id="card"><i class="bi bi-credit-card"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Proceed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection




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
            });
            $('#orderModal #cod').on('click', function(e) {
                e.preventDefault();
                let newRoute = "{{ route('cashOnDelivery') }}";
                $('#orderModal #cod').addClass('active');
                $('#orderModal #card').removeClass('active');
                $('#orderModal #orderForm').attr('action',newRoute);
            })
            $('#orderModal #card').on('click', function(e) {
                e.preventDefault();
                let newRoute = "{{ route('pay') }}";
                $('#orderModal #card').addClass('active');
                $('#orderModal #cod').removeClass('active');
                $('#orderModal #orderForm').attr('action',newRoute);
            })
        });
        
    </script>
@endsection