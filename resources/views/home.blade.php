@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-12">
            <div class="panel">
                <div class="panel-header text-center">Главная</div>

                <div class="panel-body">

                    <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="number" placeholder="Государственный номер" name="license_plate" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="submit" value="Поиск" class="form-control btn btn-primary">
                                    </div>
                                </div>
                            </div>
                    </form>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <section class="content">
                <!-- Info boxes -->
                <div class="row">
                    @foreach($vehicles as $vehicle )
                        <div class="panel">
                            <div class="panel-header">
                                <h3><label for="">Государственный номер:</label> {{$vehicle->license_plate}}</h3>
                                <span> <label for="">Статус: </label> {{$vehicle->status}}</span>
                            </div>
                            <div class="panel-body">
                                <div id="map{{$vehicle->id}}" style="width: 100%; height: 650px">
                            </div>
                            <div class="panel-footer">
                                <p>
                                     Описание: {{$vehicle->description}}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?apikey=b644cebb-e397-49c0-9e0e-f304bd3e04c2&lang=ru_RU"
            type="text/javascript"></script>


    <script type="text/javascript">
        @foreach($vehicles as $vehicle )
        ymaps.ready(init{{$vehicle->id}});

        function init{{$vehicle->id}}() {
            var myPlacemark,
                myMap = new ymaps.Map('map{{$vehicle->id}}', {
                    center: [48.005284, 66.9045434],
                    zoom: 5
                }, {
                    searchControlProvider: 'yandex#search'
                });

            function putMark{{$vehicle->id}}(coords) {

                if (myPlacemark) {
                    myPlacemark.geometry.setCoordinates(coords);
                }
                // Если нет – создаем.
                else {
                    myPlacemark = createPlacemark{{$vehicle->id}}(coords);
                    myMap.geoObjects.add(myPlacemark);
                    // Слушаем событие окончания перетаскивания на метке.
                    myPlacemark.events.add('dragend', function () {
                        getAddress{{$vehicle->id}}(myPlacemark.geometry.getCoordinates());
                    });
                }
                getAddress{{$vehicle->id}}(coords);
            }

            // Создание метки.
            function createPlacemark{{$vehicle->id}}(coords) {
                return new ymaps.Placemark(coords, {
                    iconCaption: 'поиск...'
                }, {
                    preset: 'islands#violetDotIconWithCaption',
                    draggable: true
                });
            }

            // Определяем адрес по координатам (обратное геокодирование).
            function getAddress{{$vehicle->id}}(coords) {
                myPlacemark.properties.set('iconCaption', 'поиск...');
                ymaps.geocode(coords).then(function (res) {
                    var firstGeoObject = res.geoObjects.get(0);

                    myPlacemark.properties
                        .set({
                            // Формируем строку с данными об объекте.
                            iconCaption: 'Машина тут: ' +  [
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
                putMark{{$vehicle->id}}([{{$vehicle->latitude}}, {{$vehicle->longitude}}]);
            });

        }
        @endforeach
    </script>
@endsection
