@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Card information</div>
                    <div class="card-body">
                            <form method="POST" action="/my_orders">
                                {{csrf_field()}}
                                <div class="input-group">
                                    <span class="input-group-addon" style="width:150px;">Card</span>
                                    <select name="card" class="form-control">
                                        @foreach($cards as $card)
                                            <option value="{{$card->id}}">
                                                {{base64_decode($card->card_number)}} {{$card['currency']['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width:150px;">Operation type</span>
                                    <select name="write_off" class="form-control" value="0">
                                        <option value="0" selected="selected">Replenish</option>
                                        <option value="1">Write off</option>
                                    </select>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="order_sum">Order sum</label>
                                    <input type="number" class="form-control" id="order_sum" name="order_sum" value="0" step="0.01">
                                </div>
                                <br>

                                <button type="submit" class="btn btn-success">Create order</button>
                            </form>
                            @if ($errors->any())
                                <br>
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection