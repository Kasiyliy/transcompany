@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-header">
                        <h2>Изменить транспортное средство</h2>
                        <a class="btn btn-primary btn-sm" href="{{route('vehicle.index')}}">Назад</a>
                    </div>
                    <div class="panel-body">
                        <form action="{{route('vehicle.update', ['id' => $vehicle->id])}}" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Государственный номер транспортного средства</label>
                                        <input type="number" name="license_plate" value="{{$vehicle->license_plate}}"
                                               class="form-control"
                                               placeholder="Номер" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Статус</label>
                                        <select name="status" required class="form-control">
                                            <option {{$vehicle->status === 'На погрузке' ? "selected" : '' }}>На погрузке</option>
                                            <option {{$vehicle->status === 'В пути(едет)' ? "selected" : '' }}>В пути(едет)</option>
                                            <option {{$vehicle->status === 'Выгружен' ? "selected" : '' }}>Выгружен</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="name">Описание</label>
                                        <textarea class="form-control" name="description" required>{{$vehicle->description}}</textarea>
                                    </div>
                                </div>
                                {{--<div class="col-md-6">--}}

                                    {{--<div class="form-group">--}}
                                        {{--<label for="name">Выберите с карты местоположение?</label>--}}
                                        {{--<div id="map" style="width: 100%; height: 400px">--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="longitude">Долгота</label>--}}
                                            {{--<input type="text" class="form-control" readonly id="longitude"--}}
                                                   {{--value="{{$vehicle->longitude}}" name="longitude"--}}
                                                   {{--placeholder="Longitude" required>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="latitude">Широта</label>--}}
                                            {{--<input type="text" name="latitude" readonly class="form-control"--}}
                                                   {{--value="{{$vehicle->latitude}}" id="latitude" placeholder="Latitude"--}}
                                                   {{--required>--}}
                                        {{--</div>--}}

                                    {{--</div>--}}
                                {{--</div>--}}


                                {{csrf_field()}}
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success btn-block" value="Изменить">
                                </div>
                            </div>
                        </form>
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



@section('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?apikey=b644cebb-e397-49c0-9e0e-f304bd3e04c2&lang=ru_RU"
            type="text/javascript"></script>


    <script type="text/javascript">
        ymaps.ready(init);

        function init() {
            var myPlacemark,
                myMap = new ymaps.Map('map', {
                    center: [48.005284, 66.9045434],
                    zoom: 5
                }, {
                    searchControlProvider: 'yandex#search'
                });

            // Слушаем клик на карте.
            myMap.events.add('click', function (e) {
                var coords = e.get('coords');
                putMark(coords);
            });

            function putMark(coords) {

                if (myPlacemark) {
                    myPlacemark.geometry.setCoordinates(coords);
                }
                // Если нет – создаем.
                else {
                    myPlacemark = createPlacemark(coords);
                    myMap.geoObjects.add(myPlacemark);
                    // Слушаем событие окончания перетаскивания на метке.
                    myPlacemark.events.add('dragend', function () {
                        getAddress(myPlacemark.geometry.getCoordinates());
                    });
                }
                document.getElementById("latitude").value = coords[0];
                document.getElementById("longitude").value = coords[1];
                getAddress(coords);
            }

            // Создание метки.
            function createPlacemark(coords) {
                return new ymaps.Placemark(coords, {
                    iconCaption: 'поиск...'
                }, {
                    preset: 'islands#violetDotIconWithCaption',
                    draggable: true
                });
            }

            // Определяем адрес по координатам (обратное геокодирование).
            function getAddress(coords) {
                myPlacemark.properties.set('iconCaption', 'поиск...');
                ymaps.geocode(coords).then(function (res) {
                    var firstGeoObject = res.geoObjects.get(0);

                    myPlacemark.properties
                        .set({
                            // Формируем строку с данными об объекте.
                            iconCaption: [
                                // Название населенного пункта или вышестоящее административно-территориальное образование.
                                firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                                // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                                firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                            ].filter(Boolean).join(', '),
                            // В качестве контента балуна задаем строку с адресом объекта.
                            balloonContent: firstGeoObject.getAddressLine()
                        });
                });
            }

            $(document).ready(function () {
                putMark([{{$vehicle->latitude}}, {{$vehicle->longitude}}]);
            });

        }
    </script>
@endsection