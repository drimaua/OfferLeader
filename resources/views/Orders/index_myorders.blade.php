@extends('layouts.app')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">My orders list <a href="/my_orders/create" class="btn btn-info" style="float: right;">Create new order</a></div>
                    <div class="card-body">
                        @if(count($orders))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead><tr><th>№</th><th>Card</th><th>Order sum</th><th>Status</th></tr></thead>
                                    <tbody>
                                    @foreach($orders as $id=>$order)
                                        <tr>
                                            <td>{{$order['id']}}</td>
                                            <td>{{base64_decode($order['card']->card_number)}}</td>
                                            <td>{{$order['write_off']?'-':'+'}} {{$order['order_sum']}}</td>
                                            <td>
                                                @if($order['examined'])
                                                    {{$order['approved']?'Approved':'Rejected'}}
                                                @else
                                                    Waiting for approval
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('layouts/errors')
                        @else
                            No orders available
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection