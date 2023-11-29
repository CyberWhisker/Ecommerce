@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('navigation')
    
@endsection
<style>
    .card {
        position: relative;
        display: inline-block;
        margin: 20px;
        border-radius: 20px !important;
    }
</style>

@section('content')
    <div class="row">
        <div class="card col bg-primary">
            <div class="card-header">
                <h3 class="text-white">Total Users</h3>
            </div>
            <div class="card-body text-center">
                <h1 class="text-white">{{$user_count}}</h1>
            </div>
        </div>
        <div class="card col bg-warning">
            <div class="card-header">
                <h3 class="text-white">Orders</h3>
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col" style="border-right: 2px solid white">
                        <span>Total</span><br>
                        <span>{{$data_order->count()}}</span>
                    </div>
                    <div class="col" style="border-right: 2px solid white">
                        <span>Confirmed</span><br>
                        <span>{{$data_order->where('order_status', 'Confirmed')->count()}}</span>
                    </div>

                    <div class="col">
                        <span>Pending</span><br>
                        <span>{{$data_order->where('order_status', 'Pending')->count()}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col bg-success">
            <div class="card-header">
                <h3 class="text-white">Total Sales:</h3>
            </div>
            <div class="card-body text-center">
                <h1 class="text-white">₱ {{number_format($data_order->where('order_status', 'Confirmed')->sum('price'), 2)}}</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="border-right: 2px solid black; flex:30%">
                        <div class="row">
                            <div class="col d-flex">
                                <h3 style="margin-top: 5px">Sale Chart:</h3>
                                <form action="{{ route('exportPdf')}}">
                                    @csrf
                                    <button class="btn btn-outline-success" style="margin-left: 10px;" type="submit">PDF</button>
                                </form>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <form action="{{ route('chartDate') }}" method="POST">
                                            @csrf
                                            <select class="form-select" name="chartDate" id="chartDate" style="float: right;" onchange="submit()">
                                                <option value="0" disabled>-Select Date-</option>
                                                <option value="1" {{ $chartDate == 1 ? 'selected' : ''}}>Daily</option>
                                                <option value="2" {{ $chartDate == 2 ? 'selected' : ''}}>Weekly</option>
                                                <option value="3" {{ $chartDate == 3 ? 'selected' : ''}}>Monthly</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <form action="{{ route('chartType')}}" method="POST">
                                            @csrf
                                            <select class="form-select" name="chartType" id="chartType" style="float: right;" onchange="submit()">
                                                <option value="0" disabled>-Select Chart-</option>
                                                <option value="1" {{ $chartType == 1 ? 'selected' : ''}}>Bar Chart</option>
                                                <option value="2" {{ $chartType == 2 ? 'selected' : ''}}>Pie Chart</option>
                                                <option value="3" {{ $chartType == 3 ? 'selected' : ''}}>Line Chart</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <canvas id="barChart" class="{{$chartType == 1 ? '' : 'd-none'}}"></canvas>
                        <canvas id="pieChart" class="{{$chartType == 2 ? '' : 'd-none'}}"></canvas>
                        <canvas id="lineChart" class="{{$chartType == 3 ? '' : 'd-none'}}"></canvas>
                    </div>
                    <div class="col">
                        <h3>Market Suggested Price:</h3>
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <td>Product</td>
                                    <td>Price</td>
                                    <td>Unit</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_survey as $data)
                                    <tr>
                                        <td>{{$data->product_name}}</td>
                                        <td>₱ {{number_format($data->price, 2)}}</td>
                                        <td>{{$data->unit->unit}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center"><span class="text-danger">No record found!</span></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{$data_survey->links()}}
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <h3 style="margin-top: 25px">Inventory Chart:</h3>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <form action="{{ route('inventoryDate') }}" method="POST" class="d-flex" id="dateForm">
                                        @csrf
                                        <div class="col">
                                            <span>Start Date:</span>
                                            <div class="text-center">
                                                <input type="text" class="form-control datepicker" name="start_date" autocomplete="off" placeholder="2023-11-31" value="{{session('startDate') != null ? session('startDate') : ''}}">
                                                <span id="error_start"></span>
                                            </div>
                                        </div>
                                        <div class="col" style="margin-left: 5px;">
                                            <span>End Date:</span>
                                            <div class="text-center">
                                                <input type="text" class="form-control datepicker" name="end_date" autocomplete="off" placeholder="2023-12-31" value="{{session('endDate') != null ? session('endDate') : ''}}">
                                                <span id="error_end"></span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <canvas id="barChartInventory"></canvas>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>

    @include('plugin.chart-plug')

@endsection

<script>
    let array_horizontal = @json($array_horizontal);
    let array_vertical = @json($array_vertical);
    let array_horizontal2 = @json($array_horizontal2);
    let array_vertical2 = @json($array_vertical2);
</script>

@section('script')
    <script>
        $(document).ready(function () {
            $('[name="end_date"]').on('change', function(e) {
                e.preventDefault();
                let start_date = $('[name="start_date"]').val();
                if (start_date == '') {
                    $('#error_start').append(`<p style="font-weight:bold;color:red;">Required<p>`)
                } else {
                    $('#dateForm').submit();
                }
            })    
            $('[name="start_date"]').on('change', function(e) {
                e.preventDefault();
                let end_date = $('[name="end_date"]').val();
                if (end_date == '') {
                    $('#error_end').append(`<p style="font-weight:bold;color:red;">Required<p>`)
                } else {
                    $('#dateForm').submit();
                }
            })  
        });

    </script>
@endsection

