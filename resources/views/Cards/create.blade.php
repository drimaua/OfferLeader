@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Card information</div>
                    <div class="card-body">
                            <form method="POST" action="/cards">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="card_number">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number">
                                </div>
                                <div class="form-group">
                                    <label for="cw2">cw2</label>
                                    <input type="text" class="form-control" id="cw2" name="cw2">
                                </div>
                                <div class="form-group">
                                    <label for="issue_to">Issued To</label>
                                    <input type="date" class="form-control" id="issue_to" name="issue_to" >
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width:150px;">Currency</span>
                                    <select name="currency" class="form-control">
                                        @foreach($currencies as $currency)
                                            <option value="{{$currency->id}}">
                                                {{$currency->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width:150px;">User</span>
                                    <select name="user_id" class="form-control" value="0">
                                        <option value="0">Please select user</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}"> {{$user->name}}  </option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>

                                <button type="submit" class="btn btn-success">Create Card</button>
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