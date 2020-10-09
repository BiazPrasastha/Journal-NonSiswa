@extends('Template.template')

@section('title')
Data Siswa | Journal
@endsection
@section('content')
<div class="container-fluid">
    <!-- Header -->
    @if ($errors->any())
    <div class="error">
        <ul style="list-style-type: none">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Content -->
    <div class="konten" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="col-lg-12">
            <div class="card mx-auto">
                <div class="card-header">
                    <img src="{{asset('assets/default.svg')}}" class="profile">
                </div>
                <div class="card-body">
                    <form class="needs-validation" action="" method="" novalidate>
                        <div class="form col-sm-12 mb-4">
                            <label>Role :</label>
                            <input type="text" class="form-control fields" name="roles" value="{{$role}}" readonly>
                            <div class="bb"></div>
                        </div>
                        @if (Auth::user()->role == 3)
                        <div class="form col-sm-12 mb-4">
                            <label>Nama :</label>
                            <input type="text" class="form-control fields" name="klas" value="{{$kelas}}"
                                style="margin-top: 5px" readonly>
                            <div class="bb"></div>
                        </div>
                        @else
                        <div class="form col-sm-12 mb-4">
                            <label>Kelas :</label>
                            <input type="text" class="form-control fields" name="klas" value="{{$kelas}}" readonly>
                            <div class="bb"></div>
                        </div>
                        @endif

                        <div class="form-group col-lg-12">
                            <button type="button" class="btn ganti mb-2" data-toggle="modal"
                                data-target="#modalscrollable2">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                            @if (Auth::user()->role == 2)
                            <button type="button" class="btn ganti mb-2" data-toggle="modal"
                                data-target="#modalscrollable">
                                <i class="fas fa-user-plus"> </i> Daftar Ketua Kelas
                            </button>
                            @endif
                            <a class="btn keluar" href="/logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </form>

                    @if (Auth::user()->role == 2)
                    <form action="/profile/set-jam" method="POST">
                        @csrf
                        <div class="input-group mb-3 col-lg-12">
                            <select class="form-control m-inputx" name="type_jam" required>
                                <option value="Reguler" class="centerx">Reguler</option>
                                <option value="PJJ" class="centerx">PJJ</option>
                            </select>
                            <div class="input-group-addon">
                                <button type="submit" class="btn btn-success btn-submit">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modalscrollable2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" width="100%">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    Ubah Password
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-box">
                    <form action="profile/change-password" method="POST" class="form-horizontal needs-validation"
                        novalidate>
                        @csrf
                        <div class="form-group col-md-12">
                            <label>Password Lama :</label>
                            <input type="password" class="form-control" name="oldPass" required>
                            <div class="invalid-feedback">Harap Isi Password Lama Anda.</div>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Password Baru :</label>
                            <input type="password" class="form-control" name="newPass1" required>
                            <div class="invalid-feedback">Harap Isi Password Baru Anda.</div>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Konfirmasi Password :</label>
                            <input type="password" class="form-control" name="newPass2" required>
                            <div class="invalid-feedback">Password Tidak Sama.</div>
                        </div>

                        <div class="bottom-button">
                            <button type="submit" name="signup" class="btn btn-success">
                                Ubah
                            </button>
                            <button type="button" class="btn btn-danger" id="danger" data-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if (Auth::user()->role == 2)
<!-- Modal Section -->
<div class="modal fade" id="modalscrollable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" width="100%">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    Daftar Ketua Kelas
                </h4>
            </div>
            <div class="modal-body">
                <form class="needs-validation" action="/signup" method="POST" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group col-sm-12">
                                <input type="text" class="form-control" name="username" placeholder="Username"
                                    autocomplete="off" required>
                                <div class="invalid-feedback">Username Harus Diisi !</div>
                            </div>
                            <div class="form-group col-sm-12">
                                <select class="form-control m-input" name="kelas" required>
                                    <option value="">Kelas</option>
                                    @foreach ($cls as $kelas)
                                    <option value="{{$kelas->id}}">{{$kelas->kelas}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Kelas Harus Diisi !</div>
                            </div>
                            <div class="form-group col-sm-12">
                                <input type="password" class="form-control" name="pass" placeholder="Password"
                                    autocomplete="off" required>
                                <div class="invalid-feedback">Password Harus Diisi !</div>
                            </div>
                            <div class="form-group col-sm-12">
                                <input type="password" class="form-control" name="pass1"
                                    placeholder="Konfirmasi Password" autocomplete="off" required>
                                <div class="invalid-feedback">Konfirmasi Password Harus Diisi !</div>
                            </div>
                            <div class="form-group col-sm-12" style="align-items: flex-end">
                                <div class="input-group btn-form">
                                    <button type="submit" class="btn btn-success btn-submit mr-3">
                                        <i class="fas fa-plus"></i>Daftar
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
