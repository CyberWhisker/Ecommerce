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
@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Order') }}
            </h2>
        </x-slot>
        
        <div class="container" style="padding: 20px;">
            @forelse ($data_order as $data)
                <div class="row" style="margin-bottom: 10px">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <span>{{$data->created_at->format('M-d-Y')}}</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col" style="flex: 10%">
                                        @if ($data->inventory->image != null)
                                            <img src="{{ asset('storage/'.$data->inventory->image)}}" alt="Image" style="width: 100%; height: 120px;">
                                        @else 
                                            <img src="{{ asset('images/no-image.png')}}" alt="No Image" style="height: 100px; width:100px;">
                                        @endif
                                    </div>
                                    <div class="col" style="flex: 30%; border-left: 2px solid rgb(143, 139, 139)">
                                        <p>{{$data->inventory->product_name}}</p>
                                        <p>Quantity: {{$data->quantity}}</p>
                                        <p>Address: {{$data->user->address}}</p>
                                        <p>Contact: {{$data->user->phone_number}}</p>
                                    </div>
                                    <div class="col" style="flex: 10%">
                                        @if ($data->orderStatus != null)
                                            
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <span class="{{$data->orderStatus->process_status == '2' ? 'text-success': ''}}">Proccessing</span>
                                                        </td>
                                                        <td>
                                                            @if ($data->orderStatus->process_status == '1')
                                                                <div class="spinner-grow spinner-grow-sm" role="status">
                                                                </div>
                                                            @elseif($data->orderStatus->process_status == '2')
                                                                <i class="bi bi-check-lg {{$data->orderStatus->process_status == '2' ? 'text-success': ''}}"></i>
                                                            @else

                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="{{$data->orderStatus->delivery_status == '2' ? 'text-success': ''}}">Delivering</span>
                                                        </td>
                                                        <td>
                                                            @if ($data->orderStatus->delivery_status == '1')
                                                                <div class="spinner-grow spinner-grow-sm" role="status">
                                                                </div>
                                                            @elseif($data->orderStatus->delivery_status == '2')
                                                                <i class="bi bi-check-lg {{$data->orderStatus->delivery_status == '2' ? 'text-success': ''}}"></i>
                                                            @else
                                                            
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="{{$data->orderStatus->recieve_status == '2' ? 'text-success': ''}}">Recieved</span>
                                                        </td>
                                                        <td>
                                                            @if ($data->orderStatus->recieve_status == '1')
                                                                <div class="spinner-grow spinner-grow-sm" role="status">
                                                                </div>
                                                            @elseif($data->orderStatus->recieve_status == '2')
                                                                <i class="bi bi-check-lg {{$data->orderStatus->recieve_status == '2' ? 'text-success': ''}}"></i>
                                                            @else
                                                            
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                    <div class="col" style="flex: 30%;">
                                        <div style="text-align:right;">
                                            <input type="text" class="{{$data->order_status == 'Pending' ? 'bg-warning' : ($data->order_status == 'Confirmed' ? 'bg-success' : 'bg-danger')}}" value="{{$data->order_status}}" style="width: 30%; float: right;" disabled>
                                            <br>
                                            <br>
                                            <span class="text-danger" style="float: right; font-weight:bold; font-size: 40px">₱ {{$data->price}}</span>
                                        </div>
                                    </div>
                                    <div class="col" style="border-left: 2px solid rgb(143, 139, 139)" id="btn-group">
                                        <button class="btn btn-danger" style="width: 100%;" id="deleteBtn" data-id="{{$data->id}}" {{$data->order_status == 'Confirmed' ? 'disabled': ''}}>Cancel Order</button>
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
                            <span class="text-danger">Order is empty</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </x-app-layout>
@endsection

<!-- Modal for Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h1 class="modal-title fs-5 text-white" id="deleteModalLabel">Warning!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('deleteOrder') }}" method="POST">
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

@section('script')
    <script>
        $(document).ready(function () {
            let data_order = @json($data_order);
            $('#btn-group #deleteBtn').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#deleteModal').modal('show');
                $('#deleteModal #id').val(id);
            });
            $('#btn-group #orderBtn').click(function (e) { 
                e.preventDefault();
                let id = $(this).data('id');
                data_order.forEach(data => {
                    if (data.id == id) {
                        $('#orderModal #cart_id').val(data.id);
                        $('#orderModal #user_id').val(data.user.id);
                        $('#orderModal #inventory_id').val(data.inventory.id);
                        $('#orderModal [name="quantity"]').val(data.inventory.id);
                        $('#orderModal #product_name').val(data.inventory.product_name);
                        $('#orderModal #quantity').val(data.quantity);
                        $('#orderModal #address').val(data.user.address);
                    }
                });
                $('#orderModal').modal('show');
            });
        });
        
    </script>
@endsection