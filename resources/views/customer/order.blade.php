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
Kadiwa/Order
@endsection

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
                            <div class="card-header  {{$data->order_status == 'Cancelled' ? 'bg-danger' : (optional($data->orderStatus)->recieve_status == '2' ? 'bg-success' : 'bg-warning')}}">
                                <span>{{$data->created_at->format('M-d-Y')}}</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        @if ($data->inventory->image != null)
                                            <img src="{{ asset('storage/'.$data->inventory->image)}}" alt="Image" style="width: 100%; height: 120px;">
                                        @else 
                                            <img src="{{ asset('images/no-image.png')}}" alt="No Image" style="height: 100px; width:100px;">
                                        @endif
                                    </div>
                                    <div class="col" style="border-left: 2px solid rgb(143, 139, 139)">
                                        <p>{{$data->inventory->product_name}}</p>
                                        <p>Quantity: {{$data->quantity}}</p>
                                        <p>Address: {{$data->user->address}}</p>
                                        <p>Contact: {{$data->user->phone_number}}</p>
                                        <div class="d-flex">
                                            <label for="rating">Rating:</label>
                                            @php
                                                $rating = '';
                                                for ($i = 0; $i < $data->rating; $i++) {
                                                    $rating .= '<i class="bi bi-star-fill" style="color:gold;margin-left:6px"></i>';
                                                }
                                            @endphp
                                            {!! $rating !!}
                                        </div>
                                    </div>
                                    <div class="col">
                                        @if ($data->orderStatus != null)
                                            
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <span class="{{$data->orderStatus->process_status == '2' ? 'text-success': ($data->orderStatus->process_status == '1' ? 'text-warning': '')}}">Proccessing</span>
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
                                                            <span class="{{$data->orderStatus->delivery_status == '2' ? 'text-success': ($data->orderStatus->delivery_status == '1' ? 'text-warning': '')}}">Delivering</span>
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
                                                            <span class="{{$data->orderStatus->recieve_status == '2' ? 'text-success': ($data->orderStatus->recieve_status == '1' ? 'text-warning': '')}}">Recieved</span>
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
                                    <div class="col" style="max-height: 100px; overflow-y: auto; ">
                                        <span>Review</span>
                                        {{$data->review}}
                                    </div>
                                    <div class="col">
                                        <div style="text-align:right;">
                                            <input type="text" class="{{$data->order_status == 'Pending' ? 'bg-warning' : ($data->order_status == 'Confirmed' ? 'bg-success' : 'bg-danger')}}" value="{{$data->order_status}}" style="width: 110px; float: right;" disabled>
                                            <br>
                                            <br>
                                            <span class="text-danger" style="float: right; font-weight:bold; font-size: 40px">₱ {{$data->price}}</span>
                                        </div>
                                    </div>
                                    <div class="col" style="border-left: 2px solid rgb(143, 139, 139)" id="btn-group">
                                        <button class="btn btn-danger" style="width: 100%;" id="deleteBtn" data-id="{{$data->id}}" {{$data->order_status == 'Confirmed' ? 'disabled': ''}}>Cancel Order</button>
                                        <button class="btn btn-outline-warning" style="width: 100%; margin-top: 10px" id="reviewBtn" data-id="{{$data->id}}" {{optional($data->orderStatus)->recieve_status != '2' ? 'disabled': ''}}>Review</button>
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
<!-- Modal for Review -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h1 class="modal-title fs-5 text-white" id="reviewModalLabel">Review</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reviewOrder') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="mb-3">
                        <label for="sampleText" class="form-label">Review:</label>
                        <textarea class="form-control" id="review" rows="3" name="review" id="review"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <label for="rating">Rate this item:</label>
                            <div id="star_container">
                                <i class="bi bi-star-fill" style="color:gold;margin-left:6px"></i>
                                <i class="bi bi-star-fill" style="color:gold;margin-left:6px"></i>
                                <i class="bi bi-star-fill" style="color:gold;margin-left:6px"></i>
                                <i class="bi bi-star-fill" style="color:gold;margin-left:6px"></i>
                                <i class="bi bi-star-fill" style="color:gold;margin-left:6px"></i>
                            </div>
                        </div>
                        <select name="rating" id="rating" class="form-select" style="border-radius: 10px;">
                            <option value="5">Great</option>
                            <option value="4">Better</option>
                            <option value="3">Good</option>
                            <option value="2">Bad</option>
                            <option value="1">Worst</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


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
            $('#btn-group #reviewBtn').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#star_container').empty();
                data_order.forEach(data => {
                    if (data.id == id) {
                        if (data.review != null) {
                            $('#reviewModal #review').val(data.review);
                            $('#reviewModal #rating').empty();
                            $('#reviewModal #rating').append(`
                                <option value="5" ${data.rating == 5 ? 'selected' : ''}>Great</option>
                                <option value="4" ${data.rating == 4 ? 'selected' : ''}>Better</option>
                                <option value="3" ${data.rating == 3 ? 'selected' : ''}>Good</option>
                                <option value="2" ${data.rating == 2 ? 'selected' : ''}>Bad</option>
                                <option value="1" ${data.rating == 1 ? 'selected' : ''}>Worst</option>
                            `);
                            let star = `<i class="bi bi-star-fill" style="color:gold;margin-left:6px"></i>`.repeat(data.rating);
                            $('#star_container').append(star);
                        }
                    }
                });
                $('#reviewModal').modal('show');
                $('#reviewModal #id').val(id);
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

        $('#reviewModal #rating').on('change',function (e) {
            e.preventDefault();
            $('#star_container').empty();
            let rating_value = $(this).val();
            let star = `<i class="bi bi-star-fill" style="color:gold;margin-left:6px"></i>`.repeat(rating_value);
            $('#star_container').append(star);
        })
        
    </script>
@endsection