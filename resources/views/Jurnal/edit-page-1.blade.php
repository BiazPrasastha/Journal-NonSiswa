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
                    <form class="needs-validation" action="/jurnal/{{$id->id}}/edit-2" method="POST" novalidate>
                        @csrf
                        <div class="form-group col-sm-12">
                            <select class="form-control m-input" name="kelas" required>
                                <option value="">Kelas</option>
                                <option value="10" @if ($tingkat==10) selected @endif>10</option>
                                <option value="11" @if ($tingkat==11) selected @endif>11</option>
                                <option value="12" @if ($tingkat==12) selected @endif>12</option>
                            </select>
                            <div class="invalid-feedback">Kelas Harus Diisi !</div>
                        </div>

                        <div class="form-group col-sm-12">
                            <select class="form-control m-input" name="jurusan" required>
                                <option value="">Jurusan</option>
                                <option value="RPL" @if ($jurusan=="RPL" ) selected @endif>RPL</option>
                                <option value="TKJ" @if ($jurusan=="TKJ" ) selected @endif>TKJ</option>
                                <option value="MM" @if ($jurusan=="MM" ) selected @endif>MM</option>
                                <option value="AKL" @if ($jurusan=="AKL" ) selected @endif>AKL</option>
                                <option value="OTP" @if ($jurusan=="OTP" ) selected @endif>OTP</option>
                                <option value="BDP" @if ($jurusan=="BDP" ) selected @endif>BDP</option>
                                <option value="UPW" @if ($jurusan=="UPW" ) selected @endif>UPW</option>
                                <option value="TBO" @if ($jurusan=="TBO" ) selected @endif>TBO</option>
                            </select>
                            <div class="invalid-feedback">Jurusan Harus Diisi !</div>
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
