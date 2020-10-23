@extends('Template.template')

@section('title')
Edit Absensi | Journal
@endsection

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="header" style="border-bottom: none;">
        <h3>Edit Absen</h3>
        <h6>{{$id->mapel->mapel}}</h6>
        <h6>Jamke - {{$id->jam}}</h6>
    </div>

    <!-- Content -->
    <div class="konten" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="col-lg-12">
            <div class="card mx-auto">
                <div class="card-body">
                    <form class="needs-validation" action="/jurnal/{{$id->id}}/edit-absen-post" method="post"
                        novalidate>
                        @csrf
                        @forelse ($absen as $absens)
                        <div class="form-group col-sm-12 fieldGroup">
                            <div id="formRow">
                                <div class="input-group mb-3">
                                    <select class="form-control m-input" name="absen[]" required>
                                        @php
                                        $x = DB::table('siswa')->where('id','=',$absens->siswa_id)->get();
                                        @endphp
                                        @foreach ($siswa as $siswas)
                                        <option value="{{$siswas->id}}" @if ($siswas->id == $absens->siswa_id)
                                            selected
                                            @endif>{{$siswas->nama}}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control m-inputx" name="abs[]" required>
                                        <option value="Sakit" class="centerx" @if ($absens->keterangan ==
                                            "Sakit")
                                            selected
                                            @endif>S</option>
                                        <option value="Ijin" class="centerx" @if ($absens->keterangan == "Ijin")
                                            selected
                                            @endif>I</option>
                                        <option value="Alpha" class="centerx" @if ($absens->keterangan ==
                                            "Alpha")
                                            selected
                                            @endif>A</option>
                                    </select>
                                    <div class="input-group-addon" style="margin-left: 5px;margin-right:5px;">
                                        <a href="javascript:void(0)" class="btn btn-danger remove"><span
                                                class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            <i class="fas fa-trash"></i></a>
                                    </div>
                                    @if ($loop->first)
                                    <div class="input-group-addon">
                                        <a href="javascript:void(0)" class="btn btn-infox addMore"><span
                                                class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span><i
                                                class="fas fa-plus"></i></a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
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
                        @endforelse

                        <div class="form-group col-sm-12">
                            <div class="input-group btn-form">
                                <button type="submit" class="btn btn-success btn-submit btn-block">
                                    <i class="fas fa-plus"></i>Edit Jurnal
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
