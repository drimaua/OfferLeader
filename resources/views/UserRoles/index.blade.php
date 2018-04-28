@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User List</div>
                    <div class="card-body">
                        @if(count($users))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead><tr>
                                        <th>User Name</th><th>E-mail</th><th>Roles</th><th>Manage</th>
                                    </tr></thead>
                                    <tbody>
                                    @foreach($users as $id=>$user)
                                        <tr>
                                            <td>{{$user['name']}}</td>
                                            <td>{{$user['email']}}</td>
                                            <td>
                                                @foreach($user['roles'] as $role)
                                                    <p>{{$role}}</p>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="/admin/{{$id}}" class="btn btn-info" style="padding: 6px;">Roles</a>
                                                <a href="/statistics/{{$id}}" class="btn btn-success" style="padding: 6px;">Stat</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection