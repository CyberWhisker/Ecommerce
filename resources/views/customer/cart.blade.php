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
                                    <div class="col" style="border-left: 2px solid rgb(143, 139, 139)" id="btn-group">
                                        <button class="btn btn-success" style="margin-bottom: 10px; width:100%">Buy</button>
                                        <button class="btn btn-danger" style="width: 100%;" id="deleteBtn" data-id="{{$data->id}}">Remove</button>
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

<!-- Modal for Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h1 class="modal-title fs-5 text-white" id="deleteModalLabel">Warning!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('deleteCart') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    This product will be removed!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Remove</button>
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
            $('#btn-group #deleteBtn').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#deleteModal').modal('show');
                $('#deleteModal #id').val(id);
            })
        });
        
    </script>
@endsection