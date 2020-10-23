@extends('Template.template')

@section('title')
Tambah Absensi | Journal
@endsection

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="header" style="border-bottom: none;">
        <h3>Tambah Absen</h3>
        <h6>{{$id->mapel->mapel}}</h6>
        <h6>Jamke - {{$id->jam}}</h6>
    </div>

    <!-- Content -->
    <div class="konten" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="col-lg-12">
            <div class="card mx-auto">
                <div class="card-body">
                    <form class="needs-validation" action="/jurnal/{{$id->id}}/add-absen-post" method="post" novalidate>
                        @csrf
                        <div class="form-group col-sm-12 fieldGroup">
                            <div id="formRow">
                                <div class="input-group mb-3">
                                    <select class="form-control m-input" name="absen[]">
                                        <option value="">Absen Siswa</option>
                                        @foreach ($siswa as $siswas)
                                        <option value="{{$siswas->id}}">{{$siswas->nama}}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control m-inputx" name="abs[]">
                                        <option value="#" class="centerx">Ket</option>
                                        <option value="Sakit" class="centerx">S</option>
                                        <option value="Ijin" class="centerx">I</option>
                                        <option value="Alpha" class="centerx">A</option>
                                    </select>
                                    <div class="input-group-addon">
                                        <a href="javascript:void(0)" class="btn btn-infox addMore"><span
                                                class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span><i
                                                class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <div class="input-group btn-form">
                                <button type="submit" class="btn btn-success btn-submit btn-block">
                                    <i class="fas fa-plus"></i>Tambah Jurnal
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="form-group col-sm-12 fieldGroupCopy" style="display: none">
                        <div id="formRow">
                            <div class="input-group mb-3">
                                <select class="form-control m-input" name="absen[]">
                                    <option value="">Absen Siswa</option>
                                    @foreach ($siswa as $siswas)
                                    <option value="{{$siswas->id}}">{{$siswas->nama}}</option>
                                    @endforeach
                                </select>
                                <select class="form-control m-inputx" name="abs[]">
                                    <option value="#" class="centerx">Ket</option>
                                    <option value="Sakit" class="centerx">S</option>
                                    <option value="Ijin" class="centerx">I</option>
                                    <option value="Alpha" class="centerx">A</option>
                                </select>
                                <div class="input-group-addon">
                                    <a href="javascript:void(0)" class="btn btn-danger remove"><span
                                            class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        <i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
