@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="panel"  style="padding: 10px">
                    <div class="panel-header">
                        <h2>Изменить пользователя</h2>
                        <a  class="btn btn-primary btn-sm" href="{{route('user.index')}}">Назад</a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <form action="{{Route::currentRouteName() == 'self.user.edit' ? route('self.user.update') : route('user.update' ,['id'=>$user->id])}}" method="post">
                                    <div class="form-group">
                                        <label for="name">Имя</label>
                                        <input type="text" value="{{$user->first_name}}" name="first_name" class="form-control" placeholder="Имя" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Фамилия</label>
                                        <input type="text" value="{{$user->last_name}}" name="last_name" class="form-control" placeholder="Фамилия" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number">Номер телефона</label>
                                        <input type="text" value="{{$user->phone_number}}" name="phone_number" class="form-control" placeholder="Номер телефона" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" disabled="disabled" value="{{$user->email}}" class="form-control" placeholder="Email" required>
                                    </div>
                                    @if(\Illuminate\Support\Facades\Auth::user()->untouchable)
                                    <div class="form-group">
                                        <label for="role">Роль</label>
                                        <select name="role_id" class="form-control">
                                            @foreach($roles as $role)
                                                <option {{$role->id==$user->role_id ? "selected" : ""}} value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary btn-block" value="Изменить">
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <form action="{{Route::currentRouteName() == 'self.user.updatePassword' ? route('self.user.updatePassword') : route('user.updatePassword' ,['id'=>$user->id])}}" method="post">
                                    <div class="form-group">
                                        <label for="name">Пароль</label>
                                        <input type="password" name="password" class="form-control" placeholder="Пароль" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Повторите пароль</label>
                                        <input type="password" name="repassword" class="form-control" placeholder="Повторите пароль" required>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary btn-block" value="Изменить">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        @if ($errors->any())
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