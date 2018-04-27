@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User Detail Info: <strong>{{$userByID->name}}</strong></div>
                    <div class="card-body">
                        @if(count($roles))
                        <form method="POST" action="/admin/{{$userByID->id}}">
                            {{csrf_field()}}
                            @foreach($roles as $key=>$role)
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input
                                                    id="role_{{$key}}" name="role_{{$key}}"
                                                    class="form-check-input" type="checkbox"
                                            @if($role['HasPriv'])        checked="checked" @endif
                                            >
                                            {{$role['name']}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-success">Update User</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection