@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Card information</div>
                    <div class="card-body">
                        @if(count($cardInfo))
                            <form method="POST" action="/cards/{{$cardInfo[0]->id}}">
                                {{csrf_field()}}
                                {{ method_field('PATCH') }}
                                <div class="form-group">
                                    <label for="card_number">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number" value="{{base64_decode($cardInfo[0]->card_number)}}">
                                </div>
                                <div class="form-group">
                                    <label for="cw2">cw2</label>
                                    <input type="text" class="form-control" id="cw2" name="cw2" value="{{base64_decode($cardInfo[0]->cw2)}}">
                                </div>
                                <div class="form-group">
                                    <label for="issue_to">Issued To</label>
                                    <input type="date" class="form-control" id="issue_to" name="issue_to" value="{{$cardInfo[0]->issue_to}}">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width:150px;">Currency</span>
                                    <select name="currency" class="form-control" value="{{$cardInfo[0]->currency_id}}">
                                        @foreach($currencies as $currency)
                                        <option
                                                @if($cardInfo[0]->currency_id==$currency->id)selected="selected"@endif
                                                value="{{$currency->id}}">
                                            {{$currency->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width:150px;">User</span>
                                    <select name="user_id" class="form-control" value="{{$cardInfo[0]->user_id}}">
                                        <option value="0">Please select user</option>
                                        @foreach($users as $user)
                                            <option
                                                    @if($cardInfo[0]->user_id==$user->id)selected="selected"@endif
                                            value="{{$user->id}}">
                                                {{$user->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>

                                <button type="submit" class="btn btn-success">Update Card</button>
                            </form>
                            @include('layouts/errors')
                        @else
                            No Cards Information
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection