@extends('Template.template')

@section('title')
Data Guru | Journal
@endsection

@section('content')

<div class="container">
    <!-- Header -->
    <div class="header" style="border-bottom: none;">
        <h3>
            <div style="border-bottom: 2px solid #81A1C1;margin-bottom:10px;padding-bottom:10px">
                {{$id->mapel->mapel}}
            </div>
            <div style="font-size: 2.2rem">
                Jam ke-{{$id->jam}}
            </div>
        </h3>
        <h6 style="margin-bottom: 50px;margin-top:-20px">{{$id->tanggal}}</h6>
    </div>
    <!-- Content -->
    <div class="konten">
        <div class="col-lg-12">
            <div class="card mx-auto">
                <div class="card-body">
                    <form class="needs-validation" action="/jurnal/{{$id->id}}/edit-post" method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group col-sm-12">
                                    <select class="form-control m-input" name="mapel_id" required>
                                        <option value="">Mata Pelajaran</option>
                                        @foreach ($mpl as $mapels)
                                        <option value="{{$mapels->id}}" @if ($mapels->id ==
                                            $id->mapel_id)selected="selected"@endif>
                                            {{$mapels->mapel}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Mapel Harus Diisi !</div>
                                </div>
                                @if (Auth::user()->role == 1)
                                <div class="form-group col-sm-12">
                                    <select class="form-control m-input" name="guru_id" required>
                                        <option value="">Guru Mata Pelajaran</option>
                                        @foreach ($gr as $gurus)
                                        <option value="{{$gurus->id}}" @if ($gurus->id ==
                                            $id->guru_id)selected="selected"@endif>
                                            {{$gurus->nama}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Guru Mapel Harus Diisi !</div>
                                </div>
                                @elseif(Auth::user()->role == 3)
                                <div class="form-group col-sm-12">
                                    <select class="form-control m-input" name="guru_id" required>
                                        <option value="">Kelas</option>
                                        @foreach ($kls as $kelas)
                                        <option value="{{$kelas->id}}" @if ($kelas->id ==
                                            $id->kelas_id)selected="selected"@endif>
                                            {{$kelas->kelas}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Kelas Harus Diisi !</div>
                                </div>
                                @endif
                                <div class="form-group col-sm-12">
                                    <input type="text" class="form-control" name="materi"
                                        placeholder="Materi Yang Diberikan" value="{{$id->materi}}" autocomplete="off"
                                        required>
                                    <div class="invalid-feedback">Materi Harus Diisi !</div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <input type="text" class="form-control" name="keterangan"
                                        value="{{$id->keterangan == null ? "-" : $id->keterangan}}"
                                        placeholder="Keterangan" autocomplete="off">
                                </div>

                                @foreach ($absen as $absens)
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
                                            <div class="input-group-addon">
                                                <a href="javascript:void(0)" class="btn btn-danger remove"><span
                                                        class="glyphicon glyphicon glyphicon-remove"
                                                        aria-hidden="true"></span>
                                                    <i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="form-group col-sm-12" style="align-items: flex-end">
                                    <div class="input-group btn-form">
                                        <button type="submit" class="btn btn-success btn-submit mr-3">
                                            <i class="fas fa-plus"></i>Edit Jurnal
                                        </button>
                                        <a href="/jurnal">
                                            <button type="button" class="btn btn-secondary">
                                                Batal
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
