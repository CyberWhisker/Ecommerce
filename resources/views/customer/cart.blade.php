@extends('layouts.apprintice')
<style>
    .content #items {
        max-width: 200px;
        min-width: 200px;
        max-height: 200px;
        min-height: 200px;
        margin-left: 20px; 
        margin-bottom: 20px; 
    }
    .container .card {
        border-radius: 10px;
    }
</style>
@section('title')
Kadiwa/Cart
@endsection
@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Cart') }}
            </h2>
        </x-slot>
        
        <div class="container" style="padding: 20px;">
            @include('customer/alert')
            @forelse ($data_cart as $data)
                <div class="row" style="margin-bottom: 10px">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <span>{{$data->created_at->format('M-d-Y')}}</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col" style="flex: 5%;">
                                        @if ($data->inventory->image != null)
                                            <img src="{{ asset('storage/'.$data->inventory->image)}}" alt="Image" style="width: 100%; height: 100%;">
                                        @else 
                                            <img src="{{ asset('images/no-image.png')}}" alt="No Image" style="height: 100px; width:100px;">
                                        @endif
                                    </div>
                                    <div class="col" style="flex: 10%; border-left: 2px solid rgb(143, 139, 139)">
                                        <p>{{$data->inventory->product_name}}</p>
                                        <p>Quantity: {{$data->quantity}}</p>
                                        <p>Address: {{$data->user->address}}</p>
                                        <p>Contact: {{$data->user->phone_number}}</p>
                                    </div>
                                    <div class="col text-center" style="flex: 30%;">
                                        @if ($data->inventory->quantity <= 0)
                                            <span class="text-danger" style="font-weight:bold; font-size: 40px;">Out of Stock</span>
                                        @endif
                                    </div>
                                    <div class="col" style="flex: 10%;">
                                        <span class="text-danger" style="float: right; font-weight:bold; font-size: 40px">₱ {{$data->quantity * $data->inventory->price}}</span>
                                    </div>
                                    <div class="col" style="border-left: 2px solid rgb(143, 139, 139)" id="btn-group">
                                        <button class="btn {{$data->inventory->quantity <= 0 ? 'btn-outline-secondary' : 'btn-success'}}" style="margin-bottom: 10px; width:100%" id="orderBtn" data-id="{{$data->id}}"  {{$data->inventory->quantity <= 0 ? 'disabled' : ''}}>Buy</button>
                                        <button class="btn btn-danger" style="width: 100%;" id="deleteBtn" data-id="{{$data->id}}">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            @empty
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">
                            <span>Category</span>
                        </div>
                        <div class="card-body text-center">
                            <span class="text-danger">Cart is empty</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </x-app-layout>

    <!-- Modal for Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 class="modal-title fs-5 text-white" id="deleteModalLabel">Warning!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('deleteCart') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" value="">
                        This product will be removed!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Remove</button>
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
                        <input type="hidden" name="cart_id" id="cart_id" value="">
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <input type="hidden" name="inventory_id" id="inventory_id" value="">
                        <input type="hidden" name="quantity" value="">
                        <span>Name:</span>
                        <input type="text" class="form-control" style="border-radius: 10px;" id="product_name" disabled>
                        <span>Quantity:</span>
                        <input type="text" class="form-control" style="border-radius: 10px;" id="quantity" disabled>
                        <span>Address:</span>
                        <input type="text" class="form-control" style="border-radius: 10px;" id="address" disabled>
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
            let data_cart = @json($data_cart);
            $('#btn-group #deleteBtn').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#deleteModal').modal('show');
                $('#deleteModal #id').val(id);
            });
            $('#btn-group #orderBtn').click(function (e) { 
                e.preventDefault();
                let id = $(this).data('id');
                data_cart.forEach(data => {
                    if (data.id == id) {
                        $('#orderModal #cart_id').val(data.id);
                        $('#orderModal #user_id').val(data.user.id);
                        $('#orderModal #inventory_id').val(data.inventory.id);
                        $('#orderModal [name="quantity"]').val(data.quantity);
                        $('#orderModal #product_name').val(data.inventory.product_name);
                        $('#orderModal #quantity').val(data.quantity);
                        $('#orderModal #address').val(data.user.address);
                    }
                });
                $('#orderModal').modal('show');
            });
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
        
    </script>
@endsection