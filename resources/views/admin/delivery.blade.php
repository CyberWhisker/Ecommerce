@extends('layouts.master')

@section('title')
Delivery
@endsection

@section('navigation')

@endsection


@section('content')
    <form id="searchForm" action="{{ route('searchDelivery') }}" method="POST">
        @csrf
        <input type="hidden" value="" id="searchInput" name="searchInput">
    </form>
    <div class="card" style="border-radius: 10px;">
        <div class="card-header" style="background-color: #8acbff">
            <div class="row">
                <div class="col d-flex align-items-center">
                    Delivery List:
                </div>
            </div>
        </div>
        <div class="card-body" id="dataTable">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Product Name</th>
                        <th>Address</th>
                        <th>Process</th>
                        <th>Delivery</th>
                        <th>Recieved</th>
                        <th style="width: 5%;">
                            <i class="bi bi-gear"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_order_status as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td style="width: 15%">{{ $data->order->user->first_name }} {{ $data->order->user->last_name }}</td>
                            <td>{{ $data->order->inventory->product_name }}</td>
                            <td style="width: 30%">{{ $data->order->user->address }}</td>
                            <td>
                                @if ($data->process_status == '2')
                                    <input type="text" class="form-control bg-success" disabled value="Done">  
                                @else
                                    <input type="text" class="form-control bg-warning" disabled value="Processing"> 
                                @endif
                            </td>
                            <td>
                                @if ($data->delivery_status == '2')
                                    <input type="text" class="form-control bg-success" disabled value="Done">    
                                @elseif($data->process_status == '2')
                                    <input type="text" class="form-control bg-warning" disabled value="Delivering">    
                                @else
                                    <input type="text" class="form-control bg-secondary" disabled value="Ongoing"> 
                                @endif
                            </td>
                            <td>
                                @if ($data->recieve_status == '2')
                                    <input type="text" class="form-control bg-success" disabled value="Done">   
                                @else
                                    <input type="text" class="form-control bg-secondary" disabled value="Ongoing"> 
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="updateOrderDelivery" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$data->id}}">
                                                <a type="submit" class="dropdown-item {{$data->delivery_status == '2' ||$data->delivery_status == '1' ? 'disabled': ''}}" href="#" id="confirmBtn" data-id="{{$data->id}}">Deliver</a>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="udpateOrderRecieve" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$data->id}}">
                                                <a type="submit" class="dropdown-item {{$data->recieve_status == '2' || $data->delivery_status == 0 ? 'disabled' : ''}}" href="#" id="cancelBtn" data-id="{{$data->id}}">Recieve</a>
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
