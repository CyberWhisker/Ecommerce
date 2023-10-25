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
                {{ __('Cart') }}
            </h2>
        </x-slot>
        
        <div class="container" style="padding: 20px;">
            @forelse ($data_cart as $data)
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <span>{{$data->created_at->format('M-d-Y')}}</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        @if ($data->image != null)
                                        
                                        @else 
                                            <img src="{{ asset('images/no-image.png')}}" alt="No Image" style="height: 100px; width:100px;">
                                        @endif
                                    </div>
                                    <div class="col" style="flex: 60%; border-left: 2px solid rgb(143, 139, 139)">
                                        <p>{{$data->inventory->product_name}}</p>
                                        <p>Quantity: {{$data->quantity}}</p>
                                        <p>Address: {{$data->user->address}}</p>
                                        <p>Address: {{$data->user->phone_number}}</p>
                                    </div>
                                    <div class="col" style="border-left: 2px solid rgb(143, 139, 139)">
                                        <button class="btn btn-success" style="margin-bottom: 10px; width:100%">Buy</button>
                                        <button class="btn btn-danger" style="width: 100%;">Delete</button>
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
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.btn-group #addCartBtn').on('click', function (e) { 
                e.preventDefault();
                $('#addCartModal #quantity').empty();
                let id = $(this).data('id');
                let quantity = $(this).data('quantity');
                let num = 0
                $('#addCartModal').modal('show');
                $('#addCartModal #id').val(id);
                while (num < quantity) {
                    num++;
                    $('#addCartModal #quantity').append(`<option value="${num}">${num}</option>`);
                }
            });
        });
        
    </script>
@endsection