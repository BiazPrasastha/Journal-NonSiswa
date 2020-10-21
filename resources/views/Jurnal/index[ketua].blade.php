@extends('Template.template')

@section('title')
Data Siswa | Journal
@endsection
@section('content')
<div class="container">
    <!-- Header -->
    <div class="header">
        <h3>Jurnal</h3>
        <form action="" method="get">
            <div class="form-group">
                <input type="date" class="form-control datepicker" id="date" name="date" value="{{$dx}}">
                <button type="submit" class="btn filters">
                    <i class="fas fa-filter"></i>
                </button>
                @if ($jam == "home")
                <button type="button" class="btn danger">
                    <i class="fas fa-minus"></i>
                </button>
                @elseif($jam == "break")
                <button type="button" class="btn danger">
                    <i class="fas fa-minus"></i>
                </button>
                @elseif($tombol == "disable")
                <button type="button" class="btn danger">
                    <i class="fas fa-minus"></i>
                </button>
                @else
                <button type="button" class="btn tambah" data-toggle="modal" data-target="#modalscrollable">
                    <i class="fas fa-plus"></i>
                </button>
                @endif
            </div>
        </form>
    </div>
    <!-- Content -->
    <div class="konten">
        <div class="unverify mb-4">
            @if (!$jurnal_invalid->isEmpty())
            <div class="top">
                <h5>Jurnal Belum Terverifikasi</h5>
                <span class="mb-3"></span>
            </div>
            @endif

            @forelse ($jurnal_invalid as $jurnals)
            <div class="list">
                <div class="item">
                    <a class="item-swipe itemDesk" href="#navCtrl" data-toggle="modal">
                        <div class="jamke">
                            {{str_pad($jurnals->jam, 2, "0", STR_PAD_LEFT)}} - {{$jurnals->guru->kode}}
                        </div>
                        <div class="mapel">{{$jurnals->mapel->mapel}}</div>
                    </a>
                    <div class="modal fade" id="navCtrl" tabindex="-1" role="modal" aria-labelledby="myModal"
                        width="100%">
                        <div class="modal-dialog modal-sm modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                </div>
                                <div class="modal-body">
                                    <div class="form-group text-center" style="display: flex">
                                        <button class="btn btn-detail mr-2" type="button" style="flex: 1;">
                                            <a href="/jurnal/{{$jurnals->id}}/info">
                                                <span class="material-icons">info</span>
                                                <div class="link-action">
                                                    <h6>
                                                        Detail
                                                    </h6>
                                                </div>
                                            </a>
                                        </button>
                                        <button class="btn btn-acc mr-2" type="button" style="flex: 1;">
                                            <a href="/jurnal/{{$jurnals->id}}/accept">
                                                <span class="material-icons">assignment_turned_in</span>
                                                <div class="link-action">
                                                    <h6>
                                                        Accept
                                                    </h6>
                                                </div>
                                            </a>
                                        </button>
                                        <button class="btn btn-edit delete-confirm" type="button" style="flex: 1;">
                                            <a href="/jurnal/{{$jurnals->id}}/edit">
                                                <span class="material-icons">edit</span>
                                                <div class="link-action">
                                                    <h6>
                                                        Edit
                                                    </h6>
                                                </div>
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="item-swipe swipe-two itemMobile" href="/jurnal/{{$jurnals->id}}/info">
                        <div class="jamke">
                            {{str_pad($jurnals->jam, 2, "0", STR_PAD_LEFT)}} - {{$jurnals->guru->kode}}
                        </div>
                        <div class="mapel">{{$jurnals->mapel->mapel}}</div>
                    </a>
                    <div class="item-back">
                        <button class="action second btn-acc" type="button">
                            <a href="/jurnal/{{$jurnals->id}}/accept">
                                <span class="material-icons">assignment_turned_in</span>
                            </a>
                        </button>
                        <button class="action first btn-edit" type="button">
                            <a href="/jurnal/{{$jurnals->id}}/edit">
                                <span class="material-icons">edit</span>
                            </a>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>

        <div class="verify mb-4">
            <div class="top">
                <h5>Jurnal Terverifikasi</h5>
                <span class="mb-3"></span>
            </div>
            @forelse ($jurnal_valid as $jurnals)
            <div class="list">
                <div class="item">
                    <a href="/jurnal/{{$jurnals->id}}/info" class="item-swipex">
                        <div class="jamke">
                            {{str_pad($jurnals->jam, 2, "0", STR_PAD_LEFT)}} - {{$jurnals->guru->kode}}
                        </div>
                        <div class="mapel">{{$jurnals->mapel->mapel}}</div>
                    </a>
                    <a class="item-swipex itemMobile" href="/jurnal/{{$jurnals->id}}/info">
                        <div class="jamke">
                            {{str_pad($jurnals->jam, 2, "0", STR_PAD_LEFT)}} - {{$jurnals->guru->kode}}
                        </div>
                        <div class="mapel">{{$jurnals->mapel->mapel}}</div>
                    </a>
                </div>
            </div>
            @empty
            <div class="list">
                <div class="item">
                    <a class="item-swipex" href="#">
                        <center>
                            Jurnal Terverifikasi Kosong
                        </center>
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Modal Section -->
        <div class="modal fade" id="modalscrollable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" width="100%">
            <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            Tambah Jurnal.
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" action="/jurnal/create-post" method="POST" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group col-sm-12">
                                        <select class="form-control m-input" name="mapel" required>
                                            <option value="">Mata Pelajaran</option>
                                            @foreach ($mpl as $mapels)
                                            <option value="{{$mapels->id}}">{{$mapels->mapel}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Mapel Harus Diisi !</div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <select class="form-control m-input" name="guru" required>
                                            <option value="">Guru Mata Pelajaran</option>
                                            @foreach ($gr as $gurus)
                                            <option value="{{$gurus->id}}">{{$gurus->nama}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Guru Mapel Harus Diisi !</div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <input type="text" class="form-control" name="materi"
                                            placeholder="Materi Yang Diberikan" autocomplete="off" required>
                                        <div class="invalid-feedback">Materi Harus Diisi !</div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <input type="text" class="form-control" name="keterangan"
                                            placeholder="Keterangan" autocomplete="off">
                                    </div>
                                    <div class="form-group col-sm-12" style="align-items: flex-end">
                                        <div class="input-group btn-form">
                                            <button type="submit" class="btn btn-success btn-submit mr-3">
                                                <i class="fas fa-plus"></i>Tambah Jurnal
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
        {{-- end --}}
    </div>


    @endsection
