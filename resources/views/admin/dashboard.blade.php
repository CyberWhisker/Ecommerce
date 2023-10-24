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
                <h1>{{$user_count}}</h1>
            </div>
        </div>
        <div class="card col bg-warning">
            <div class="card-header">
                <h3 class="text-white">Orders</h3>
            </div>
            <div class="card-body text-center">
            </div>
        </div>
        <div class="card col bg-success">
            <div class="card-header">
                <h3 class="text-white">Revenue</h3>
            </div>
            <div class="card-body text-center">
                <h1>300</h1>
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
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_inventory as $data)
                                    <tr>
                                        <td>{{$data->product_name}}</td>
                                        <td>{{$data->unit}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2"><span class="text-danger">No record found!</span></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{$data_inventory->links()}}
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>
    <script>
        let array_horizontal = @json($array_horizontal);
        let array_vertical = @json($array_vertical);
    </script>
    <!-- plugins:js -->
    <script src="{{asset('admin/vendors/base/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="{{asset('admin/vendors/chart.js/Chart.min.js')}}"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{asset('admin/js/off-canvas.js')}}"></script>
    <script src="{{asset('admin/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('admin/js/template.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{asset('admin/js/chart.js')}}"></script>
    <!-- End custom js for this page-->
@endsection