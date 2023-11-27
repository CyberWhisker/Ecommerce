<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export PDF</title>
    {{-- BootStrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .row {
            margin-bottom: 10px;
        }
        span {
            font-weight: bold;
            font-size: 10px;
        }
        h4 {
            font-size: 15px;
        }

        .card {
            margin-bottom: 10px;
        }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #dee2e6; /* Bootstrap's table-bordered border color */
        }

        .custom-table th,
        .custom-table td {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid #dee2e6; /* Bootstrap's table-bordered border color */
        }

        .custom-table thead th {
            background-color: #f8f9fa; /* Bootstrap's table-striped background color */
        }

        .custom-table tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05); /* Bootstrap's table-striped background color */
        }

        p {
            font-size: 10px;
            margin-bottom: 0;
            line-height: 17px;
            font-weight: bold;
            color: green;
        }

    </style>    
</head>
<body>
    <div class="card" style="margin: 10px">
        <div class="card-header d-flex">
            <h3>Print Report</h3>
            <button class="btn btn-outline-success" style="margin-left: 10px" id="generate-pdf">Export PDF</button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" style="max-height: 60px;">
                                <div class="col">
                                    <img src="{{ asset('images/logo.png')}}" alt="Logo" style="height: 70px; border-radius:100%;">
                                </div>
                                <div class="col" style="flex: 40%">
                                    <p>Generated Report:</p>
                                    <p>Name: {{$user_data->first_name}} {{$user_data->middle_name}} {{$user_data->last_name}}</p>
                                    <p>Contact: {{$user_data->phone_number}}</p>
                                    <p>Email: {{$user_data->email}}</p>
                                </div>
                                <div class="col">
                                    <p style="color:red; text-align:right">Generated Report: {{$currentDate->format('M-d-Y H:i:s')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <span>Total Stock:</span>
                                </div>
                                <div class="card-body text-center">
                                    <h4>{{$qauntity_inventory}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <span>Total Item Sold:</span>
                                </div>
                                <div class="card-body text-center">
                                    <h4>{{$item_sold}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <span>Total Sales:</span>
                                </div>
                                <div class="card-body text-center">
                                    <h4>{{$total_sale}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col" style="width: 50%">
                    <div class="card">
                        <div class="card-header">
                            <h4>Weekly: Bar Chart</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col" style="width: 50%">
                    <div class="card">
                        <div class="card-header">
                            <h4>Monthly: Pie Chart</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daily: Line Chart</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="lineChart" style="max-height: 350px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h4>Table Orders:</h4>
                        </div>
                        <div class="card-body">
                            <table class="custom-table" id="table">
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
                                            <td>{{ $data->quantity }} {{ optional($data->inventory->unit)->unit }}</td>
                                            <td>
                                                <span>
                                                    ₱ {{ number_format($data->price, 2)}}
                                                </span>
                                            </td>
                                            <td class="{{$data->order_status == 'Pending' ? 'bg-warning' : ($data->order_status == 'Confirmed' ? 'bg-success' : 'bg-danger')}}">
                                                {{$data->order_status}}
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


@include('plugin.chart-plug-pdf')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    let daily_horizontal = @json($daily_horizontal);
    let daily_vertical = @json($daily_vertical);
    let weekly_horizontal = @json($weekly_horizontal);
    let weekly_vertical = @json($weekly_vertical);
    let monthly_horizontal = @json($monthly_horizontal);
    let monthly_vertical = @json($monthly_vertical);
</script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="{{ asset('exportPDF.js')}}"></script>