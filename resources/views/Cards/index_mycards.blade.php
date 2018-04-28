@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">My cards list</div>
                <div class="card-body">
                    @if(count($cards))
                        <div class="table-responsive">
                            <table class="table">
                                <thead><tr>
                                    <th>Code</th><th>cw2</th><th>Date To</th><th>Balance</th><th>Currency</th><th>Manage</th>
                                </tr></thead>
                                <tbody>
                                @foreach($cards as $id=>$card)
                                    <tr>
                                        <td>{{base64_decode($card['card_number'])}}</td>
                                        <td>{{base64_decode($card['cw2'])}}</td>
                                        <td>{{\Carbon\Carbon::parse($card['issue_to'])->format('Y/m')}}</td>
                                        <td>{{$card['balance']}}</td>
                                        <td>{{$card['currency']->name}}</td>
                                        <td>
                                            @if($card['balance']==0)
                                            <form method="POST" action="/my_cards/{{$card['id']}}/detach">
                                                {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger">Detach</button>
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
                        No Cards Available
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection