@extends('Template.template')

@section('title')
Edit Jurnal | Journal
@endsection

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="header" style="border-bottom: none;">
        <h3>Edit Jurnal</h3>
    </div>

    <!-- Content -->
    <div class="konten"
        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 350px;">
        <div class="col-lg-12">
            <div class="card mx-auto">
                <div class="card-body">
                    <form class="needs-validation" action="/jurnal/{{$id->id}}/edit-post" method="post" novalidate>
                        @csrf
                        <div class="form-group col-sm-12">
                            <select class="form-control m-input" name="kelas_id" required>
                                <option value="">Kelas</option>
                                @foreach ($kelas as $cls)
                                <option value="{{$cls->id}}" @if ($cls->id == $kls) selected
                                    @endif>{{$cls->kelas}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Kelas Harus Diisi !</div>
                        </div>

                        <div class="form-group col-sm-12">
                            <select class="form-control m-input" name="mapel_id" required>
                                <option value="">Mata Pelajaran</option>
                                @foreach ($mapel as $mapels)
                                <option value="{{$mapels->id}}" @if ($mapels->id==$id->mapel_id) selected
                                    @endif>{{$mapels->mapel}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Mapel Harus Diisi !</div>
                        </div>

                        <div class="form-group col-sm-12">
                            <input type="text" class="form-control" name="materi" placeholder="Materi Yang Diberikan"
                                autocomplete="off" value="{{$id->materi}}" required>
                            <div class="invalid-feedback">Materi Harus Diisi !</div>
                        </div>

                        <div class="form-group col-sm-12">
                            <input type="text" class="form-control" name="keterangan" placeholder="Keterangan"
                                value="{{$id->keterangan == null ? "-" : $id->keterangan}}" autocomplete="off">
                        </div>
                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-success btn-block">
                                Selanjutnya
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
