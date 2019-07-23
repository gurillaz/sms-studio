{{--
Inside card body div

Gets $payments variable named
Gets $tableName variable named




--}}

{{--TODO table copied fom clients-table, needs to be costumized for payments-table--}}


<div class="table-responsive">

    <table id="{{$tableName}}" class="table table-sm table-striped table-bordered">
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
        @foreach($payments as $payment)
            <tr id="payment_{{$payment->id}}">
                <td>{{$payment->name}}</td>
                <td>{{$payment->phone}}</td>
                <td>{{$payment->city}}</td>

                <td>{{$payment->created_at}}</td>
                <td>
                    <div class="btn-group-sm text-center">
                        <a href="client/{{$payment->id}}"
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