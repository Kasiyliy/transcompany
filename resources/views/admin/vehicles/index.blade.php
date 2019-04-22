@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-header">
                        <h2>Транспортные средства</h2>
                        <a class="btn btn-success btn-sm" href="{{route('vehicle.create')}}">Добавить</a>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Наименование</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vehicles as $vehicle)
                                <tr>
                                    <td>{{$vehicle->id}}</td>
                                    <td>{{$vehicle->name}}</td>
                                    <td class="d-flex">
                                        <a href="{{route('vehicle.edit' ,['id'=>$vehicle->id ])}}" class="btn-xs btn btn-primary">Изменить</a>
                                        <a onclick="deleteBtn({{$vehicle->id}})" class="btn-xs btn btn-danger">Удалить</a>
                                        <form method="post" id="form{{$vehicle->id}}" action="{{route('vehicle.delete', ['id'=> $vehicle->id])}}">
                                            {{csrf_field()}}
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function deleteBtn(id){
            bootbox.confirm({
                title: "Вы точно хотите удалить?",
                message: "После удаления данные не вернуть",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Отмена'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Подтвердить'
                    }
                },
                callback: function (result) {
                    if(result){
                        let form = document.getElementById(`form${id}`);
                        form.submit();
                    }
                }
            });
        }
    </script>
@endsection