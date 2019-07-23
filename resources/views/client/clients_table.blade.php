{{--
Inside card body div

Gets $clients variable named




--}}


<div class="table-responsive">

    <table id="clientsTable" class="table table-sm table-striped table-bordered">
        <thead>
        <tr>
            <th>Emri</th>
            <th>Telefoni</th>
            <th>Qyteti</th>

            <th>Shtuar me:</th>

            <th>Veprimet</th>
        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr id="client_{{$client->id}}">
                <td>{{$client->name}}</td>
                <td>{{$client->phone}}</td>
                <td>{{$client->city}}</td>

                <td>{{$client->created_at}}</td>
                <td>
                    <div class="btn-group-sm text-center">
                        <a href="client/{{$client->id}}"
                           class="font-weight-bold text-uppercase  btn-sm btn-outline-primary">Shiqo</a>
                        <a href=""
                           class="font-weight-bold text-uppercase  btn-sm btn-outline-danger"
                           onclick="event.preventDefault();
                                   if(confirm('Konfirmo fshirjen e klientit')){
                                   axios({
                                   method: 'post',
                                   url: '/client/'+'{{$client->id}}',
                                   data: {
                                   _method: 'DELETE'
                                   }
                                   }).then(function () {

                                   clientsTable.row( $('#client_{{$client->id}}')).remove();
                                   clientsTable.draw();
                                   // location.reload();

                                   })
                                   .catch(function (error) {
                                   console.log(error);
                                   });

                                   }

                                   ">Fshij</a>
                    </div>
                </td>

            </tr>

        @endforeach


        </tbody>
    </table>

</div>