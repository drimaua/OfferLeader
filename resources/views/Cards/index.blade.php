@extends('layouts.app')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Cards List <a href="/cards/create" class="btn btn-info" style="float: right;">Create new card</a></div>
                    <div class="card-body">
                        @if(count($cards))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead><tr>
                                        <th>Code</th><th>cw2</th><th>Date To</th><th>Balance</th><th>Currency</th><th>User</th><th>Manage</th>
                                    </tr></thead>
                                    <tbody>
                                    @foreach($cards as $id=>$card)
                                        <tr>
                                            <td><a href="/cards/{{$card['id']}}">{{base64_decode($card['card_number'])}}</a></td>
                                            <td>{{base64_decode($card['cw2'])}}</td>
                                            <td>{{\Carbon\Carbon::parse($card['issue_to'])->format('Y/m')}}</td>
                                            <td>{{$card['balance']}}</td>
                                            <td>{{$card['currency']->name}}</td>
                                            <td>
                                                @if($card['user'])
                                                    {{$card['user']['name']}}
                                                @else
                                                    User not set!
                                                @endif
                                            </td>
                                            <td>
                                                <form method="POST" action="/cards/{{$card['id']}}">
                                                    {{csrf_field()}}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger">Del</button>
                                                </form>

                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('layouts/errors')
                        @else
                            No Cards Available
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection