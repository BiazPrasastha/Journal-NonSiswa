@extends('Template.template')

@section('title')
Data Guru | Journal
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
                    <form class="needs-validation" action="" method="post" novalidate>
                        @csrf
                        <div class="form-group col-sm-12">
                            <select class="form-control m-input" name="kelas" required>
                                <option value="">Kelas</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <div class="invalid-feedback">Kelas Harus Diisi !</div>
                        </div>

                        <div class="form-group col-sm-12">
                            <select class="form-control m-input" name="jurusan" required>
                                <option value="">Jurusan</option>
                                <option value="RPL">RPL</option>
                                <option value="TKJ">TKJ</option>
                                <option value="MM">MM</option>
                                <option value="AKL">AKL</option>
                                <option value="OTP">OTP</option>
                                <option value="BDP">BDP</option>
                                <option value="UPW">UPW</option>
                                <option value="TBO">TBO</option>
                            </select>
                            <div class="invalid-feedback">Jurusan Harus Diisi !</div>
                        </div>

                        <div class="form-group col-lg-12">
                            <button type="submit" name="submit" class="btn btn-success btn-block">
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
