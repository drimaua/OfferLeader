@extends('layouts.app')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Orders list</div>
                    <div class="card-body">
                        @if(count($orders))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead><tr><th>№</th><th>Card</th><th>User</th><th>Order sum</th><th>Status</th><th>Manage</th></tr></thead>
                                    <tbody>
                                    @foreach($orders as $id=>$order)
                                        <tr>
                                            <td>{{$order['id']}}</td>
                                            <td>
                                                {{base64_decode($order['card']->card_number)}}
                                                ({{$order['card']->balance}})
                                            </td>
                                            <td>{{$order['user']->name}}</td>
                                            <td>{{$order['write_off']?'-':'+'}} {{$order['order_sum']}}</td>
                                            <td>
                                                @if($order['examined'])
                                                    {{$order['approved']?'Approved':'Rejected'}}
                                                @else
                                                    Waiting for approval
                                                @endif
                                            </td>
                                            <td>
                                                @if(!$order['examined'])
                                                    <form method="POST" action="/orders/{{$order['id']}}/approve">
                                                        {{csrf_field()}}
                                                        <button type="submit" class="btn btn-success">Approve</button>
                                                    </form>
                                                    <br>
                                                    <form method="POST" action="/orders/{{$order['id']}}/reject">
                                                        {{csrf_field()}}
                                                        <button type="submit" class="btn btn-danger">Reject</button>
                                                    </form>
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