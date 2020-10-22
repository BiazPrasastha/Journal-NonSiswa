@extends('Template.template')

@section('title')
Edit Data Guru | Journal
@endsection

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="header" style="border-bottom: none;">
        <h3>Edit Data Guru</h3>
    </div>

    <!-- Content -->
    <div class="konten" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="col-lg-12">
            <div class="card mx-auto">
                <div class="card-body">
                    <form class="needs-validation" action="/guru/{{$id->id}}/edit-post" method="post" novalidate>
                        @csrf
                        <div class="form-group col-sm-12">
                            <label>Nama Guru</label>
                            <input type="text" class="form-control" name="nama" value="{{$id->nama}}"
                                onkeypress="return goodchars(event, 'abcdefghijklmnopqrstuvwxyz .,', this)" required>
                            <div class="invalid-feedback">Nama Guru Tidak Boleh Kosong.</div>
                        </div>

                        <div class="form-group col-lg-12">
                            <label>Kode Guru</label>
                            <input type="text" class="form-control" name="kode" value="{{$id->kode}}"
                                onkeypress="return goodchars(event, 'abcdefghijklmnopqrstuvwxyz .,', this)" required>
                            <div class="invalid-feedback">Kode Tidak Boleh Kosong.</div>
                        </div>

                        <div class="form-group col-lg-12">
                            <button type="submit" name="submit" class="btn btn-success btn-block">
                                <span class="fas fa-edit"></span> Edit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
