{{--Inside div row--}}

{{--Accepts $file named-variable--}}

<div class="col-xl-3 col-md-6 mb-4" id="file_card_{{$file->id}}">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="btn-group-sm float-right">
                <a href="{{route('file.show',$file->id)}}" class="font-weight-bold text-uppercase btn-sm btn-outline-dark">Detaje</a>
                <a href="" class="font-weight-bold text-uppercase btn-sm btn-outline-danger" onclick="event.preventDefault();
                        delete_file_card({{$file->id}})
                        ">Fshij</a>
            </div>
        </div>
        <div class="card-body pb-2">
            <div class="row no-gutter">
                <div class="col">
                    <p style="height: 1.5rem; line-height: 1rem">
                    <a href="{{route('file.show',$file->id)}}" class="font-weight-bold text-uppercase text-dark mb-1">{{mb_strimwidth($file->name , 0, 30, '...')}}</a>
                    </p>
                    <p class="font-weight-light mb-4" style="height: 2.5rem; line-height: 1rem">{{mb_strimwidth($file->description , 0, 90, '...')}}</p>
                </div>

            </div>
            <div class="row mb-1">

                <div class="col-9">
                    <p class="small font-weight-light m-0 p-0 w-100">Date: {{\Carbon\Carbon::parse($file->created_at)->format('d.m.y')}}</p>

                    <p class="small font-weight-light m-0 p-0 w-100">Shtuar nga: {{explode(' ',trim($file->user->name))[0]}}</p>
                </div>
                <div class="col-3 text-right">
                    @if($file->file_extension()=="PDF")
                        <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
                    @elseif($file->file_extension()=="DOCX" || $file->file_extension()=="DOC")
                        <i class="fas fa-file-word fa-2x text-gray-300"></i>
                    @elseif($file->file_extension()=="CSV" || $file->file_extension()=="XLSX" || $file->file_extension()=="XLS")
                        <i class="fas fa-file-excel fa-2x text-gray-300"></i>
                    @elseif($file->file_extension()=="JPG" || $file->file_extension()=="JPEG" || $file->file_extension()=="PNG" || $file->file_extension()=="BMP")
                        <i class="fas fa-file-image fa-2x text-gray-300"></i>

                    @elseif($file->file_extension()=="TXT")
                        <i class="fas fa-file-code fa-2x text-gray-300"></i>
                    @else
                        <i class="fas fa-file fa-2x text-gray-300"></i>
                    @endif
                </div>

            </div>
            <div class="row">


                    <a href="{{route('file.download',$file->file)}}" class="btn btn-success btn-icon-split btn-sm w-100 justify-content-start">
                        <span class="icon text-white-100"><i class="fas fa-download"></i></span>
                        <span class="text font-weight-bold mx-auto">Shkarko({{$file->file_extension()}} {{$file->file_size()}}MB)</span>
                    </a>



            </div>

        </div>
    </div>
</div>