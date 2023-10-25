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
                {{ __('Dashboard') }}
            </h2>
        </x-slot>
        
        <div class="container" style="padding: 20px;">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">
                            <span>Category</span>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                <a href=""><span>Popular</span></a>
                            </div>
                            <div class="row">
                                <a href=""><span>Latest</span></a>
                            </div>
                            <div class="row">
                                <a href=""><span>Top Sales</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col" style="flex: 70%;">
                    <div class="content">
                        <div class="row">
                            @forelse ($data_inventory as $data)
                                <div class="col" id="items">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px;">
                                            @if ($data->image != null)
                                            
                                            @else 
                                                <img src="{{ asset('images/no-image.png')}}" alt="No Image">
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col">
                                                    {{$data->product_name}}
                                                </div>
                                                <div class="col">
                                                    <span class="text-danger" style="float: right; font-weight:bold">₱ {{$data->price}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <span>Available: {{$data->quantity}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn btn-success">Buy</button>
                                                    <button type="button" class="btn btn-warning" id="addCartBtn" data-id="{{$data->id}}" data-quantity="{{$data->quantity}}">Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            @empty
                                <div class="card">
                                    <div class="card-body text-center">
                                        <span>Inventory is Empty!</span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endsection

<!-- Modal for Add Cart -->
<div class="modal fade" id="addCartModal" tabindex="-1" aria-labelledby="addCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h1 class="modal-title fs-5 text-white" id="addCartModalLabel">Add to Cart</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('storeCart') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="inventory_id" id="id" value="">
                    Quantity: 
                    <select class="form-select" name="quantity" id="quantity" style="border-radius: 10px;">

                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

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