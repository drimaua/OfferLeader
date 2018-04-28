@extends('layouts.app')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">My statistics of replenish accounts (all currencies together)</div>
                    <div class="card-body">
                        @if(count($orders))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead><tr><th>Date</th><th>Sum</th></thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order['date_approved']}}</td>
                                            <td>{{$order['day_sum']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('layouts/errors')
                        @else
                            No statistics available
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection