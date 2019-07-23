{{--
Inside card body div

Gets $payments variable named
Gets $tableName variable named




--}}

{{--TODO table copied from clients-table, needs to be costumized for event-table--}}


<div class="table-responsive">

    <table id="{{$tableName}}" class="table table-sm table-striped table-bordered">
        <thead>
        <tr>
            <th>Emri i eventit</th>
            <th>Address</th>
            <th>Data</th>
            <th>Kohezgjatja</th>

{{--            <th>Pershkrimi</th>--}}

            <th>Veprimet</th>
        </tr>
        </thead>
        <tbody>
        @foreach($events as $event)
            <tr id="event_{{$event->id}}">
                <td>{{$event->name}}</td>
                <td>{{$event->address}}</td>
                <td>{{\Carbon\Carbon::parse($event->date_start)->format('d.m.Y',)}}</td>
                <td>{{$event->duration_hours()}} ore</td>

{{--                <td>{{$event->description}}</td>--}}
                <td>
                    <div class="btn-group-sm text-center">
                        <a href="event/{{$event->id}}"
                           class="font-weight-bold text-uppercase  btn-sm btn-outline-primary">Shiqo</a>
                        <a href=""
                           class="font-weight-bold text-uppercase  btn-sm btn-outline-danger"
                           onclick="event.preventDefault();
                                   {{--if(confirm('Konfirmo fshirjen e klientit')){--}}
                                   {{--axios({--}}
                                   {{--method: 'post',--}}
                                   {{--url: '/client/'+'{{$client->id}}',--}}
                                   {{--data: {--}}
                                   {{--_method: 'DELETE'--}}
                                   {{--}--}}
                                   {{--}).then(function () {--}}

                                   {{--clientsTable.row( $('#client_{{$client->id}}')).remove();--}}
                                   {{--clientsTable.draw();--}}
                                   {{--// location.reload();--}}

                                   {{--})--}}
                                   {{--.catch(function (error) {--}}
                                   {{--console.log(error);--}}
                                   {{--});--}}

                                   {{--}--}}

                                   ">Fshij</a>
                    </div>
                </td>

            </tr>

        @endforeach


        </tbody>
    </table>

</div>