@extends('Template.template')

@section('title')
Edit Data Siswa | Journal
@endsection

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="header" style="border-bottom: none;">
        <h3>Edit Data Siswa</h3>
    </div>

    <!-- Content -->
    <div class="konten" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="col-lg-12">
            <div class="card mx-auto">
                <div class="card-body">
                    <form class="needs-validation" action="/siswa/{{$id->id}}/edit-post" method="post" novalidate>
                        @csrf
                        <div class="form col-sm-12 mb-3">
                            <label>NIS</label>
                            <input type="text" class="form-control" name="id" value="{{$id->id}}"
                                onkeypress="return goodchars(event, '0123456789', this)" required>
                            <div class="invalid-feedback">NIS Tidak Boleh Kosong.</div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label>Nama Siswa</label>
                            <input type="text" class="form-control" name="nama" value="{{$id->nama}}"
                                onkeypress="return goodchars(event, 'abcdefghijklmnopqrstuvwxyz .,', this)" required>
                            <div class="invalid-feedback">Nama Siswa Tidak Boleh Kosong.</div>
                        </div>

                        <div class="form-group col-lg-12">
                            <label>Kelas</label>
                            <select class="form-control" name="kelas_id" required>
                                @forelse ($cls as $kelas)

                                <option value="{{$kelas->id}}">{{$kelas->kelas}}</option>
                                @empty
                                <option value="">Kelas Belum Ada</option>
                                @endforelse
                            </select>
                            <div class="invalid-feedback">Kelas Tidak Boleh Kosong.</div>
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
