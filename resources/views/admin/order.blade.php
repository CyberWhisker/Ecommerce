@extends('layouts.master')

@section('title')
Order
@endsection

@section('navigation')

@endsection


@section('content')
    <form id="searchForm" action="{{ route('searchOrder') }}" method="POST">
        @csrf
        <input type="hidden" value="" id="searchInput" name="searchInput">
    </form>
    <div class="card" style="border-radius: 10px;">
        <div class="card-header" style="background-color: #8acbff">
            <div class="row">
                <div class="col d-flex align-items-center">
                    Order List:
                </div>
            </div>
        </div>
        <div class="card-body" id="dataTable">
            <table class="table table-striped table-bordered" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th style="width: 5%;">
                            <i class="bi bi-gear"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_order as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->user->first_name }} {{ $data->user->last_name }}</td>
                            <td>{{ $data->user->address }}</td>
                            <td>{{ $data->user->phone_number }}</td>
                            <td>{{ $data->inventory->product_name }}</td>
                            <td>{{ $data->quantity }} {{ $data->inventory->unit->unit }}</td>
                            <td>
                                <span>
                                    ₱ {{ number_format($data->price, 2)}}
                                </span>
                            </td>
                                <td class="{{$data->order_status == 'Pending' ? 'bg-warning' : ($data->order_status == 'Confirmed' ? 'bg-success' : 'bg-danger')}}">{{$data->order_status}}</td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="updateOrderStatus" method="post">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{$data->id}}">
                                                <input type="hidden" name="inventory_id" value="{{$data->inventory_id}}">
                                                <input type="hidden" name="quantity" value="{{$data->quantity}}">
                                                <input type="hidden" name="order_status" value="Confirmed">
                                                <a type="submit" class="dropdown-item {{$data->order_status == 'Confirmed' ? 'disabled': ''}}" href="#" id="confirmBtn" data-id="{{$data->id}}">Confirm</a>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="updateOrderStatus" method="post">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{$data->id}}">
                                                <input type="hidden" name="inventory_id" value="{{$data->inventory_id}}">
                                                <input type="hidden" name="quantity" value="{{$data->quantity}}">
                                                <input type="hidden" name="order_status" value="Cancelled">
                                                <a type="submit" class="dropdown-item {{$data->order_status == 'Cancelled' ? 'disabled' : ''}}" href="#" id="cancelBtn" data-id="{{$data->id}}">Cancel</a>
                                            </form>
                                        </li>
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
    
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.dropdown-menu #confirmBtn').on('click', function(e) {
                e.preventDefault();
                $(this).closest('form').submit();
            });
            $('.dropdown-menu #cancelBtn').on('click', function(e) {
                e.preventDefault();
                $(this).closest('form').submit();
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
    </script>
@endsection
