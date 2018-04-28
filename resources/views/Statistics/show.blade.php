@extends('layouts.app')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Total statistics for {{$users->name}} (all currencies together)</div>
                    <div class="card-body">
                        @if(count($orders))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead><tr><th>Date</th><th>Replenished</th><td>Write off</td></thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order['date_approved']}}</td>
                                            <td>{{$order['day_replenish']}}</td>
                                            <td>{{$order['day_write_off']}}</td>
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