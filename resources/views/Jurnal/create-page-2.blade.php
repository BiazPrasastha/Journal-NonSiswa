@extends('Template.template')

@section('title')
Tambah Jurnal | Journal
@endsection

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="header" style="border-bottom: none;">
        <h3>Tambah Jurnal</h3>
    </div>

    <!-- Content -->
    <div class="konten"
        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 350px;">
        <div class="col-lg-12">
            <div class="card mx-auto">
                <div class="card-body">
                    <form class="needs-validation" action="/jurnal/create-post" method="post" novalidate>
                        @csrf
                        <div class="form-group col-sm-12">
                            <select class="form-control m-input" name="kelas" required>
                                <option value="">Kelas</option>
                                @foreach ($kelas as $cls)
                                <option value="{{$cls->id}}">{{$cls->kelas}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Kelas Harus Diisi !</div>
                        </div>

                        <div class="form-group col-sm-12">
                            <select class="form-control m-input" name="mapel" required>
                                <option value="">Mata Pelajaran</option>
                                @foreach ($mapel as $mapels)
                                <option value="{{$mapels->id}}">{{$mapels->mapel}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Mapel Harus Diisi !</div>
                        </div>

                        <div class="form-group col-sm-12">
                            <input type="text" class="form-control" name="materi" placeholder="Materi Yang Diberikan"
                                autocomplete="off" required>
                            <div class="invalid-feedback">Materi Harus Diisi !</div>
                        </div>

                        <div class="form-group col-sm-12">
                            <input type="text" class="form-control" name="keterangan" placeholder="Keterangan"
                                autocomplete="off">
                        </div>

                        <div class="form-group col-lg-12">
                            <button type="submit" name="submit" class="btn btn-success btn-block">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
