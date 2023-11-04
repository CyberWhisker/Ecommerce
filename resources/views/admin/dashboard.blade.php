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
                <h3 class="text-white">Total Sales</h3>
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
                        <h3>Sale Chart:</h3>
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="col">
                        <h3>Market Price: (Survey Location)</h3>
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <td>Product</td>
                                    <td>Price</td>
                                    <td>Unit</td>
                                    <td>Address</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_survey as $data)
                                    <tr>
                                        <td>{{$data->product_name}}</td>
                                        <td>{{$data->price}}</td>
                                        <td>{{$data->unit->unit}}</td>
                                        <td>{{$data->survey_location}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2"><span class="text-danger">No record found!</span></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{$data_survey->links()}}
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
</script>