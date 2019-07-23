{{--
Inside row
Gets $client variable

--}}


<div class="col-xl-3 col-md-6 mb-4"
     id="client_card_{{$client->id}}"
     data-keywords="{{strtolower($client->name)}}{{strtolower($client->city)}}{{strtolower($client->address)}}{{strtolower($client->phone)}}">
    <div class="card shadow-sm">


        <div class="card-img-top text-center text-info pt-5 pb-3">
            <i class="fas fa-6x fa-user-circle"></i>
        </div>
        <div class="card-body text-center">


            <div class="row text-center">
                <div class="col">
                    <h5 class="card-title py-0 mb-2"
                        style="height: 2rem; line-height: 1.1rem">{{mb_strimwidth($client->name, 0, 45, '...')}}</h5>
                    <p class="card-text py-0"
                       style="height: 2.2rem; line-height: 1.1rem">{{mb_strimwidth($client->city, 0, 45, '...')}}</p>

                </div>
            </div>
            <div class="row text-center mt-3">
                <div class="col-6">
                    <a href="{{route('client.show',$client->id)}}"
                       class="btn btn-sm btn-outline-primary w-100">Shiqo</a>


                </div>
                <div class="col-6">
                    <a href="#" class="btn btn-sm btn-outline-danger w-100"
                       onclick="delete_client_card({{$client->id}})">Fshij</a>

                </div>
            </div>
        </div>

    </div>

</div>